<?php


namespace App\Exports;
use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;


class ProductsExport implements FromCollection, WithHeadings, WithEvents
{
    public function collection()
    {
        return Product::all();
    }


    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Unit',
            'Category',
            'Description',
            'Stock',
            'Supplier',
            'Created At',
            'Updated At',
        ];
    }


    public function registerEvents(): array
    {
    return [
        AfterSheet::class => function (AfterSheet $event) {
            $sheet = $event->sheet->getDelegate();

            // Tambah 3 baris kosong di atas untuk header custom
            $sheet->insertNewRowBefore(1, 3);

            // Set teks judul
            $sheet->setCellValue('A1', 'PT DELIAMAZING');
            $sheet->setCellValue('A2', 'Jl. Karawang City');
            $sheet->setCellValue('A3', 'Rekap Stock Produk Gudang DELIAMAZING');

            // Merge kolom judul
            $sheet->mergeCells('A1:I1');
            $sheet->mergeCells('A2:I2');
            $sheet->mergeCells('A3:I3');

            // Style teks judul
            $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
            $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(13);
            $sheet->getStyle('A3')->getFont()->setBold(true)->setSize(12);
            $sheet->getStyle('A1:A3')->getAlignment()->setHorizontal('center');

            // Warna background header judul
            $sheet->getStyle('A1:I1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FFB4B4');

            $sheet->getStyle('A2:I2')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('5682B1');

            $sheet->getStyle('A3:I3')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FFB4B4');

      
            // Header tabel ada di baris ke-4 setelah insert row
            $sheet->getStyle('A4:I4')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('5682B1'); // Biru pastel

            $sheet->getStyle('A4:I4')->getFont()->setBold(true)->getColor()->setARGB('FFFFFF'); // Teks putih
            $sheet->getStyle('A4:I4')->getAlignment()->setHorizontal('center');

           //  Border tabel
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            $range = "A4:" . $highestColumn . $highestRow;

            $sheet->getStyle($range)->getBorders()->getAllBorders()->setBorderStyle(
                \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
            );
        },
    ];
}



 
}

