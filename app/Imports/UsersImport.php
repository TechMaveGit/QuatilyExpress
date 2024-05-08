<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithStartRow;
class UsersImport implements ToCollection,WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    { 
        $clients=[];
        foreach ($rows as $row) {
            // Access each column value from the current row
            $clients[] = $row['1'];
            $costCenter = $row['0'];
           
        }
        echo "<pre>";
        print_r($clients);
        die;
    }
    public function startRow(): int
    {
        return 2; 
    }
}
