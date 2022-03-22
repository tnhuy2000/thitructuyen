<?php

namespace App\Exports;

use App\Models\HoiDongThi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class HoiDongThiExport implements FromCollection,
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
        'Mã cán bộ',
        'Họ lót',
        'Tên',
        'Địa chỉ Email',
        'Điện thoại',
        'Mã khoa',
        'Vai trò',
        ];
    }
  
    public function map($row): array
    {
        
        return [
            $row->macanbo,
            $row->holot,
            $row->ten,
            $row->email,
            $row->dienthoai,
            $row->makhoa,
            $row->vaitro,
        ];
    }
    public function startCell(): string
    {
        return 'A6';
    }
    public function collection()
    {
        return HoiDongThi::all();
    }
    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('B4:E4');
        
        $sheet->setCellValue('B4', 'DANH SÁCH HỘI ĐỒNG THI');
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

                $hoidongthi = \DB::table('hoidongthi')->count();
                $hoidongthi=6 + $hoidongthi;
                    //kẻ khung
                $event->sheet->getStyle('A6:G'.$hoidongthi)->applyFromArray([
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
