<?php

namespace App\Imports;

use Illuminate\Support\Collection;

class UsersImport
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
        $clients = [];
        foreach ($rows as $row) {
            // Access each column value from the current row
            $clients[] = $row['1'];
            $costCenter = $row['0'];

        }
        echo '<pre>';
        print_r($clients);
        die;
    }

    public function startRow(): int
    {
        return 2;
    }
}
