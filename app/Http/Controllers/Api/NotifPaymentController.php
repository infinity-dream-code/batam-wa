<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\master_data\mst_post;
use App\Models\master_data\mst_siswa;
use App\Models\scctbill;
use App\Models\sccttran;
use App\Models\Transaksi\TransaksiPembayaranTagihan;
use App\Models\User;
use App\Models\Utilitas\SettingAutoBayarVa;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request as Request;
use App\Helpers\jwt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class NotifPaymentController extends Controller
{
    public function inquiry(Request $request)
    {

        $key = 'TokenJWT_BMI_ICT';
        $token = request()->query('token');
        $jwt = new jwt();
        $decodeToken = json_decode($jwt->decode($token, $key), true);
        $vano = $decodeToken['VANO'];
        $method = $decodeToken['METHOD'];
        $channelID = $decodeToken['CHANNELID'];
        // $date = Carbon::createFromFormat('YmdHis', $decodeToken['TRXDATE']);
        $refno = $decodeToken['REFNO'];

        $nis = ltrim(substr($vano, 6), '0');
        $saldo = null;
        // $trxDate = $date->format('Y-m-d H:i:s');
        $trxDate = $decodeToken['TRXDATE'];
        switch ($method) {
            case 'INQUIRY':
                try {
                    $siswa = mst_siswa::where('nis', $nis)->first();
                    if (!$siswa) throw new \Exception('Siswa dengan NIS ' . $nis . ' tidak ditemukan.');
                    if ($siswa == null) {
                        $response = [
                            'CCY' => '360', //STATIS
                            'BILL' => '',
                            'DESCRIPTION' => 'tidak ada siswa',
                            'DESCRIPTION2' => '',
                            'CUSTNAME' => '',
                            'ERR' => '15',
                            'METHOD' => 'INQUIRY',
                        ];
                        $decodeJwt = $jwt->encode($response, $key);
                        return $decodeJwt;
                    }
                    //                    $tagihan = scctbill::where('CUSTID', $siswa->id)->where('PAIDST', 0)->where('FSTSBolehBayar', 1)
                    //                        ->whereNull('PAIDDT')
                    //                        ->orderBy('cicil', 'asc')
                    //                        ->orderBy('FUrutan','asc')
                    //                        ->first();

                    $tagihan = scctbill::where('CUSTID', $siswa->id)
                        ->where('PAIDST', 0)
                        ->where('FSTSBolehBayar', 1)
                        ->whereNull('PAIDDT')
                        ->orderBy('cicil', 'asc')
                        ->orderBy('FUrutan', 'asc')
                        ->first();

                    $post = mst_post::where('kode', $tagihan->KodePost)->first();

                    $response = [
                        'CCY' => '360', //STATIS
                        'BILL' => "" . ($tagihan->BILLAM + env('BIAYA_ADMIN') ?? 0) * 100,
                        'DESCRIPTION' => $post->nama_post,
                        'DESCRIPTION2' => $tagihan->BILLNM,
                        'CUSTNAME' => $siswa->nama,
                        'ERR' => '00',
                        'METHOD' => 'INQUIRY'
                    ];
                    $decodeJwt = $jwt->encode($response, $key);
                    // return $decodeJwt;
                    return $decodeJwt;
                    // return response()->json($response);
                } catch (Exception $e) {
                    $response = [
                        'CCY' => '360', //STATIS
                        'BILL' => '',
                        'DESCRIPTION' => '',
                        'DESCRIPTION2' => '',
                        'CUSTNAME' => '',
                        'ERR' => '15',
                        'METHOD' => 'INQUIRY',
                        'err' => $e->getMessage()
                    ];
                    $decodeJwt = $jwt->encode($response, $key);
                    return $decodeJwt;
                }
                break;

            case 'PAYMENT':
                $payment = ((int)$decodeToken['PAYMENT']) - env('BIAYA_ADMIN') ?? 0;

                try {
                    $billnmTemp = 'PAYMENT';
                    $siswa = mst_siswa::where('nis', $nis)->first();
                    if (!$siswa) throw new \Exception('Siswa dengan NIS ' . $nis . ' tidak ditemukan.');

                    DB::beginTransaction();
                    sccttran::create([
                        'CUSTID' => $siswa->id,
                        'METODE' => 'Top Up VA',
                        'TRXDATE' => date('Y-m-d'),
                        'KREDIT' => $payment,
                        'NOREFF' => $refno,
                        'FIDBANK' => $channelID,
                    ]);

                    $setting = SettingAutoBayarVa::where('setting', 1)->first();
                    !$setting ? $setting = 0 : $setting = 1;

                    if (!$setting) {
                        $tagihan = scctbill::where('CUSTID', $siswa->id)
                            ->where('PAIDST', 0)
                            ->where('FSTSBolehBayar', 1)
                            ->whereNull('PAIDDT')
                            ->orderBy('cicil', 'asc')
                            ->orderBy('FUrutan', 'asc')
                            ->first();

                        $billnmTemp = $tagihan->BILLNM;

                        if ($tagihan->cicil == 1) {
                            $oldBill = $tagihan->BILLAM;
                            if ($oldBill <= $payment) {
                                $tagihan->update([
                                    'FSTSBolehBayar' => 0,
                                    'PAIDST' => 1,
                                    'PAIDDT' => $trxDate,
                                    'NOREFF' => $refno,
                                    'PAIDDT_ACTUAL' => now(),
                                    'FIDBANK' => $channelID,
                                    'PAIDAM' => $tagihan->BILLAM,
                                    'BILLAM' => $tagihan->BILLAM,
                                ]);
                                $currentPaid = $tagihan->BILLAM;
                            } else {
                                $currentPaid = $payment;

                                $tagihan->update([
                                    'FSTSBolehBayar' => 0,
                                    'PAIDST' => 1,
                                    'PAIDDT' => $trxDate,
                                    'NOREFF' => $refno,
                                    'PAIDDT_ACTUAL' => now(),
                                    'FIDBANK' => $channelID,
                                    'PAIDAM' => $payment,
                                    'BILLAM' => $payment,
                                ]);

                                scctbill::create([
                                    'CUSTID' => $tagihan->CUSTID,
                                    'BILLCD' => date('Y') . $tagihan->CUSTID,
                                    'BILLNM' => $tagihan->BILLNM,
                                    'KodePost' => $tagihan->KodePost,
                                    'BILLAM' => $oldBill - $payment,
                                    'BILL_TOTAL' => $tagihan->BILL_TOTAL,
                                    'PAIDST' => 0,
                                    'FUrutan' => $tagihan->FUrutan,
                                    'FTGLTagihan' => now(),
                                    'BTA' => $tagihan->BTA,
                                    'cicil' => 1,
                                    'AA' => $tagihan->AA,
                                    'id_group' => $tagihan->id_group
                                ]);
                            }
                        } else {
                            if ($tagihan->BILLAM <= $payment) {
                                $tagihan->update([
                                    'FSTSBolehBayar' => 0,
                                    'PAIDST' => 1,
                                    'NOREFF' => $refno,
                                    'PAIDDT' => $trxDate,
                                    'PAIDDT_ACTUAL' => now(),
                                    'FIDBANK' => $channelID,
                                    'PAIDAM' => $tagihan->BILLAM,
                                ]);

                                $currentPaid = $tagihan->BILLAM;
                            } else {
                                $currentPaid = 0;
                            }
                        }

                        if ($currentPaid != 0) {
                            sccttran::create([
                                'CUSTID' => $siswa->id,
                                'METODE' => 'Bayar Tagihan VA',
                                'TRXDATE' => date('Y-m-d'),
                                'DEBET' => $currentPaid,
                                'NOREFF' => $refno,
                                'FIDBANK' => $channelID,
                            ]);
                        }
                    } else {
                        $tagihans = scctbill::where('CUSTID', $siswa->id)->where('PAIDST', 0)
                            ->where('FSTSBolehBayar', 1)
                            ->whereNull('PAIDDT')
                            ->orderBy('cicil', 'asc')
                            ->orderBy('FUrutan', 'asc')
                            ->get();

                        $saldo = mst_siswa::leftJoin('sccttran', 'mst_siswas.id', 'sccttran.CUSTID')
                            ->selectRaw(
                                'getKredit(mst_siswas.id) - getDebet(mst_siswas.id) as saldo'
                            )->where('mst_siswas.id', $siswa->id)
                            ->first();
                        $saldo = $saldo->saldo ?? 0;
                        $sisaPayment = $saldo;

                        foreach ($tagihans as $tagihan) {
                            $billnmTemp = $tagihan->BILLNM;
                            if ($sisaPayment == 0) {
                                break;
                            }

                            if ($tagihan->cicil == 1) {
                                $oldBill = $tagihan->BILLAM;
                                if ($oldBill <= $sisaPayment) {
                                    $tagihan->update([
                                        'FSTSBolehBayar' => 0,
                                        'PAIDST' => 1,
                                        'PAIDDT' => $trxDate,
                                        'NOREFF' => $refno,
                                        'PAIDDT_ACTUAL' => now(),
                                        'FIDBANK' => $channelID,
                                        'PAIDAM' => $tagihan->BILLAM,
                                        'BILLAM' => $tagihan->BILLAM,
                                    ]);

                                    $currentPaid = $tagihan->BILLAM;
                                } else {
                                    $tagihan->update([
                                        'FSTSBolehBayar' => 0,
                                        'PAIDST' => 1,
                                        'PAIDDT' => $trxDate,
                                        'NOREFF' => $refno,
                                        'PAIDDT_ACTUAL' => now(),
                                        'FIDBANK' => $channelID,
                                        'PAIDAM' => $sisaPayment,
                                        'BILLAM' => $sisaPayment,
                                    ]);

                                    scctbill::create([
                                        'CUSTID' => $tagihan->CUSTID,
                                        'BILLCD' => date('Y') . $tagihan->CUSTID,
                                        'BILLNM' => $tagihan->BILLNM,
                                        'KodePost' => $tagihan->KodePost,
                                        'BILLAM' => $oldBill - $sisaPayment,
                                        'BILL_TOTAL' => $tagihan->BILL_TOTAL,
                                        'PAIDST' => 0,
                                        'FUrutan' => $tagihan->FUrutan,
                                        'FTGLTagihan' => now(),
                                        'BTA' => $tagihan->BTA,
                                        'cicil' => 1,
                                        'AA' => $tagihan->AA,
                                        'id_group' => $tagihan->id_group
                                    ]);
                                    $currentPaid = $sisaPayment;
                                }
                            } else {
                                if ($tagihan->BILLAM <= $sisaPayment) {
                                    $tagihan->update([
                                        'FSTSBolehBayar' => 0,
                                        'PAIDST' => 1,
                                        'NOREFF' => $refno,
                                        'PAIDDT' => $trxDate,
                                        'PAIDDT_ACTUAL' => now(),
                                        'FIDBANK' => $channelID,
                                        'PAIDAM' => $tagihan->BILLAM,
                                    ]);
                                    $currentPaid = $tagihan->BILLAM;
                                } else {
                                    $currentPaid = 0;
                                }
                            }
                            if ($currentPaid != 0) {
                                sccttran::create([
                                    'CUSTID' => $siswa->id,
                                    'METODE' => 'Bayar Tagihan VA',
                                    'TRXDATE' => date('Y-m-d'),
                                    'DEBET' => $currentPaid,
                                    'NOREFF' => $refno,
                                    'FIDBANK' => $channelID,
                                ]);
                            }
                            $sisaPayment = $sisaPayment - $currentPaid;
                        }
                    }
                    DB::commit();
                    $response = [
                        'CCY' => '360', //STATIS
                        'BILL' => $payment + env('BIAYA_ADMIN') ?? 0,
                        'DESCRIPTION' => $billnmTemp,
                        'DESCRIPTION2' => $billnmTemp,
                        'CUSTNAME' => $siswa->nama,
                        'ERR' => '00',
                        'METHOD' => 'PAYMENT'
                    ];

                    // return response()->json($response);
                    // return $decodeJwt;
                    return $jwt->encode($response, $key);
                } catch (Exception $e) {
                    DB::rollBack();
                    Log::channel('payment')->error('Payment failed', [
                        'error' => $e->getMessage(),
                        'NOREFF' => $refno,
                        'FIDBANK' => $channelID,
                    ]);

                    $response = [
                        'CCY' => '360', //STATIS
                        'BILL' => '',
                        'DESCRIPTION' => '',
                        'DESCRIPTION2' => '',
                        'CUSTNAME' => '',
                        'ERR' => '15',
                        'METHOD' => 'PAYMENT',
                        'err' => $e->getMessage()
                    ];

                    $decodeJwt = $jwt->encode($response, $key);
                    // return $decodeJwt;
                    return $decodeJwt;
                    return response()->json($response);
                }
                break;
            case 'REVERSAL':
                try {
                    DB::beginTransaction();
                    $dateForReversal = Carbon::parse($trxDate)->format('Y-m-d');
                    $siswa = mst_siswa::where('nis', $nis)->first();
                    if (!$siswa) throw new \Exception('Siswa dengan NIS ' . $nis . ' tidak ditemukan.');

                    $tagihans = scctbill::where('CUSTID', $siswa->id)
                        ->where('PAIDST', 1)
                        ->where('NOREFF', $refno)
                        ->where('PAIDDT', $trxDate)
                        ->get();
                    foreach ($tagihans as $item) {
                        $item->update([
                            'FSTSBolehBayar' => 1,
                            'PAIDST' => 0,
                            'NOREFF' => null,
                            'PAIDDT' => null,
                            'PAIDDT_ACTUAL' => null,
                            'FIDBANK' => null,
                            'PAIDAM' => 0,
                        ]);

                        if ($item->cicil == 1) {
                            $addNominal = 0;
                            $tagihanBelumBayar = scctbill::where('CUSTID', $siswa->id)
                                ->where('PAIDST', 0)
                                ->where('id_group', $item->id_group)
                                ->orderBy('created_at', 'desc')
                                ->first();

                            if ($tagihanBelumBayar) {
                                $addNominal = $tagihanBelumBayar->BILLAM;

                                $item->update([
                                    'BILLAM' => DB::raw('BILLAM + ' . $addNominal),
                                ]);

                                $tagihanBelumBayar->delete();
                            }
                        }
                    }
                    //
                    //                    $tag = scctbill::where('NOREFF', $refno)
                    //                        ->where('PAIDDT', $trxDate)
                    //                        ->where('CUSTID', $siswa->id)
                    //                        ->where('PAIDST', 1)
                    //                        ->where('cicil', 0)
                    ////                        ->get();
                    //                        ->update([
                    //                            'FSTSBolehBayar' => 1,
                    //                            'PAIDST' => 0,
                    //                            'NOREFF' => null,
                    //                            'PAIDDT' => null,
                    //                            'PAIDDT_ACTUAL' => null,
                    //                            'FIDBANK' => null,
                    //                            'PAIDAM' => 0,
                    //                        ]);

                    $tran = sccttran::where('NOREFF', $refno)
                        ->where('TRXDATE', $trxDate)
                        ->where('CUSTID', $siswa->id)
                        ->update([
                            'KREDIT' => 0,
                            'DEBET' => 0,
                            'REVERSAL' => 1
                        ]);
                    //                        ->get();


                    //                    dd($tag,$tran);
                    DB::commit();
                    $response = [
                        //                        'CCY' => '360', //STATIS
                        //                        'BILL' => 0,
                        //                        'DESCRIPTION' => '',
                        //                        'DESCRIPTION2' => '',
                        //                        'CUSTNAME' => $siswa->nama,
                        'ERR' => '00',
                        'METHOD' => 'REVERSAL'
                    ];

                    // return response()->json($response);
                    $decodeJwt = $jwt->encode($response, $key);
                    // return $decodeJwt;
                    return $decodeJwt;
                } catch (Exception $e) {
                    DB::rollBack();
                    $response = [
                        //                        'CCY' => '360', //STATIS
                        //                        'BILL' => '',
                        //                        'DESCRIPTION' => '',
                        //                        'DESCRIPTION2' => '',
                        //                        'CUSTNAME' => '',
                        'ERR' => '15',
                        'METHOD' => 'REVERSAL',
                        'err' => $e->getMessage()
                    ];
                    $decodeJwt = $jwt->encode($response, $key);
                    // return $decodeJwt;
                    return $decodeJwt;
                    //                    return response()->json($response);
                }
            default:
                $response = [
                    'CCY' => '360', //STATIS
                    'BILL' => '',
                    'DESCRIPTION' => 'TIDAK ADA METHOD',
                    'DESCRIPTION2' => '',
                    'CUSTNAME' => '',
                    'ERR' => '15',
                    'METHOD' => '',
                ];
                $decodeJwt = $jwt->encode($response, $key);
                return $decodeJwt;
                break;
        }
    }

    public function inquiry1(Request $request, $id)
    {
        try {
            $req = urldecode($id);

            $data = json_decode($req, true);
            $vano = $data['VANO'];
            $nis = ltrim(substr($vano, 6), '0');
            $siswa = mst_siswa::where('nis', $nis)->first();
            $tagihan = scctbill::where('CUSTID', $siswa->id)->where('PAIDST', 0)->where('FSTSBolehBayar', 1)->whereNull('PAIDDT')->orderBy('FUrutan')
                ->first();
            $response = [
                'CCY' => '360', //STATIS
                'BILL' => $tagihan->BILLAM + env('BIAYA_ADMIN') ?? 0,
                'DESCRIPTION' => $tagihan->BILLNM,
                'DESCRIPTION2' => $tagihan->BILLNM,
                'CUSTNAME' => $siswa->nama,
                'ERR' => '00',
                'METHOD' => 'INQUIRY'
            ];
            return response()->json($response);
        } catch (Exception $e) {
            $response = [
                'CCY' => '360', //STATIS
                'BILL' => '',
                'DESCRIPTION' => '',
                'DESCRIPTION2' => '',
                'CUSTNAME' => '',
                'ERR' => '15',
                'METHOD' => 'INQUIRY',
                'err' => $e->getMessage()
            ];
            return response()->json($response);
        }
    }

    public function payment(Request $request)
    {
        try {
            $saldo = $request->saldo;
            $vano = $request->VANO;
            $refno = $request->REFNO;
            $payment = $request->PAYMENT - env('BIAYA_ADMIN') ?? 0;
            $date = Carbon::createFromFormat('YmdHis', $request->TRXDATE);
            $trxDate = $date->format('Y-m-d H:i:s');

            $nis = ltrim(substr($vano, 6), '0');
            $siswa = mst_siswa::where('nis', $nis)->first();

            if (!$saldo) {
                $tagihan = scctbill::where('CUSTID', $siswa->id)->where('PAIDST', 0)->where('FSTSBolehBayar', 1)->whereNull('PAIDDT')->orderBy('FUrutan')
                    ->first();
                if (!$tagihan) throw new Exception('Tagihan tidak ditemukan');

                $oldBill = $tagihan->BILLAM;
                if ($tagihan->cicil == 1) {
                    $tagihan->update([
                        'FSTSBolehBayar' => 0,
                        'PAIDST' => 1,
                        'PAIDDT' => $trxDate,
                        'NOREFF' => $refno,
                        'PAIDDT_ACTUAL' => $trxDate,
                        'FIDBANK' => 101,
                        'PAIDAM' => $payment,
                        'BILLAM' => $payment,
                    ]);

                    if ($oldBill > $payment) {
                        scctbill::create([
                            'CUSTID' => $tagihan->CUSTID,
                            'BILLCD' => date('Y') . $tagihan->CUSTID,
                            'BILLNM' => $tagihan->BILLNM,
                            'KodePost' => $tagihan->KodePost,
                            'BILLAM' => $oldBill - $payment,
                            'BILL_TOTAL' => $tagihan->BILL_TOTAL,
                            'PAIDST' => 0,
                            'FUrutan' => $tagihan->FUrutan,
                            'FTGLTagihan' => now(),
                            'BTA' => $tagihan->BTA,
                            'cicil' => 1,
                            'AA' => $tagihan->AA,
                            'id_group' => $tagihan->id_group
                        ]);
                    }
                } else {
                    $tagihan->update([
                        'FSTSBolehBayar' => 0,
                        'PAIDST' => 1,
                        'NOREFF' => $refno,
                        'PAIDDT' => $trxDate,
                        'PAIDDT_ACTUAL' => $trxDate,
                        'FIDBANK' => 101,
                        'PAIDAM' => $payment
                    ]);
                }
            } else {
                sccttran::create([
                    'CUSTID' => $siswa->id,
                    'METODE' => 'Top Up',
                    'TRXDATE' => date('Y-m-d'),
                    'KREDIT' => $payment,
                ]);
            }

            $response = [
                'CCY' => '360', //STATIS
                'BILL' => $tagihan->BILLAM + env('BIAYA_ADMIN') ?? 0,
                'DESCRIPTION' => $tagihan->BILLNM,
                'DESCRIPTION2' => $tagihan->BILLNM,
                'CUSTNAME' => $siswa->nama,
                'ERR' => '00',
                'METHOD' => 'INQUIRY'
            ];
            return response()->json($response);
        } catch (Exception $e) {
            $response = [
                'CCY' => '360', //STATIS
                'BILL' => '',
                'DESCRIPTION' => '',
                'DESCRIPTION2' => '',
                'CUSTNAME' => '',
                'ERR' => '15',
                'METHOD' => 'INQUIRY',
                'err' => $e->getMessage()
            ];
            return response()->json($response);
        }
    }

    public function tagihan(Request $request)
    {
        try {
            $user = User::where('token', $request->header('token'))->first();
            $tagihan = scctbill::where('CUSTID', $user->siswa_id)->where('PAIDST', 0)->get();
            $formattedTagihan = $tagihan->map(function ($item) {
                $tanggalTagihan = Carbon::parse($item->FTGLTagihan);

                $tanggalBayar = $item->PAIDDT ? Carbon::parse($item->PAIDDT) : null;
                $item->PAIDDT = $tanggalBayar ? $tanggalBayar->locale('id')->translatedFormat('d F Y') : null;
                $item->jamBayar = $tanggalBayar ? $tanggalBayar->format('H:i') : null;

                $item->FTGLTagihan = $tanggalTagihan->locale('id')->translatedFormat('d F Y');
                $item->jam = $tanggalTagihan->format('H:i');
                return $item;
            });

            if ($tagihan->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'error' => 'tidak ada data',
                    'data' => $formattedTagihan
                ]);
            }
            $data = [];
            foreach ($formattedTagihan as $key => $value) {
                $data[$key]['namaTagihan'] = $value->BILLNM;
                $data[$key]['kodeTagihan'] = $value->BILLCD;
                $data[$key]['totalNominal'] = $value->BILL_TOTAL;
                $data[$key]['tahunAkademik'] = $value->BTA;
                $data[$key]['isSelected'] = $value->FSTSBolehBayar;
            }

            return response()->json([
                'status' => true,
                'error' => 'berhasil',
                'data' => $data
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'data' => []
            ]);
        }
    }

    public function selectedTagihan(Request $request)
    {
        $data = $request->data;
        $user = User::where('token', $request->header('token'))->first();
        $dataReq = json_decode($data, true);
        try {
            if ($data != null) {
                foreach ($dataReq as $value) {
                    // return $value->kodeTagihan;
                    if ($value['isSelected']) {
                        $tagihan = scctbill::where('CUSTID', $user->siswa_id)->where('PAIDST', 0)->where('BILLCD', $value['kodeTagihan'])->first();
                        $tagihan->FSTSBolehBayar = 1;
                        $tagihan->siap_bayar = 1;
                        $tagihan->save();
                    } else {
                        $tagihan = scctbill::where('CUSTID', $user->siswa_id)->where('PAIDST', 0)->where('BILLCD', $value['kodeTagihan'])->first();
                        $tagihan->FSTSBolehBayar = 0;
                        $tagihan->siap_bayar = 0;
                        $tagihan->save();
                    }
                }
                $tagihan = scctbill::where('CUSTID', $user->siswa_id)->where('PAIDST', 0)->where('siap_bayar', 1)->sum('BILL_TOTAL');
                return response()->json([
                    'status' => true,
                    'error' => 'berhasil',
                    'data' => [
                        'totalNominal' => $tagihan
                    ]
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'error' => 'tidak ada data',
                    'data' => []
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'data' => []
            ]);
        }
    }

    public function transaksiSpp(Request $request)
    {
        try {
            $user = User::where('token', $request->header('token'))->first();
            $tagihan = scctbill::where('CUSTID', $user->siswa_id)->where('PAIDST', 1)->get();
            $formattedTagihan = $tagihan->map(function ($item) {
                $tanggalTagihan = Carbon::parse($item->FTGLTagihan);
                $tanggalBayar = $item->PAIDDT ? Carbon::parse($item->PAIDDT) : null;
                $item->PAIDDT = $tanggalBayar ? $tanggalBayar->locale('id')->translatedFormat('d F Y') : null;
                $item->jamBayar = $tanggalBayar ? $tanggalBayar->format('H:i') : null;
                $item->FTGLTagihan = $tanggalTagihan->locale('id')->translatedFormat('d F Y');
                $item->jam = $tanggalTagihan->format('H:i');
                return $item;
            });

            if ($tagihan->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'error' => 'tidak ada data',
                    'data' => $formattedTagihan
                ]);
            }
            $data = [];
            foreach ($formattedTagihan as $key => $value) {
                $data[$key]['namaTagihan'] = $value->BILLNM;
                $data[$key]['kodeTagihan'] = $value->BILLCD;
                $data[$key]['totalNominal'] = $value->BILL_TOTAL;
                $data[$key]['tahunAkademik'] = $value->BTA;
                $data[$key]['isSelected'] = $value->FSTSBolehBayar;
            }

            return response()->json([
                'status' => true,
                'error' => 'berhasil',
                'data' => $data
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'data' => []
            ]);
        }
    }

    public function pembayaran(Request $request)
    {
        try {
            $user = User::where('token', $request->header('token'))->first();
            $tagihan = TransaksiPembayaranTagihan::where('siswa_id', $user->siswa_id)->paginate(10);

            $formattedTagihan = $tagihan->map(function ($item) {
                $tanggalBayar = $item->tgl_transaksi ? Carbon::parse($item->tgl_transaksi) : null;
                $item->tgl_transaksi = $tanggalBayar ? $tanggalBayar->locale('id')->translatedFormat('d F Y') : null;
                $item->jamBayar = $tanggalBayar ? $tanggalBayar->format('H:i') : null;
                return $item;
            });

            $data = [];
            foreach ($formattedTagihan as $key => $value) {
                $data[$key]['kredit'] = (int)$value->kredit;
                $data[$key]['debet'] = (int)$value->debet;
                $data[$key]['tgl_transaksi'] = $value->tgl_transaksi;
                $data[$key]['jam_bayar'] = $value->jamBayar;
                $data[$key]['metode'] = $value->metode;
                # code...
            }
            if ($tagihan->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'error' => 'tidak ada data',
                    'data' => $data
                ]);
            }
            return response()->json([
                'status' => true,
                'error' => 'berhasil',
                'data' => $data
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'error' => $e,
                'data' => []
            ]);
        }
    }

    public function saldo(Request $request)
    {
        try {
            return response()->json([
                'status' => true,
                'error' => 'berhasil',
                'data' => [
                    'saldo_va' => 100000,
                    'saldo_spp' => 20000
                ]
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'error' => $e,
                'data' => []
            ]);
        }
    }

    public function historyKeuangan(Request $request)
    {
        try {
            $user = User::where('token', $request->header('token'))->first();
            $history = TransaksiPembayaranTagihan::where('siswa_id', $user->siswa_id)->paginate(20);
            //ambil bill am
            if ($history->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'error' => 'tidak ada data',
                    'data' => $history
                ]);
            }
            return response()->json([
                'status' => true,
                'error' => 'berhasil',
                'data' => $history
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'error' => $e,
                'data' => []
            ]);
        }
    }
}
