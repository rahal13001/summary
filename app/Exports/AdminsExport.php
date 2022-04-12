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

        if ($query->documentation->dokumentasi2 === NULL) {
            $dokumentasi2 = '';
        }else {
            $dokumentasi2 = 'http://summary.timurbersinar.com/dokumentasi/'.$query->documentation->dokumentasi2;
        }

          if ($query->documentation->dokumentasi3 === NULL) {
            $dokumentasi3 = '';
        }else {
            $dokumentasi3 = 'http://summary.timurbersinar.com/dokumentasi/'.$query->documentation->dokumentasi3;
        }

          if ($query->documentation->lainnya === NULL) {
            $lainnya = '';
        }else {
            $lainnya = 'http://summary.timurbersinar.com/lihat_lainnya/'.$query->documentation->lainnya;
        }

          if ($query->documentation->st === NULL) {
            $st = '';
        }else {
            $st = 'http://summary.timurbersinar.com/lihat_st/'.$query->documentation->st;
        }

        // foreach ($query->indicators as $iku) {
        //    $ikunya[] = $iku->nomor;
        // }
        // $ikuini = implode(", ", $ikunya);

        //   foreach ($query->follower as $data) {
        //     $pengikutnya['ini'][] = $data->name;  
        // }
        // $pengikutini = implode(", ", $pengikutnya['ini']);
       

        $isi = [
            $query->what,
            $query->when,
            $query->user->name,
            'pengikut'=>array(),
            'indicator'=>array(),
            $query->why,
            $query->where,
            $query->penyelenggara,
            $query->who,
            strip_tags($query->how),
            'http://summary.timurbersinar.com/dokumentasi/'.$query->documentation->dokumentasi1,
            $dokumentasi2,
            $dokumentasi3,
            $lainnya,
            $st,
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
            'Penyelenggara',
            'Who',
            'How',
            'Dokumentasi 1',
            'Dokumentasi 2',
            'Dokumentasi 3',
            'Lainnya',
            'ST',
            '5W1H',
            
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
            'B' => 12,
            //penyusun
            'C' => 12,
            //pengikut
            'D' => 25,
            //nomor iku
            'E' => 30,
            //why
            'F' => 35,
            //Penyelenggara
            'G' => 35,
            //where
            'H' => 35,
            //who
            'I' => 55,
            //how
            'J' => 55,
            //dokumentasi 1
            'K' => 25,
            //dokumentasi 2
            'L' => 25,
            //dokumentasi 3
            'M' => 25,
            //lainnya
            'N' => 25,
            //st
            'O' => 25,
            //5w1h
            'P' => 25,

        ];
    }

}
