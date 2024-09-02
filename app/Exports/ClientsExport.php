<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

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

    public function exportToXls()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Add headers
        $headers = $this->generateHeaders();
        $sheet->fromArray($headers, NULL, 'A1');

        // Add data
        $data = $this->collection();
        $sheet->fromArray($data, NULL, 'A2');

        // Create the XLS writer
        $writer = new Xls($spreadsheet);

        // Save to a temporary file
        $tempFile = tempnam(sys_get_temp_dir(), 'client_report');
        $writer->save($tempFile);

        return $tempFile;
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

    protected function generateHeaders()
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
