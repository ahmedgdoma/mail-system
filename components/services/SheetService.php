<?php


namespace components\services;


use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Yii;

class SheetService
{
    public static function read(string $fileName): array
    {
        return  IOFactory::load($fileName)->getActiveSheet()->toArray();
    }

    /**
     * @throws Exception
     */
    public static function write(array $data, string $fileNameWithPath): void
    {
        $fileName = self::getFileName($fileNameWithPath);
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->fromArray($data, NULL, 'A1');

        // redirect output to client browser
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save(Yii::getAlias('@webroot/processedFiles') . DIRECTORY_SEPARATOR . $fileName);
    }

    private static function getFileName(string $fileNameWithPath): string
    {
        return pathinfo($fileNameWithPath)['basename'];

    }

}