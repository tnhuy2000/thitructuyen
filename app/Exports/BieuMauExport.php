<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BieuMauExport implements  WithStyles,
                                WithHeadings,
                                WithCustomStartCell,
                                WithMapping,
                                ShouldAutoSize
{
    protected $tenbieumau;
    public function __construct(string $tenbieumau) {
    	$this->tenbieumau = $tenbieumau;
    }
    public function headings(): array
    {
        if($this->tenbieumau=='khoa'){
            return [
                'Mã khoa',
                'Tên khoa',
                ];
        }
        elseif($this->tenbieumau=='lop'){
            return [
                'Mã lớp',
                'Tên lớp',
                'Mã khoa',
                'Tên khoa',
                'Niên khoá',
                ];
        }
        elseif($this->tenbieumau=='hocphan'){
            return [
                'Mã học phần',
                'Tên học phần',
                'Số tín chỉ',
                ];
        }
        elseif($this->tenbieumau=='sinhvien'){
            return [
                'MSSV',
                'Họ',
                'Tên đệm và tên',
                'Địa chỉ Email',
                'Điện thoại',
                'Lớp',
                ];
        }
        elseif($this->tenbieumau=='hoidongthi'){
            return [
                'Mã cán bộ',
                'Họ lót',
                'Tên',
                'Địa chỉ Email',
                'Điện thoại',
                'Mã khoa',
                'Tên khoa',
                'Vai trò',
                ];
        }
        elseif($this->tenbieumau=='kythi'){
            return [
                'Tên kỳ thi',
                'Học kỳ',
                'Năm học',
                ];
        }
        elseif($this->tenbieumau=='cathi'){
            return [
                'STT',
                'Ca thi',
                'Ngày thi',
                'Giờ bắt đầu',
                'Mật khẩu ca thi',
                ];
        }
        elseif($this->tenbieumau=='phongthi'){
            return [
                'Ca thi',
                'Mã phòng',
                'Số lượng thí sinh',
                'Đề thi',
                'Ghi chú',
                ];
        }
        elseif($this->tenbieumau=='sv_pt'){
            return [
                'Phòng thi',
                'Mã sinh viên',
                'Họ lót',
                'Tên',
                'Ghi chú',
                ];
        }
        elseif($this->tenbieumau=='hdt_pt'){
            return [
                'Phòng thi',
                'Mã cán bộ',
                'Họ lót',
                'Tên',
                'Vai trò',
                'Ghi chú',
                ];
        }
        elseif($this->tenbieumau=='dethi'){
            return [
                'Kỳ thi',
                'Học kỳ',
                'Năm học',
                'Học phần',
                'Thời gian làm bài',
                'Hình thức',
                ];
        }
        
        
    }
  
    public function map($row): array
    {
        return [
        
        ];
    }
    public function startCell(): string
    {
        return 'A6';
    }
    
  
    public function styles(Worksheet $sheet)
    {
        if($this->tenbieumau=='khoa'){
            $sheet->mergeCells('A4:D4');
            $sheet->setCellValue('A4', 'DANH SÁCH KHOA - PHÒNG BAN');
        }
        elseif($this->tenbieumau=='lop'){
            $sheet->mergeCells('B4:C4');
            $sheet->setCellValue('B4', 'DANH SÁCH LỚP');
        }
        elseif($this->tenbieumau=='hocphan'){
            $sheet->mergeCells('B4:C4');
            $sheet->setCellValue('B4', 'DANH SÁCH HỌC PHẦN');
        }
        elseif($this->tenbieumau=='sinhvien'){
            $sheet->mergeCells('C4:D4');
            $sheet->setCellValue('C4', 'DANH SÁCH SINH VIÊN');
        }
        elseif($this->tenbieumau=='hoidongthi'){
            $sheet->mergeCells('C4:D4');
            $sheet->setCellValue('C4', 'DANH SÁCH HỘI ĐỒNG THI');
        }
        elseif($this->tenbieumau=='kythi'){
            $sheet->mergeCells('A4:B4');
            $sheet->setCellValue('A4', 'DANH SÁCH KỲ THI');
        }
        elseif($this->tenbieumau=='cathi'){
            
            $sheet->mergeCells('A2:D2');
            $sheet->mergeCells('B3:C3');
            $sheet->mergeCells('B4:C4');
            $sheet->setCellValue('B3','Học kỳ: ');
            $sheet->setCellValue('B4','Năm học: ');
            $sheet->setCellValue('A2', mb_strtoupper('KỲ THI',"utf8"));
        }
        elseif($this->tenbieumau=='phongthi'){
            $sheet->mergeCells('C4:D4');
            $sheet->setCellValue('C4', 'DANH SÁCH PHÒNG THI');
        }
        elseif($this->tenbieumau=='sv_pt'){
            $sheet->mergeCells('C4:D4');
            $sheet->setCellValue('C4', 'DANH SÁCH SINH VIÊN - PHÒNG THI');
        }
        elseif($this->tenbieumau=='hdt_pt'){
            $sheet->mergeCells('C4:D4');
            $sheet->setCellValue('C4', 'DANH SÁCH HỘI ĐỒNG THI - PHÒNG THI');
        }
        elseif($this->tenbieumau=='dethi'){
            $sheet->mergeCells('C4:D4');
            $sheet->setCellValue('C4', 'DANH SÁCH ĐỀ THI');
        }
        
        
    }
    
}
