<?php

namespace App\Exports;
use Carbon\Carbon;
use App\Models\CaThi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CaThiExport implements FromCollection,
                                WithHeadings,
                                WithCustomStartCell,
                                WithMapping,
                                WithStyles,
                                WithEvents,
                                ShouldAutoSize
{
    protected $kythi_id; 
    protected $tenkythi; 
    protected $hocky; 
    protected $namhoc; 
    
    public function __construct($kythi_id,$tenkythi,$hocky,$namhoc)
    {
        $this->kythi_id = $kythi_id; 
        $this->tenkythi = $tenkythi; 
        $this->hocky = $hocky; 
        $this->namhoc = $namhoc; 
    }
    public function headings(): array
    {
        return [
        'STT',
        'Ca thi',
        'Ngày thi',
        'Giờ bắt đầu',
        ];
    }
    public $count=0;
    public function map($row): array
    {
        $ngay = Carbon::createFromFormat('Y-m-d', $row->ngaythi)->format('d/m/Y');
        $giobatdau= Carbon::createFromFormat('H:i:s', $row->giobatdau)->format('H:i');

        $subject=$giobatdau;
        $search = [':'];
        $replace   = 'g';
        $result = str_replace($search, $replace, $subject);	
        $count=$this->count+=1;
        return [
            $count,
            $row->tenca,
            $ngay,
            $result,
        ];
    }
    public function startCell(): string
    {
        return 'A6';
    }
    public function collection()
    {

        $kythi_id=$this->kythi_id;
        //return CaThi::all();
        return CaThi::where('kythi_id', $kythi_id)->get();
       
    }
    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A2:D2');
        $sheet->mergeCells('B3:C3');
        $sheet->mergeCells('B4:C4');
        $sheet->setCellValue('B3','Học kỳ: '. $this->hocky);
        $sheet->setCellValue('B4','Năm học: '. $this->namhoc);
        $sheet->setCellValue('A2', mb_strtoupper($this->tenkythi,"utf8"));
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                //định dạng C4
                $cellRange = 'A2';
                $event->sheet->getDelegate()
                    ->getStyle($cellRange)
                    ->getFont()
                    ->setSize(16)
                    ->getColor()->setRGB('0000ff');
            }
            
           
        ];
    }
}
