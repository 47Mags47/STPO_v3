<?php

namespace App\Writers\Payment;

use App\Classes\BankRaportWriter;
use App\Classes\FileModel;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\IOFactory;

class AlfaBankWriter extends BankRaportWriter
{
    public function getFileName(int $in_raport_npp): string
    {
        return
            $this->data['config']['division']['INN'] .
            '_' .
            preg_replace("/[^а-яА-ЯёЁ]+/i", '', $this->data['config']['division']['short_name']) .
            '_' .
            $this->payment->number .
            '.xls';
    }

    public function writeFileContent(FileModel $file, array $data): void
    {
        $spreadsheet = IOFactory::load($this->template->getFullPath());

        $sheet = $spreadsheet->getSheetByName('Info');

        $sheet->setCellValue('B1', $this->config['division']['short_name']);
        $sheet->setCellValue('B2', $this->config['division']['INN']);
        $sheet->setCellValue('B6', $this->event->in_date->format('d.m.Y'));
        $sheet->setCellValue('B7', '288');
        $sheet->setCellValue('B8', 'RUR');

        $sheet = $spreadsheet->getSheetByName('Payments');
        foreach ($data['recipients'] as $rowIndex => $recipient) {
            $excelIndex = $rowIndex + 2;

            $sheet->setCellValueExplicit('A' .  $excelIndex, (string) $recipient->last_name, DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('B' .  $excelIndex, (string) $recipient->first_name, DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('C' .  $excelIndex, (string) $recipient->middle_name, DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('D' .  $excelIndex, (string) $recipient->account, DataType::TYPE_STRING);
            $sheet->setCellValue('E' .          $excelIndex, (float)  $recipient->amount);
        }

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($file->getFullPath());
    }
}
