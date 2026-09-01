<?php

namespace App\Writers\Payment;

use App\Classes\BankRaportWriter;
use App\Classes\FileModel;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\IOFactory;

class DefaultWriter extends BankRaportWriter
{
    public function fileName(): string
    {
        return 'bank_raport.csv';
    }

    public function getFileName(int $in_raport_npp): string
    {
        return 'sp' . $this->bank->number . '_' . str_pad($this->npp, 3, '0', STR_PAD_LEFT) . '.xls';
    }

    public function writeFileContent(FileModel $file, array $data): void
    {
        $spreadsheet = IOFactory::load($this->template->getFullPath());

        $sheet = $spreadsheet->getActiveSheet();

        // Пишем массив
        foreach ($data['recipients'] as $rowIndex => $recipient) {
            $excelIndex = $rowIndex + 2;

            $sheet->setCellValue('A' .          $excelIndex, $rowIndex + 1);
            $sheet->setCellValueExplicit('B' .  $excelIndex, (string)   ($recipient->last_name . ' ' . $recipient->first_name . ' ' . $recipient->middle_name), DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('C' .  $excelIndex, (string)   $recipient->account, DataType::TYPE_STRING);
            $sheet->setCellValue('D' .          $excelIndex, (float)    $recipient->amount);
            $sheet->setCellValueExplicit('E' .  $excelIndex, (string)   $recipient->d_rojd->format('d.m.Y'), DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('F' .  $excelIndex, (string)   $recipient->p_number, DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('G' .  $excelIndex, (string)   $data['payment']->kbk, DataType::TYPE_STRING);
        }

        // Пишем итоги
        $sheet->setCellValue('C' . $excelIndex + 1, 'ИТОГО:');
        $sheet->setCellValue('D' . $excelIndex + 1, $data['recipients']->sum('amount'));

        $writer = IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save($file->getFullPath());
    }
}
