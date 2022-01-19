<?php

namespace App\Exports;

use App\Models\Report;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AdminsExport implements FromQuery, WithHeadings, WithStyles, ShouldAutoSize, WithMapping
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
            'Who'
            
        ];
    }
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]]
        ];
    }

}
