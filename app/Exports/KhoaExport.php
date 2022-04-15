<?php
namespace App\Exports;
use App\Models\Khoa;
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
class KhoaExport implements FromCollection,
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
        'Mã khoa',
        'Tên khoa',
        ];
    }
  
    public function map($row): array
    {
        
        return [
            $row->makhoa,
            $row->tenkhoa,
        ];
    }
    public function startCell(): string
    {
        return 'A6';
    }
    public function collection()
    {
        return Khoa::all();
    }
    public function styles(Worksheet $sheet)
    {
        $dt= Carbon::now();
        $ngay = Carbon::createFromFormat('Y-m-d H:i:s', $dt)->format('d/m/Y H:i:s');
        $sheet->mergeCells('A3:B3');
        $sheet->setCellValue('A3', 'Ngày xuất: '.$ngay);
        
        $sheet->mergeCells('A4:C4');
        
        $sheet->setCellValue('A4', 'DANH SÁCH KHOA/PHÒNG BAN');
    }
    public function registerEvents(): array
    {
       
        return [
            AfterSheet::class => function (AfterSheet $event) {
                //định dạng B4
                $cellRange = 'A4';
                $event->sheet->getDelegate()
                    ->getStyle($cellRange)
                    ->getFont()
                    ->setSize(20)
                    ->getColor()->setRGB('0000ff');

                $khoa = \DB::table('khoa')->count();
                $khoa=6 + $khoa;
                    //kẻ khung
                $event->sheet->getStyle('A6:B'.$khoa)->applyFromArray([
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