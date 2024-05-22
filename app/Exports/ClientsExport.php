<?php

namespace App\Exports;

class ClientsExport
{
    protected $clients;

    public function __construct($clients)
    {
        $this->clients = $clients;
    }

    public function exportToCsv($filename)
    {
        $file = fopen($filename, 'w');

        // Add the headers to the CSV file
        fputcsv($file, $this->headings());

        // Add the data rows to the CSV file
        foreach ($this->collection() as $row) {
            fputcsv($file, $row);
        }

        fclose($file);
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
        })->toArray();
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
