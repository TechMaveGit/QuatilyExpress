<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

class PersonExport
{
    protected $persons;

    public function __construct($persons)
    {
        $this->persons = $persons;
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
        $tempFile = tempnam(sys_get_temp_dir(), 'person_report');
        $writer->save($tempFile);

        return $tempFile;
    }

    protected function generateCsvHeaders()
    {
        return implode(',', [
            'Full Name',
            'Mobile No',
            'Email',
            'DOB',
            'Status',
            'Extra Rate Per Hour'
        ]);
    }

    protected function generateHeaders()
    {
        return [
            'Full Name',
            'Mobile No',
            'Email',
            'DOB',
            'Status',
            'Extra Rate Per Hour'
        ];
    }

    protected function generateCsvRow($index, $row)
    {
        return implode(',', [
            $row['Full Name'],
            $row['Mobile No'],
            $row['Email'],
            $row['DOB'],
            $row['Status'],
            $row['Extra Rate Per Hour']
        ]);
    }

    public function collection()
    {
        return $this->persons->map(function ($person) {
            return [
                'Full Name' => $person->fullName,
                'Mobile No' => $person->mobileNo,
                'Email' => $person->email,
                'DOB' => $person->dob,
                'Status' => $person->status == 1 ? 'Active' : 'Inactive',
                'Extra Rate Per Hour' => $person->extra_rate_per_hour,
            ];
        })->toArray();
    }
}
