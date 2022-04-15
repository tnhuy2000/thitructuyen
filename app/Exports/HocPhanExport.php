<?php

namespace App\Exports;

use App\Models\HocPhan;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class HocPhanExport implements FromCollection,
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
        'Mã học phần',
        'Tên học phần',
        'Số tín chỉ',
      
        ];
    }
  
    public function map($row): array
    {
        
        return [
            $row->mahocphan,
            $row->tenhocphan,
            $row->sotinchi,
        ];
    }
    public function startCell(): string
    {
        return 'A6';
    }
    public function collection()
    {
        return HocPhan::all();
    }
    public function styles(Worksheet $sheet)
    {
        $dt= Carbon::now();
        $ngay = Carbon::createFromFormat('Y-m-d H:i:s', $dt)->format('d/m/Y H:i:s');
        $sheet->mergeCells('A3:B3');
        $sheet->setCellValue('A3', 'Ngày xuất: '.$ngay);
        
        $sheet->mergeCells('B4:E4');
        
        $sheet->setCellValue('B4', 'DANH SÁCH HỌC PHẦN');
    }
    public function registerEvents(): array
    {
       
        return [
            AfterSheet::class => function (AfterSheet $event) {
                //định dạng C4
                $cellRange = 'B4';
                $event->sheet->getDelegate()
                    ->getStyle($cellRange)
                    ->getFont()
                    ->setSize(20)
                    ->getColor()->setRGB('0000ff');

                $hocphan = \DB::table('hocphan')->count();
                $hocphan=6 + $hocphan;
                    //kẻ khung
                $event->sheet->getStyle('A6:C'.$hocphan)->applyFromArray([
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
