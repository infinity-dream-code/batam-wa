<?php

namespace App\Imports\master_data;

use App\Models\master_data\import\ImportMasterSiswa;
use App\Models\master_data\mst_kelas;
use App\Models\master_data\mst_siswa;
use App\Models\master_data\mst_thn_aka;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MasterSiswaImport implements ToModel, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function model(array $row): void
    {
        if (isset($row['nis']) && isset($row['nama']) && isset($row['kelas']) && isset($row['angkatan'])) {
            $status = 1;
            $status_ket = null;
            $existingSiswa = mst_siswa::where('nis', $row['nis'])->count();
            if ($existingSiswa > 0) {
                $status = 2;
                $status_ket = 'Siswa dengan NIS: ' . $row['nis'] . ' sudah terdaftar';
            }
//
//            $existingSiswaImport = ImportMasterSiswa::where('nis', $row['nis'])->count();
//            if ($existingSiswaImport > 0) {
//                $status = 0;
//                if (!empty($status_ket)) {
//                    $status_ket .= ',Siswa dengan NIS: ' . $row['nis'] . ' sudah ada pada data import';
//                } else {
//                    $status_ket = 'Siswa dengan NIS: ' . $row['nis'] . ' sudah ada pada data import';
//                }
//            }

            $kelas = mst_kelas::where('kelas', $row['kelas'])
                ->where('kelompok', $row['kelompok'])
                ->where('unit', $row['unit'])->exists();
            if (!$kelas) {
                $status = 0;
                if (!empty($status_ket)) {
                    $status_ket .= ', ';
                } else {
                    $status_ket .= 'Kelas: ' . $row['kelas'] . ' '. $row['kelompok']. ' '. $row['unit']. ' tidak ada pada master data Kelas';
                }
            }

            $angkatan = mst_thn_aka::where('thn_aka', $row['angkatan'])->exists();
            if (!$angkatan) {
                $status = 0;
                if (!empty($status_ket)) {
                    $status_ket .= ', ';
                } else {
                    $status_ket .= 'Angkatan: ' . $row['angkatan'] . ' tidak ada pada master data Angkatan';
                }
            }

            $jenisKelamin = 0;
            if (isset($row['jenis_kelamin'])) {
                $lakiLakiOptions = ["laki-laki", "laki laki", "pria", "cowok", "laki"];
                $jenisKelaminInput = strtolower($row['jenis_kelamin']);
                if (in_array($jenisKelaminInput, $lakiLakiOptions)) {
                    $jenisKelamin = 1;
                }
            }

            $tanggal_lahir = null;
            if (isset($row['tanggal_lahir'])) {
                try {
                    $tanggal_lahir = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(floatval($row['tanggal_lahir']));
                    $tanggal_lahir = $tanggal_lahir->format('Y-m-d');
                } catch (\Exception $e) {
                    $tanggal_lahir = $row['tanggal_lahir'];
                }
            }

            $dataUser = [
                'no_pendaftaran' => $row['no_pendaftaran'] ?? null,
                'nisn' => $row['nisn'] ?? null,
                'nama' => $row['nama'],
                'agama' => $row['agama'] ?? null,
                'tmp_lahir' => $row['tempat_lahir'] ?? null,
                'tgl_lahir' => $tanggal_lahir ?? null,
                'jk' => $jenisKelamin,
                'kelas' => $row['kelas'],
                'kelompok' => $row['kelompok'],
                'unit' => $row['unit'],
                'angkatan' => $row['angkatan'],
                'alamat' => $row['alamat'] ?? null,
                'nowa' => $row['nomor_whatsapp'] ?? null,
                'email' => $row['email'] ?? null,
                'nama_ortu' => $row['nama_orang_tua'] ?? null,
                'import_status' => $status,
                'import_ket' => $status_ket,
            ];

            ImportMasterSiswa::updateOrInsert(['nis' => $row['nis']], $dataUser);
        }
    }

    public function headingRow(): int
    {
        return 1;
    }
}
