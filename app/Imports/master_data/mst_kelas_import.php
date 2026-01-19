<?php

namespace App\Imports\master_data;

use App\Models\master_data\mst_kelas;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class mst_kelas_import implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        function model(array $row)
        {
//        print_r($row);
            if ($row['kode_referensi']) {
                $checkKodeRef = mst_kelas::where('kode_ref', '=' . $row['kode_referensi'])->first();
                if (!$checkKodeRef) {
                    $insert = new mst_kelas();

                    $insert->save();
                }
            }
        }

        function headingRow(): int
        {
            return 2;
        }
    }
}
