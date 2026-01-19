<?php

namespace App\Imports\Tagihan;

use App\Models\master_data\import\ImportMasterSiswa;
use App\Models\master_data\mst_kelas;
use App\Models\master_data\mst_post;
use App\Models\master_data\mst_siswa;
use App\Models\master_data\mst_thn_aka;
use App\Models\Tagihan\ImportTagihan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;


class TagihanImport implements WithMultipleSheets, ToModel, WithHeadingRow
{
    public function sheets(): array
    {
        return [
            0 => $this, // Only process the first sheet
        ];
    }

    public function model(array $row): void
    {
        if (isset($row['nis']) && isset($row['nama_tagihan']) && isset($row['nominal']) && isset($row['tahun_akademik'])) {
            $status = 1;
            $status_ket = null;
            $existingSiswa = mst_siswa::where('nis', $row['nis'])->exists();
            if (!$existingSiswa) {
                $status = 0;
                $status_ket = 'Siswa dengan NIS: ' . $row['nis'] . ' tidak ada pada master data siswa';
            }

            $existingPost = mst_post::where('nama_post', 'like', $row['nama_tagihan'])->exists();
            if (!$existingPost) {
                $status = 0;
                if (!empty($status_ket)) $status_ket .= ', ';
                $status_ket .= 'Nama Taighan: ' . $row['nama_tagihan'] . ' tidak ada pada master data post';
            }

            $existingTahunAkademik = mst_thn_aka::where('thn_aka','like', $row['tahun_akademik'])->exists();
            if (!$existingTahunAkademik) {
                $status = 0;
                if (!empty($status_ket)) $status_ket .= ', ';
                $status_ket .= 'Tahun Akademik: ' . $row['tahun_akademik'] . ' tidak ada pada master data tahun akademik';
            }

            $nominal = 0;
            if (is_numeric($row['nominal'])) {
                $nominal = $row['nominal'];
            }else if (is_string($row['nominal'])) {
                $status = 0;
                if (!empty($status_ket)) $status_ket .= ', ';
                $status_ket .= 'Nominal tagihan: ' . $row['nominal'] . ' bukan angka';
            }else if ($nominal == 0){
                $status = 0;
                if (!empty($status_ket)) $status_ket .= ', ';
                $status_ket .= 'Nominal tagihan tidak boleh Rp. 0';
            }

            $cicilan = 0;
            if (isset($row['cicil'])){
                $cicilOptions = ["yes","ya",'benar','cicil'];
                $cicilInput = strtolower($row['cicil']);
                if (in_array($cicilInput, $cicilOptions)) {
                    $cicilan = 1;
                }
            }

            $data_tagihan = [
                'nis' => $row['nis'],
                'nominal' => $nominal,
                'nama_tagihan' => $row['nama_tagihan'],
                'tahun_akademik' => $row['tahun_akademik'],
                'cicil' => $cicilan,
                'import_status' => $status,
                'import_ket' => $status_ket,
            ];

            ImportTagihan::create($data_tagihan);
        }
    }

    public function headingRow(): int
    {
        return 1;
    }
}
