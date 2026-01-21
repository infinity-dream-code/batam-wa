//include https://cdnjs.cloudflare.com/ajax/libs/pdf.js/4.10.38/pdf.min.mjs in view
async function getPdfTitleAndDownload(blob) {
    const url = URL.createObjectURL(blob);

    // Load PDF.js
    const loadingTask = pdfjsLib.getDocument(url);
    const pdf = await loadingTask.promise;

    // Get metadata
    const metadata = await pdf.getMetadata();
    let title = metadata.info.Title || "DefaultFileName"; // Use title if available

    // Clean up title (remove special characters)
    title = title.replace(/[\/:*?"<>|]/g, '') + ".pdf";

    // Create download link
    let a = document.createElement('a');
    a.href = url;
    a.download = title;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);

    // Revoke the object URL
    URL.revokeObjectURL(url);
}
