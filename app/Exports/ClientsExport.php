<?php

namespace App\Exports;

class ClientsExport
{
    protected $clients;

    public function __construct($clients)
    {
        $this->clients = $clients;
    }

    public function exportToCsv()
    {
        $content = $this->generateCsvHeaders() . "\r\n";
        foreach ($this->collection() as $index => $row) {
            $content .= $this->generateCsvRow($index + 1, $row) . "\r\n";
        }
        return $content;
    }

    protected function generateCsvHeaders()
    {
        return implode(',', [
            'ID',
            'Name',
            'Short Name',
            'Abn',
            'Phone Principal',
            'State',
            'Status',
        ]);
    }

    protected function generateCsvRow($index, $row)
    {
        return implode(',', [
            $row['ID'],
            $row['Name'],
            $row['Short Name'],
            $row['Abn'],
            $row['Phone Principal'],
            $row['State'],
            $row['Status'],
        ]);
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
}
