<?php

namespace App\Http\Controllers\Admin\Utilitas;

use App\Http\Controllers\Controller;
use App\Models\master_data\mst_thn_aka;
use App\Models\Utilitas\LogSettingAutoBayarVa;
use App\Models\Utilitas\SettingAutoBayarVa;
use App\Models\ValidationMessage;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SettingAutoBayarController extends Controller
{
    public function __construct()
    {
        $this->title = 'Utilitas';
        $this->mainTitle = 'Setting Auto Bayar VA';
        $this->dataTitle = 'Setting Auto Bayar VA';
        $this->showTitle = 'Detail Setting Auto Bayar VA';
        $this->datasUrl = route('admin.keuangan.penerimaan-siswa.rekap-penerimaan.get-data');
        $this->detailDatasUrl = '';
        $this->columnsUrl = route('admin.keuangan.penerimaan-siswa.rekap-penerimaan.get-column');
    }

    public function index()
    {
        $angkatan = mst_thn_aka::where('thn_aka', '!=', null)->get();
        $setting = SettingAutoBayarVa::where('setting', 1)->where('id', 1)->first();
        !$setting ? $setting = 0 : $setting = 1;

        $data['title'] = $this->title;
        $data['mainTitle'] = $this->mainTitle;
        $data['dataTitle'] = $this->dataTitle;
        $data['showTitle'] = $this->showTitle;
        $data['thn_aka'] = $angkatan;
        $data['setting'] = $setting;

        return view('admin.utilitas.setting_auto_bayar_va.index', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'setting' => ['required', 'in:0,1']
        ], ValidationMessage::messages(),
            ValidationMessage::attributes());

        try {
            DB::beginTransaction();
            $existing = SettingAutoBayarVa::where('id', 1)->first();

            if (!$existing) {
                SettingAutoBayarVa::create(
                    ['setting' => $request->setting]);
            } else {
                $existing->update(['setting' => $request->setting]);
            }


            LogSettingAutoBayarVa::create([
                'setting' => $request->setting,
                'id_user' => Auth::user()->id,
            ]);

            $setting = $request->setting == 1 ? 'Auto bayar VA aktif' : 'Auto bayar VA tidak aktif';
            DB::commit();
            return response()->json(['message' => 'Sukses <br> ' . $setting], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Gagal <br> gagal mengganti setting auto bayar VA', 'error' => $e->getMessage()], 422);
        }


    }
}
