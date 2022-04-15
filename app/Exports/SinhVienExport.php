<?php

namespace App\Exports;

use App\Models\SinhVien;
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

class SinhVienExport implements FromCollection,
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
        'TT',
        'MSSV',
        'Họ',
        'Tên đệm và tên',
        'Địa chỉ Email',
        'Điện thoại',
        'Lớp',
        ];
    }
    public $count=0;
    public function map($row): array
    {
        $count=$this->count+=1;
        return [
            $count,
            $row->masinhvien,
            $row->holot,
            $row->ten,
            $row->email,
            $row->dienthoai,
            $row->malop,
        ];
    }
    public function startCell(): string
    {
        return 'A6';
    }
    public function collection()
    {
        return SinhVien::all();
    }
    public function styles(Worksheet $sheet)
    {
        $dt= Carbon::now();
        $ngay = Carbon::createFromFormat('Y-m-d H:i:s', $dt)->format('d/m/Y H:i:s');
        $sheet->mergeCells('A3:C3');
        $sheet->setCellValue('A3', 'Ngày xuất: '.$ngay);
        $sheet->mergeCells('C4:D4');
        
        $sheet->setCellValue('C4', 'DANH SÁCH SINH VIÊN');
    }
    public function registerEvents(): array
    {
       
        return [
            AfterSheet::class => function (AfterSheet $event) {
                //định dạng C4
                $cellRange = 'C4';
                $event->sheet->getDelegate()
                    ->getStyle($cellRange)
                    ->getFont()
                    ->setSize(20)
                    ->getColor()->setRGB('0000ff');

                $sinhvien = \DB::table('sinhvien')->count();
                $sinhvien=6 + $sinhvien;
                    //kẻ khung
                $event->sheet->getStyle('A6:G'.$sinhvien)->applyFromArray([
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
