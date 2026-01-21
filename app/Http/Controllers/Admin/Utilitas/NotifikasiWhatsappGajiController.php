<?php

namespace App\Http\Controllers\Admin\Utilitas;

use App\Helpers\PhoneNumberHelper;
use App\Http\Controllers\Controller;
use App\Models\LogModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\LogWhatsappsModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class NotifikasiWhatsappGajiController extends Controller
{
    public function index()
    {
        return view("admin.utilitas.notifikasi_whatsapp_gaji.index");
    }

    public function uploadGajiTsanawiyah(Request $request)
    {
        $request->validate([
            "file" => "required|mimes:xlsx,xls",
        ]);

        $data = Excel::toArray([], $request->file("file"));

        foreach ($data[0] as $i => $row) {
            if ($i === 0) {
                continue;
            }

            $nama = $row[1];
            $nomor = $row[2];
            Carbon::setLocale("id");
            $formatTanggal = Carbon::now()->translatedFormat("d F Y");

            $pesan = <<<EOD
            GAJI GURU TSANAWIYAH
            MADRASAH MU'ALLIMAAT MUHAMMADIYAH YOGYAKARTA

            No: {$row[0]}
            Nama: {$nama}

            1. Gaji Pokok
            a. Jumlah jam mengajar Reg      : Rp {$row[3]}
            b. Jumlah jam mengajar Mult     : Rp {$row[4]}
            c. Hadir Piket                  : Rp {$row[5]}
            d. Wali kelas                   : Rp {$row[6]}
            e. DPLK                         : Rp {$row[7]}
            f. Fungsional                   : Rp {$row[8]}

            2. Kehadiran
            {$row[9]} x Rp 12.500 = Rp {$row[10]}

            3. Potongan
            a. Dana Sosial Reg          : Rp {$row[11]}
            b. Dana Sosial Multi        : Rp {$row[12]}
            c. Arisan A                 : Rp {$row[13]}
            d. Arisan B                 : Rp {$row[14]}
            e. SP/SW                    : Rp {$row[15]}
            f. Simpan Pinjam            : Rp {$row[16]}
            g. DPLK                     : Rp {$row[17]}
            h. Voucher                  : Rp {$row[18]}
            i. Koperasi                 : Rp {$row[19]}
            j. BRI                      : Rp {$row[20]}
            k. BPJS                     : Rp {$row[21]}
            l. b jogja                  : Rp {$row[22]}
            m. dsm                      : Rp {$row[23]}
                                        ----------------+
               Jumlah                   : Rp {$row[24]}
            Jumlah Bersih               : Rp {$row[25]}

                    Yogyakarta, {$formatTanggal}
            Semoga menjadi rezeqi yang barokah, Aamiin.
            EOD;

            $this->kirimPesan($request, $nomor, $pesan, $row[0], $nama);
        }

        return back()->with("success", "Pesan berhasil dikirim");
    }

    public function uploadGajiTetap(Request $request)
    {
        $request->validate([
            "file" => "required|mimes:xlsx,xls",
        ]);

        $data = Excel::toArray([], $request->file("file"));

        foreach ($data[0] as $i => $row) {
            if ($i === 0) {
                continue;
            }

            $nama = $row[1];
            $nomor = $row[2];
            Carbon::setLocale("id");
            $formatTanggal = Carbon::now()->translatedFormat("d F Y");
            $pesan = <<<EOD
            GAJI GURU TETAP PERSYARIKATAN
            MADRASAH MU'ALLIMAAT MUHAMMADIYAH YOGYAKARTA

            No: {$row[0]}
            Nama: {$nama}

            1. Gaji Pokok : Rp {$row[3]}
            2. Tambahan : Rp {$row[4]}
            3. jabatan/Piket : Rp {$row[5]}
            a. Suami/istri : Rp {$row[6]}
            b. Anak : Rp {$row[7]}
            c. Beras : Rp {$row[8]}
            d. Jabatan : Rp {$row[9]}
            e. Dapen : Rp {$row[10]}
            f. Fungsional : Rp {$row[11]}
            g. Pembulatan : Rp {$row[12]}
                     -----------------+
               Jumlah : Rp {$row[13]}

            4. Kehadiran       {$row[14]}x : Rp {$row[15]}
                  Tambh. Hadir {$row[16]}x : Rp {$row[17]}
                     -----------------+
               Jumlah : Rp {$row[18]}

            5. Potongan
            a. Dana Sosial : Rp {$row[19]}
            b. Dapen : Rp {$row[20]}
            c. Arisan A  : Rp {$row[21]}
            d. Arisan B : Rp {$row[22]}
            e. SP/SW : Rp {$row[23]}
            f. Simpin : Rp {$row[24]}
            g. DPLK : Rp {$row[25]}
            h. Voucher : Rp {$row[26]}
            i. Beras : Rp {$row[27]}
            j. BRI : Rp {$row[28]}
            k. BPJS : Rp {$row[29]}
            l. Beras : Rp {$row[30]}
            m. lain2 : Rp {$row[31]}
            n. Pembulatan : Rp {$row[32]}
                -----------------+
                Jumlah     : Rp {$row[33]}
            Jumlah Bersih  : Rp {$row[34]}

                    Yogyakarta, {$formatTanggal}
            Semoga menjadi rezeqi yang barokah, Aamiin.
            EOD;

            $this->kirimPesan($request, $nomor, $pesan, $row[0], $nama);
        }

        return back()->with("success", "Pesan berhasil dikirim");
    }

    private function formatNomor($nomor)
    {
        $nomor = PhoneNumberHelper::format($nomor);
        return $nomor;
    }

    private function kirimPesan(Request $request, $nomor, $pesan, $no, $nama)
    {
        $nomor = $this->formatNomor($nomor);
        $status = "10";
        $response = null;
        $messageFail = "Pesan gagal dikirim";

        $dbTraffic = new \mysqli(
            "10.99.23.26",
            "root",
            "Smartpay1ct",
            "farrelep_broadcaster",
        );

        $apiKeyResult = $dbTraffic->query(
            "SELECT GetWAApiSecret('Yogya_Muallimaat')",
        );
        if (!$apiKeyResult) {
            logger("Gagal mengambil API Key: " . $dbTraffic->error);
            return;
        }

        $apiKeyRow = $apiKeyResult->fetch_array(MYSQLI_NUM);
        if ($apiKeyRow && isset($apiKeyRow[0])) {
            [$hostKey, $clientNumberKey] = explode("|", $apiKeyRow[0], 2);

            $payload = [
                "api_key" => $hostKey,
                "number_key" => $clientNumberKey,
                "phone_no" => $nomor,
                "message" => $pesan,
            ];

            try {
                if ($payload["api_key"] !== "wasenderapi") {
                    $jsonPayload = json_encode($payload);
                    $response = Http::withBody(
                        $jsonPayload,
                        "application/json",
                    )->post("https://api.watzap.id/v1/send_message");
                    Log::error("Wa Response watzap: " . $response);

                    $arrResponse = json_decode($response, true);
                    $status = $arrResponse["status"] ?? "-";
                    $responseMessage = $arrResponse["message"];
                } else {
                    $response = Http::withToken($payload["number_key"])
                        ->acceptJson()
                        ->post("https://www.wasenderapi.com/api/send-message", [
                            "to" => $payload["phone_no"],
                            "text" => $payload["message"],
                        ]);
                    Log::error("Wa Response wasenderapi: " . $response);

                    $arrResponse = $response->json();
                    $status = $arrResponse["success"] ?? false;
                    $responseMessage = $status
                        ? $arrResponse["data"]["status"] ?? "Success"
                        : $arrResponse["message"] ?? "Gagal (unknown)";
                }

                // $response = Http::withHeaders([
                //     "Content-Type" => "application/json",
                // ])->post("https://api.watzap.id/v1/send_message", $payload);

                // Tambahkan delay setelah kirim pesan
                usleep(rand(1100000, 3200000)); // 1.1 - 3.2 detik

                if ($response->successful()) {
                    try {
                        $escapeMessage = $dbTraffic->real_escape_string($pesan);
                        $functionQuery =
                            "SELECT SentWA('Yogya_Muallimaat', '" .
                            $nomor .
                            "', '" .
                            $clientNumberKey .
                            "', '" .
                            $escapeMessage .
                            "')";
                        $functionResult = $dbTraffic->query($functionQuery);

                        if (!$functionResult) {
                            throw new \Exception(
                                "Error in SELECT function: " .
                                    $dbTraffic->error,
                            );
                        }

                        $lastNumber = $functionResult->fetch_row()[0];
                        $arrayResponse = json_encode($arrResponse);

                        $procedureQuery =
                            "CALL GetResp('" .
                            $arrayResponse .
                            "', '" .
                            $status .
                            "', '" .
                            $responseMessage .
                            "', " .
                            $lastNumber .
                            ")";
                        $procedureResult = $dbTraffic->query($procedureQuery);

                        if (!$procedureResult) {
                            throw new \Exception(
                                "Error in CALL procedure: " . $dbTraffic->error,
                            );
                        }
                    } catch (\Exception $e) {
                        logger("WA Procedure Error: " . $e->getMessage());
                    } finally {
                        $dbTraffic->close();
                    }
                } else {
                    logger("Gagal kirim ke $nomor: " . $response->body());
                    $status = "error";
                }
            } catch (\Exception $e) {
                logger("HTTP Exception: " . $e->getMessage());
                $status = "error";
                $response = $e->getMessage();
            }
        } else {
            logger("API Key not found");
        }

        // Log aktivitas pengguna
        $log = new LogModel();
        $log->user_id = Auth::user()->id;
        $log->menu = "Whatsapp Gaji";
        $log->aksi = "Kirim Whatsapp Gaji";
        $log->client_info = $request->server("HTTP_USER_AGENT");
        $log->target_id = "Kirim Whatsapp Gaji";
        $log->ip_address = $request->ip();
        $log->status = "kirim whatsapp";
        $log->save();

        $idLog = $log->id;

        try {
            DB::beginTransaction();

            LogWhatsappsModel::create([
                "custid" => $no,
                "log_id" => $idLog,
                "user_id" => Auth::id(),
                "status" => $status,
                "no_wa" => $nomor,
                "pesan" => $status === "error" ? $messageFail : $pesan,
                "nama" => $nama,
                "response" => is_string($response)
                    ? $response
                    : $response?->body() ?? "no response",
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            logger("LogWhatsappsModel Error: " . $e->getMessage());
        }
    }
}
