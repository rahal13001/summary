<?php

namespace App\Exports;

use App\Models\Report;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AdminsExport implements FromQuery, WithHeadings, WithStyles, ShouldAutoSize, WithMapping, WithColumnWidths
{
    /**
    * @return \Illuminate\Support\Collection
    */
 
    use Exportable;

    protected $from_date;
    protected $to_date;

    public function __construct($from_date, $to_date)
    {
        $this->from_date = $from_date;
        $this->to_date = $to_date;
    }
    //Utamakan pakai qury untuk load data besar dengan lebih mudah
    public function query()
    {
    
        //Jika this from_date ada value(datanya) maka
            if (!empty($this->from_date)) {
                //Jika tanggal awal(from_date) hingga tanggal akhir(to_date) adalah sama maka
                if ($this->from_date === $this->to_date) {
                    //kita filter tanggalnya sesuai dengan this from_date
                    $query = Report::query()->whereDate('when', '=', $this->from_date)->with(['user', 'indicators', 'follower']);
                } else {
                    //kita filter dari tanggal awal ke akhir
                    $query = Report::query()->whereBetween('when', array($this->from_date, $this->to_date))->with(['user', 'indicators', 'follower']);
                }
            } else {
                $query = Report::query()->with(['user', 'indicators', 'follower']);
            }

            return $query;
            
    }

    public function map($query): array
    {
      
        $isi = [
            $query->what,
            $query->when,
            $query->user->name,
            'pengikut' => array(),
            'indicator' => array(),
            $query->why,
            $query->where,
            $query->who,
            $query->how,
            'http://summary.timurbersinar.com/dokumentasi/'.$query->documentation->dokumentasi1,
            'http://summary.timurbersinar.com/dokumentasi/'.$query->documentation->dokumentasi2,
            'http://summary.timurbersinar.com/dokumentasi/'.$query->documentation->dokumentasi3,
            'http://summary.timurbersinar.com/lihat_lainnya/'.$query->documentation->lainnya,
            'http://summary.timurbersinar.com/lihat_st/'.$query->documentation->st,
            'http://summary.timurbersinar.com/pdf/'.$query->slug            
        ];
          foreach ($query->indicators as $iku) {
          $isi['indicator'][]=
                $iku->nomor;
        }
         foreach ($query->follower as $data) {
            
                $isi['pengikut'][] =
                $data->name;  
        }
        
        return $isi;
    }
    
    public function headings(): array
    {
        return [
            'What',
            'When',
            'Penyusun',
            'Pengikut',
            'Nomor IKU',
            'Why',
            'Where',
            'Who',
            'How',
            'Dokumentasi 1',
            'Dokumentasi 2',
            'Dokumentasi 3',
            'Lainnya',
            'ST',
            '5W1H'
            
        ];
    }
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]]
        ];
    }

     public function columnWidths(): array
    {
        return [
            //what
            'A' => 45,
            //when
            // 'B' => 12,
            //penyusun
            'C' => 12,
            //pengikut
            // 'D' => 10,
            //nomor iku
            'E' => 30,
            //why
            'F' => 35,
            //where
            'G' => 35,
            //who
            'H' => 55,
            //how
            'I' => 55,
            //dokumentasi 1
            'J' => 25,
            //dokumentasi 2
            'K' => 25,
            //dokumentasi 3
            'L' => 25,
            //lainnya
            'M' => 25,
            //st
            'N' => 25,
            //5w1h
            'O' => 25,

        ];
    }

}
