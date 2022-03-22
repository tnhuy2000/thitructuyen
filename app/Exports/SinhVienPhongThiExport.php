<?php

namespace App\Exports;

use App\Models\SinhVien_PhongThi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SinhVienPhongThiExport implements FromCollection,
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
    protected $id;
    public function __construct(int $id) {
    	$this->id = $id;
    }

    
    public function headings(): array
    {
        return [
        'Phòng ID',
        'Mã sinh viên',
        'Điểm danh',
        'Ghi chú',
        ];
    }
  
    public function map($row): array
    {
       
        return [
            
            $row->phongthi_id,
            $row->masinhvien,
            $row->diemdanh,
            $row->ghichu,
        ];
    }
    public function startCell(): string
    {
        return 'A6';
    }
    
    public function collection()
    {
        return SinhVien_PhongThi::all();
        
    }
    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('B4:C4');
        
        $sheet->setCellValue('B4', 'DANH SÁCH SINH VIÊN - PHÒNG THI');
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

                $sv_pt = \DB::table('sinhvien_phongthi')->count();
                $sv_pt=6 + $sv_pt;
                    //kẻ khung
                $event->sheet->getStyle('A6:D'.$sv_pt)->applyFromArray([
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
