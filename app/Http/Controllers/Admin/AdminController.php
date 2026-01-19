<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\master_data\mst_kelas;
use App\Models\master_data\mst_post;
use App\Models\master_data\mst_siswa;
use App\Models\master_data\mst_thn_aka;
use App\Models\MstKelasModel;
use App\Models\MstThnAkaModel;
use App\Models\scctbill;
use App\Models\ScctBillModel;
use App\Models\scctcust;
use App\Models\ScctcustModel;
use App\Models\UAkunModel;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    function formatDateIndonesian($date, $months)
    {
        // Create a Carbon instance from the date
        $carbonDate = Carbon::parse($date);

        // Get the day and month in English
        $day = $carbonDate->day;
        $monthName = $carbonDate->format('F');

        // Translate month to Indonesian
        $monthIndonesian = $months[$monthName] ?? $monthName;

        // Return formatted date
        return $monthIndonesian . ' ' . $day;
    }

    public function index()
    {
        $months = [
            'January' => 'Jan',
            'February' => 'Feb',
            'March' => 'Mar',
            'April' => 'Apr',
            'May' => 'Mei',
            'June' => 'Jun',
            'July' => 'Jul',
            'August' => 'Ags',
            'September' => 'Sep',
            'October' => 'Okt',
            'November' => 'Nov',
            'December' => 'Des'
        ];


        $tagihanDibuat = ScctBillModel::select(DB::raw('COUNT(*) as count'))
            ->orderBy('AA', 'DESC')
            ->get(7);

        $hasilTagihanDibuat = [];
        $today = Carbon::now();
        for ($i = 0; $i < 7; $i++) {
            $date = $today->copy()->subDays($i)->format('Y-m-d');
            $hasilTagihanDibuat[$date] = 0;
        }
        foreach ($tagihanDibuat as $count) {
            $hasilTagihanDibuat[$count->date] = $count->count;
        }
        $chartTagihanDibuat = collect($hasilTagihanDibuat)->map(function ($count, $date) use ($months) {
            return [
                'date' => $this->formatDateIndonesian($date, $months),
                'count' => $count
            ];
        })->values();

        $taighanDibayar = ScctBillModel::select(DB::raw('DATE(PAIDDT) as date'), DB::raw('COUNT(*) as count'))
            ->groupBy(DB::raw('DATE(PAIDDT)'))
            ->orderBy('date', 'DESC')
            ->get(7);

        $hasilTagihanDibayar = [];
        for ($i = 0; $i < 7; $i++) {
            $date = $today->copy()->subDays($i)->format('Y-m-d');
            $hasilTagihanDibayar[$date] = 0;
        }
        foreach ($taighanDibayar as $count) {
            $hasilTagihanDibayar[$count->date] = $count->count;
        }
        $chartTagihanDibayar = collect($hasilTagihanDibayar)->map(function ($count, $date) use ($months) {
            return [
                'date' => $this->formatDateIndonesian($date, $months),
                'count' => $count
            ];
        })->values();

        //        dd($chartTagihanDibayar,$chartTagihanDibuat);

        $data['chartTagihanDibayar'] = $chartTagihanDibayar;
        $data['chartTagihanDibuat'] = $chartTagihanDibuat;
        $data['total_siswa'] = ScctcustModel::count();
        $data['total_kelas'] = MstKelasModel::count();
        $data['total_post'] = UAkunModel::count();
        $data['total_tahun_aka'] = MstThnAkaModel::count();
        $data['tagihan_baru_dibayar'] = ScctBillModel::leftJoin('scctcust', 'scctcust.custid', 'scctbill.CUSTID')
            ->select([
                'scctbill.AA as id',
                'scctbill.BILLNM',
                'scctbill.BILLAM',
                'scctbill.PAIDST',
                'scctbill.PAIDDT',
                'scctbill.BTA',
                'scctbill.FIDBANK',
                'scctbill.FUrutan',
                'scctcust.NMCUST',
                'scctcust.NOCUST',
            ])->where('scctbill.PAIDST', 1)->orderBy('PAIDDT', 'desc')->take(5)->get();

        $data['jumlah_tagihan_belum_dibayar'] = ScctBillModel::distinct('BILLNM')->where('PAIDST', 0)->count('BILLAM') ?: 0;
        $data['jumlah_tagihan_dibayar'] = ScctBillModel::distinct('BILLNM')->where('PAIDST', 1)->count('BILLAM') ?: 0;
        $data['jumlah_tagihan'] = ScctBillModel::distinct('BILLNM')->count('BILLAM') ?: 0;
        $data['jumlah_tagihan_cicil'] = 0;
        $data['jumlah_tagihan_non_cicil'] =  0;

        //        echo '🙏';

        return view('admin.index', $data);
    }
}
