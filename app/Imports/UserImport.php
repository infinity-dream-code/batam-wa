<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Crypt;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UserImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
//        print_r($row);
        if ($row['nama']) {

            $username = strtolower(explode(' ', $row['nama'])[0]);
            $count = User::whereRaw('LOWER(username) = ?', [$username])->count();

            if ($count > 0) {
                $newUsername = $username . ($count + 1);
            } else {
                $newUsername = $username;
            }

            try {
                $tmt_pangkat = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(floatval($row['tmt_pangkat']));
                $tmt_pangkat = $tmt_pangkat->format('Y-m-d');
            } catch (\Exception $e) {
                $tmt_pangkat = $row['tmt_pangkat'];
            }

            try {
                $tmt_jabatan = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(floatval($row['tmt_jabatan']));
                $tmt_jabatan = $tmt_jabatan->format('Y-m-d');
            } catch (\Exception $e) {
                $tmt_jabatan = $row['tmt_jabatan'];
            }

            try {
                $tanggal_lahir = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(floatval($row['tanggal_lahir']));
                $tanggal_lahir = $tanggal_lahir->format('Y-m-d');
            } catch (\Exception $e) {
                $tanggal_lahir = $row['tanggal_lahir'];
            }

            try {
                $tmt_kpg = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(floatval($row['tmt_kpg']));
                $tmt_kpg = $tmt_kpg->format('Y-m-d');
            } catch (\Exception $e) {
                $tmt_kpg = $row['tmt_kpg'];
            }

            $insert = new User();
            $insert->username = $newUsername;
            $insert->password = bcrypt($newUsername);
            $insert->name = $row['nama'];
            $insert->pangkat = $row['pangkatgol'];
            $insert->nip = $row['nip'];
            $insert->jabatan = $row['jabatan'];
            $insert->agama = $row['agama'];
            $insert->jenis_kelamin = $row['jenis_kelamin'];
            $insert->unit_esl_3 = $row['unit_esl_3'];
            $insert->unit_esl_4 = $row['unit_esl_4'];
            $insert->tempat_lahir = $row['tempat_lahir'];
            $insert->pendidikan_terakhir = $row['pendidikan_terakhir'];
            $insert->tamat_jabatan = $tmt_jabatan;
            $insert->tamat_pangkat = $tmt_pangkat;
            $insert->nama_kantor = $row['nama_kantor'];
            $insert->pendidikan = $row['pendidikan'];
            $insert->generasi = $row['generasi'];
            $insert->kategori_umur = $row['kategori_umur'];
            $insert->golongan = $row['golongan'];
            $insert->tanggal_lahir = $tanggal_lahir;
            $insert->jenis_jabatan = $row['jenis_jabatan'];
            $insert->tamat_kpg = $tmt_kpg;
            $insert->homebase = $row['homebase'];
            $insert->status_menikah = $row['status_menikah'];
            $insert->masa_kerja = $row['masa_kerja'];

            $insert->save();

            $insert->assignRole('admin');
        }
    }
}
