<?php

namespace App\Http\Controllers\Admin\Utilitas;

use App\Http\Controllers\Controller;
use App\Models\LogModel;
use App\Models\LogWhatsappsModel;
use App\Models\MstKelasModel;
use App\Models\MstThnAkaModel;
use App\Models\ScctBillModel;
use App\Models\UAkunModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class LogAktifitasController extends Controller
{
    public $mainTitle;

    public function __construct()
    {
        $this->title = 'Log';
        $this->mainTitle = 'Log Aktifitas';
        $this->dataTitle = 'Log Aktifitas';
        $this->showTitle = 'Detail Log Aktifitas';
    }

    public function getColumn()
    {
        return [
            ['data' => 'no', 'name' => 'no'],
            ['data' => 'name', 'name' => 'NAMA', 'searchable' => true, 'orderable' => true],
            ['data' => 'menu', 'name' => 'Menu', 'searchable' => true, 'orderable' => true],
            ['data' => 'aksi', 'name' => 'Aktifitas', 'searchable' => true, 'orderable' => true],
            ['data' => 'ip_address', 'name' => 'IP ADDRESS', 'searchable' => true, 'orderable' => true],
            ['data' => 'status', 'name' => 'status', 'searchable' => true, 'orderable' => true],
            ['data' => 'created_at', 'name' => 'Tanggal', 'columnType' => 'timeStamp', 'searchable' => false, 'orderable' => false],
        ];
    }

    public function getData(Request $request)
    {

        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length");

        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');

        $defaultColumn = 'id';
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
        if ($request->dari_tanggal && $request->sampai_tanggal) {
            $dateEnd =  Carbon::parse($request->sampai_tanggal)->addHours(23, 59, 59);
            $filters[] = ['log.created_at', '>=', $request->dari_tanggal];
            $filters[] = ['log.created_at', '<=', $dateEnd];
        }
        $filter = $request->input('filter');

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


        $totalRecords = LogModel::select('count(*) as allcount')
            ->count();

        $totalRecordswithFilter = LogModel::join('users', 'users.id', 'log.user_id')
            ->select('count(log.*) as allcount')
            ->whereAny([
                'users.name',
                'users.username',
                'log.menu',
                'log.aksi',
                'log.target_id',
                'log.ip_address',
            ], 'like', '%' . $searchValue . '%')
            ->where(function ($query) use ($filterQuery) {
                if ($filterQuery) {
                    $filterQuery($query);
                }
            })
            ->count();
        Carbon::setLocale('id');


        $records = LogModel::join('users', 'users.id', 'log.user_id')
            ->orderBy($columnName, $columnSortOrder)
            ->select([
                'log.*',
                'users.name',
                'users.username'
            ])
            ->whereAny([
                'users.name',
                'users.username',
                'log.menu',
                'log.aksi',
                'log.target_id',
                'log.ip_address',
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
        $data['columnsUrl'] = route('admin.log-aktifitas.get-column');
        $data['datasUrl'] = route('admin.log-aktifitas.get-data');
        // $data['modalLink'] = view('admin.utilitas.notifikasi_whatsapp_tagihan.modal', compact('post'));

        return view('admin.utilitas.log_aktifitas.index', $data);
    }
}
