<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ClientsExport implements FromCollection, WithHeadings
{
    protected $clients;

    public function __construct($clients)
    {
        $this->clients = $clients;
    }

    public function collection()
    {
        return $this->clients->map(function ($client) {
            return [
                'ID' => $client->id,
                'Name' => $client->name,
                'Short Name' => $client->shortName,
                'Abn' => $client->abn,
                'Phone Principal' => $client->phonePrinciple,
                'State' => $client->getState->name,
                'Status' => $client->status == 1 ? 'Active' : 'Inactive',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Short Name',
            'Abn',
            'Phone Principal',
            'State',
            'Status',
        ];
    }
}

