<?php

namespace App\Http\Controllers\Admin\Utilitas;

use App\Http\Controllers\Controller;
use App\Models\LogWhatsappsModel;
use App\Models\master_data\mst_kelas;
use App\Models\master_data\mst_post;
use App\Models\master_data\mst_siswa;
use App\Models\master_data\mst_thn_aka;
use App\Models\MstKelasModel;
use App\Models\MstThnAkaModel;
use App\Models\no;
use App\Models\scctbill;
use App\Models\ScctBillDetailModel;
use App\Models\ScctBillModel;
use App\Models\ScctcustModel;
use App\Models\UAkunModel;
use App\Models\ValidationMessage;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Termwind\Components\Dd;

use function Laravel\Prompts\select;

class DataSiswaController extends Controller
{

    public $mainTitle;

    public function __construct()
    {
        $this->title = 'Siswa';
        $this->mainTitle = 'Data Siswa';
        $this->dataTitle = 'Data Siswa';
        $this->showTitle = 'Detail Data Data Siswa';
    }

    public function getColumn()
    {
        return [
            ['data' => 'no', 'name' => 'no'],
            ['data' => 'NMCUST', 'name' => 'nama', 'searchable' => true, 'orderable' => true],
            ['data' => 'NOCUST', 'name' => 'nis', 'searchable' => true, 'orderable' => true],
            ['data' => 'NOVA', 'name' => 'Nomor Va', 'searchable' => true, 'orderable' => true],
            ['data' => 'STCUST', 'name' => 'Status Siswa', 'orderable' => true, 'columnType' => 'boolean', 'trueVal' => 'Aktif', 'falseVal' => 'Tidak Aktif'],
            ['data' => 'DESC04', 'name' => 'Tahun Angkatan', 'searchable' => true, 'orderable' => true],
            // ['data' => 'nama_post', 'name' => 'Nama POST', 'searchable' => true, 'orderable' => true],
            ['data' => 'KELAS', 'name' => 'KELAS', 'searchable' => true, 'orderable' => true],
            ['data' => 'NO_WA', 'name' => 'Nomor WA', 'searchable' => true, 'orderable' => true],
        ];
    }

    public function getKelas(Request $request)
    {
        $jenjang = $request->input('jenjang');
        $unit = $request->input('unit');

        $kelas = MstKelasModel::where('jenjang', $jenjang)
            ->where('unit', $unit)
            ->get();
        return response()->json($kelas);
    }

    public function getData(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length");

        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');

        $defaultColumn = 'CUSTID';
        $defaultOrder = 'desc';

        if ($request->has('order')) {
            $columnIndex_arr = $request->get('order');
            $columnIndex = $columnIndex_arr[0]['column'];
            $columnSortOrder = $columnIndex_arr[0]['dir'];
        } else {
            $columnIndex = $defaultColumn;
            $columnSortOrder = $defaultOrder;
        }

        $columnName = $columnName_arr[$columnIndex]['data'];
        $searchValue = $search_arr['value'];

        if (!$columnName || $columnName == 'no') {
            $columnName = $defaultColumn;
            $columnSortOrder = $defaultOrder;
        }

        $filters = [];
        $filterQuery = null;

        $filter = $request->input('filter');

        if ($filter) {
            // dd($filter);
            foreach ($filter as $key => $val) {
                if (strtolower($val) != 'all' && $val !== null && $val !== '') {
                    $colName = match ($key) {
                        'tahun_akademik' => 'DESC04',
                        'cari_siswa' => is_numeric($val) ? 'scctcust.NOCUST' : 'scctcust.NMCUST',
                        default => null
                    };

                    ($colName) && $filters[] =  $colName == 'scctcust.NMCUST' || 'scctcust.NOCUST' ?  [$colName, 'LIKE', "%" . $val . "%"] : [$colName, '=', $val];
                }
            };
        }
        if (isset($request->unit)) {
            if ($request->unit != "Semua") {
                $waduh = explode('-', $request->unit);
                $jenjang = $waduh[0];
                $unit = $waduh[1];
                $kelas = $request->kelas;
                if (isset($kelas)) {
                    $filters[] = ['scctcust.DESC03', '=', $kelas];
                }
                $filters[] = ['scctcust.DESC02', '=', $jenjang];
                $filters[] = ['scctcust.CODE02', '=', $unit];
            }
        }

        if (!empty($filters)) {
            $filterQuery = function ($query) use ($filters) {
                foreach ($filters as $filter) {
                    if (count($filter) === 3) {
                        $query->where($filter[0], $filter[1], $filter[2]);
                    } elseif (count($filter) === 4) {
                        $query->{$filter[3]}($filter[0], $filter[1], $filter[2]);
                    }
                }
            };
        }

        $totalRecords = ScctcustModel::select('count(*) as allcount')
            ->count();

        $totalRecordswithFilter = ScctcustModel::select('count(*) as allcount')
            ->whereAny([
                'scctcust.NMCUST',
                'scctcust.NOCUST',
                'scctcust.DESC02',
                'scctcust.DESC03',
                'scctcust.CODE02',
                'scctcust.NO_WA'
            ], 'like', '%' . $searchValue . '%')
            ->where(function ($query) use ($filterQuery) {
                if ($filterQuery) {
                    $filterQuery($query);
                }
            })
            ->count();

        $records =
            ScctcustModel::orderBy($columnName, $columnSortOrder)

            ->select([
                "*"
            ])
            ->whereAny([
                'scctcust.NMCUST',
                'scctcust.NOCUST',
                'scctcust.DESC02',
                'scctcust.DESC03',
                'scctcust.CODE02',
                'scctcust.NO_WA'
            ], 'like', '%' . $searchValue . '%')
            ->where(function ($query) use ($filterQuery) {
                if ($filterQuery) {
                    $filterQuery($query);
                }
            })
            ->skip($start)
            ->take($rowperpage)
            ->get()
            ->map(function ($item, $index) {
                $item->no = $index + 1;
                $item->NOVA = "751001" . $item->NOCUST;
                $item->KELAS = $item->DESC02 . "-" . $item->DESC03 . " " . $item->CODE02;
                $item->item_id = Crypt::encrypt($item->id);
                unset($item->id);
                return $item;
            })->toArray();

        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $totalRecordswithFilter,
            "data" => $records,
        );
        return response()->json($response);
    }

    public function index()
    {
        $post = UAkunModel::all();
        $thn_aka = MstThnAkaModel::where('thn_aka', '!=', null)->orderBy('thn_aka', 'desc')->get();
        // $kelas = MstKelasModel::get();

        $kelas = MstKelasModel::select('jenjang', 'unit')
            ->distinct()
            ->orderBy('unit')
            ->get();

        $data['post'] = $post;
        $data['thn_aka'] = $thn_aka;
        $data['kelas'] = $kelas;
        $data['title'] = $this->title;
        $data['mainTitle'] = $this->mainTitle;
        $data['dataTitle'] = $this->dataTitle;
        $data['showTitle'] = $this->showTitle;
        $data['columnsUrl'] = route('admin.data-siswa.get-column');
        $data['datasUrl'] = route('admin.data-siswa.get-data');
        // $data['modalLink'] = view('admin.utilitas.notifikasi_whatsapp_tagihan.modal', compact('post'));

        return view('admin.utilitas.data_siswa.index', $data);
    }
}
