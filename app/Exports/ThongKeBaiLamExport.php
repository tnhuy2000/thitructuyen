<?php

namespace App\Exports;

use App\Models\BaiThi;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ThongKeBaiLamExport implements FromCollection,
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
        'Ca thi',
        'Ngày thi',
        'Phòng',
        'Số lượng thí sinh',
        'Tổng số bài làm',
        ];
    }
  
    public function map($row): array
    {
        $ngay = Carbon::createFromFormat('Y-m-d', $row->ngaythi)->format('d/m/Y');
        return [
            $row->tenca,
            $ngay,
            $row->maphong,
            $row->soluongthisinh,
            $row->soluongbaithi,
        ];
    }
    public function startCell(): string
    {
        return 'A6';
    }
    public function collection()
    {
        $results = \DB::select(\DB::raw("select ct.tenca,
        pt.maphong,
        ct.ngaythi,
        pt.soluongthisinh,
        count(bt.id) as soluongbaithi
        FROM
        baithi as bt
        inner join dethi_phongthi dtpt on dtpt.id = bt.dethiphongthi_id
        inner join phongthi pt on pt.id = dtpt.phongthi_id
        inner join cathi ct on ct.id = pt.cathi_id
        where
        bt.trangthai = 1
        group by ct.tenca,pt.maphong,
                    ct.ngaythi,
                    pt.soluongthisinh"));


        return collect($results);
    }
    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('B4:D4');
        
        $sheet->setCellValue('B4', 'THỐNG KÊ BÀI LÀM');
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

              
                    $ct = \DB::table('cathi as  ct')->join('phongthi as pt', 'pt.cathi_id', '=', 'ct.id')->count();
                    $ct=6 + $ct;
                        //kẻ khung
                    $event->sheet->getStyle('A6:E'.$ct)->applyFromArray([
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
