<?php

namespace App\Http\Controllers\Admin\Utilitas;

use App\Http\Controllers\Controller;
use App\Models\master_data\mst_siswa;
use App\Models\master_data\mst_thn_aka;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class BayarJamakSaldoController extends Controller
{
    public function __construct()
    {
        $this->title = 'Utilitas';
        $this->mainTitle = 'Bayar Jamak';
        $this->dataTitle = 'Bayar Jamak';
        $this->showTitle = 'Detail Data PPDB';
        $this->datasUrl = route('admin.bayar-jamak-saldo.get-data');
        $this->detailDatasUrl = '';
        $this->columnsUrl = route('admin.bayar-jamak-saldo.get-column');
    }

    public function index()
    {
        $angkatan = mst_thn_aka::where('thn_aka', '!=', null)->get();

        $data['title'] = $this->title;
        $data['mainTitle'] = $this->mainTitle;
        $data['dataTitle'] = $this->dataTitle;
        $data['showTitle'] = $this->showTitle;
        $data['columnsUrl'] = $this->columnsUrl;
        $data['thn_aka'] = $angkatan;
        $data['datasUrl'] = $this->datasUrl;

        return view('admin.utilitas.bayar_jamak_saldo.index', $data);
    }

    public function getColumn(Request $request)
    {
        return [
            ['data' => 'no', 'name' => 'no'],
            ['data' => 'nis', 'name' => 'NIS', 'searchable' => true, 'orderable' => true],
            ['data' => 'nama', 'name' => 'NAMA', 'searchable' => true, 'orderable' => true],
            ['data' => 'nova', 'name' => 'NOVA', 'searchable' => true, 'orderable' => true],
            ['data' => 'saldo', 'name' => 'Saldo', 'columnType' => 'currency', 'className' => 'text-end'],
        ];
    }

    public function getData(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length");

        $columnName_arr = $request->get('columns');
        $search_arr = $request->get('search');

        $defaultColumn = 'sccttran.created_at';
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

        // Total records
        $totalRecords = mst_siswa::select('count(mst_siswas.*) as allcount')->count();
        $totalRecordswithFilter = mst_siswa::select('count(mst_siswas.*) as allcount')
            ->whereAny([
                'mst_siswas.nama',
                'mst_siswas.nis',
            ], 'like', '%' . $searchValue . '%')
            ->count();

        $records = mst_siswa::orderBy($columnName, $columnSortOrder)
            ->leftJoin('sccttran', 'mst_siswas.id', 'sccttran.CUSTID')
            ->select([
                'mst_siswas.id as id',
                'mst_siswas.nama',
                'mst_siswas.nis',
            ])->selectRaw(
                'getKredit(mst_siswas.id) - getDebet(mst_siswas.id) as saldo'
            )
            ->whereAny([
                'mst_siswas.nama',
                'mst_siswas.nis',
            ], 'like', '%' . $searchValue . '%')
            ->whereRaw(
                '(getKredit(mst_siswas.id) - getDebet(mst_siswas.id)) > 0'
            )
            ->groupBy('mst_siswas.id')
            ->skip($start)
            ->take($rowperpage)
            ->get()
            ->map(function ($item, $index) {
                $item->no = $index + 1;
                $item->item_id = Crypt::encrypt($item->id);
                $item->print = true;
                $item->nova = mst_siswa::showVA($item->nis);
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
}
