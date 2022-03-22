<?php
namespace App\Exports;
use App\Models\Lop;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LopExport implements FromCollection,
                                WithHeadings,
                                WithCustomStartCell,
                                WithMapping,
                                WithStyles,
                                WithEvents,
                                ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return [
        'Mã lớp',
        'Tên lớp',
        'Mã khoa',
        'Niên khoá',
        ];
    }
  
    public function map($row): array
    {
        return [
            $row->malop,
            $row->tenlop,
            $row->makhoa,
            $row->nienkhoa,
        ];
    }
    public function startCell(): string
    {
        return 'A6';
    }
    public function collection()
    {
        return Lop::all();
    }
    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('B4:C4');
        
        $sheet->setCellValue('B4', 'DANH SÁCH LỚP');
    }
    public function registerEvents(): array
    {
       
        return [
            AfterSheet::class => function (AfterSheet $event) {
                //định dạng B4
                $cellRange = 'B4';
                $event->sheet->getDelegate()
                    ->getStyle($cellRange)
                    ->getFont()
                    ->setSize(20)
                    ->getColor()->setRGB('0000ff');

                $lop = \DB::table('lop')->count();
                $lop=6 + $lop;
                    //kẻ khung
                $event->sheet->getStyle('A6:D'.$lop)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
                
            }
            
           
        ];
    }
}