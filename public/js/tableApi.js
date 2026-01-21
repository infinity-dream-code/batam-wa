function updateFilter(urlApi) {
    // var queryParam = $("#searchForm").serialize();
    // var currentHrefPdf = $("#export-pdf").attr('data-base-url')
    // $("#export-pdf").attr('href', currentHrefPdf + "?" + queryParam)
    // var queryParam = $("#searchForm").serialize();
    // var currentHrefExcel = $("#export-excel").attr('data-base-url')
    // $("#export-excel").attr('href', currentHrefExcel + "?" + queryParam)
    table(urlApi)
}

function table(urlApi) {
    let datastring = $("#searchForm").serialize();
    let url = urlApi
    let paginateTable = "#pagination-footer";
    const tableBody = $(".table-tbody")
    let htmlTable = "";
    tableBody.html('processing...')
    const formatKeys = ['debet', 'kredit', 'total', 'harga', 'pokok', 'saldo', 'simpanan'];

    $.ajax({
        type: "GET",
        url: url,
        data: datastring,
        contentType: false,
        processData: false,
        cache: false,
        success: function (responses) {

            let forcePrimary = responses.force_primary || [];
            let dataQueries = responses.data_queries || [];
            let dataColumns = responses.data_columns || [];
            const uniqueDataColumns = [];

            let extraButtons = responses.extra_buttons || [];
            let dataPermissions = responses.data_permissions || [];
            let currentPage = responses.current_page || [];

            var intActionCol = 0;
            if (dataQueries.data.length === 0) {
                htmlTable += `
                    <tr class="text-center">
                        <td colspan="6">Data kosong</td>
                    </tr>
                `;

                tableBody.html(htmlTable);
            } else {
                $.each(dataQueries.data, function (key, item) {
                    var primaryKey = forcePrimary ? item[forcePrimary] : item.id;

                    var numb =
                        1 +
                        key +
                        (dataQueries.current_page - 1) * dataQueries.per_page;
                    htmlTable += "<tr>";

                    htmlTable += "<td class='sort-nama'>" + numb +
                        "</td>"
                    $.each(item, function (key, a) {

                        let foundUnique = false;

                        $.each(dataColumns, function (keydc, dc) {
                            if (key === dc) {
                                foundUnique = true;
                            }
                        });

                        if (foundUnique) {
                            if (!a) {
                                htmlTable += "<td class='sort-" + key + "'>" + "-" +
                                    "</td>"
                                htmlTable += "</td>";
                            } else {
                                if (Number.isInteger(a) && key !== 'nak') {
                                    a = formatKeys.includes(key) ? formatIndonesianNumber(a) : a;
                                    htmlTable += `<td class="sort-${key} text-end">${a}</td>`;
                                } else if (key === 'created_at' || key === 'updated_at' || key === 'tanggal_belanja') {
                                    const dateObj = new Date(a);
                                    const options = {day: 'numeric', month: 'long', year: 'numeric'};
                                    const localDate = dateObj.toLocaleString('id-ID', options);
                                    htmlTable += `<td>${localDate}</td>`
                                } else {
                                    htmlTable += `<td>${a}</td>`
                                }
                                }
                                htmlTable += "</td>";
                            }
                        }
                    )

                    $.each(extraButtons, function (key4, eb) {
                        htmlTable += "<td>";
                        htmlTable += createButton(item, eb)
                        htmlTable += "</td>";
                    });
                    htmlTable += "</tr>";
                });
                $(".count-total").text(
                    "Total Data : " + dataQueries.total
                );

                // onClick='generateUpdate(" +
                //         item.id + ")'

                tableBody.html(htmlTable);
                tableBody.css("opacity", "1");
                $(paginateTable).html(
                    generatePaginate(
                        "list-daftar",
                        dataQueries.current_page,
                        dataQueries.links
                    )
                );
                if (dataQueries.data.length === 0) {
                    $(paginateTable).html("");
                }
                // }
                if (intActionCol === 0) {
                    $("list-daftar" + " .col-action").remove();
                }
                // $(".idev-loading").remove();
                // $("button").removeAttr("disabled");
            }

        },

        error: function (xhr, status, error) {
            $(".progress-loading").remove();
            $("button").removeAttr("disabled");
            var messageErr = "Something Went Wrong";
            if (xhr.responseJSON) {
                messageErr =
                    xhr.responseJSON.message === "" ?
                        xhr.responseJSON.exception :
                        xhr.responseJSON.message;
            }
            $(".table-responsive").html(
                "<div class='card'><div class='card-body'><strong class='text-danger'>" +
                messageErr +
                "</strong></div></div>"
            );
        },
    });
}

function formatIndonesianNumber(number) {
    return 'Rp. ' + number.toLocaleString('id-ID');
}

function generatePaginate(formId, current, pages) {
    let htmlPaginate = '<ul class="pagination">';
    $.each(pages, function (key, item) {
        let isCurrent
        let disabled
        if (current === parseInt(item.label, 10)) {
            isCurrent = "active"
            disabled = "disabled"
        } else {
            isCurrent = ""
            disabled = ""
        }
        if (item.label !== "&laquo; Previous" && item.label !== "Next &raquo;") {
            htmlPaginate +=
                `<li class="page-item ${isCurrent}">
                        <button class="page-link" onclick="toPage('${formId}', ${item.label})" ${disabled}>${item.label}</button>
                    </li>`;
        }
    });

    htmlPaginate += "</ul>";

    return htmlPaginate;
}

function toPage(formId, page) {

    $(".current-paginate").val(page);
    table(urlApi);
}
