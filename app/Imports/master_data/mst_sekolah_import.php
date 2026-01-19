<?php

namespace App\Imports\master_data;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class mst_sekolah_import implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        //
    }
}
