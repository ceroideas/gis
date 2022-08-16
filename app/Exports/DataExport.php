<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;

class DataExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct($data){
        $this->data = $data;
    }

    public function collection(){
        return $this->data;
    }
}
