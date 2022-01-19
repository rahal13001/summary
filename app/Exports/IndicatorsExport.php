<?php

namespace App\Exports;

use App\Models\Indicator;
use App\Models\Tag;
use App\Models\Report;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class IndicatorsExport implements FromQuery, WithHeadings, WithStyles, ShouldAutoSize, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $from_date;
    protected $to_date;

    public function __construct($from_date, $to_date, $indicator_id)
    {
        $this->from_date = $from_date;
        $this->to_date = $to_date;
        $this->indicator_id = $indicator_id;
       
      
    }

    public function query()
    {  
      
         $indicator = Indicator::where('id', $this->indicator_id)->get();
            foreach ($indicator as $ind) {
                $id = $ind->id;
            }
           //Jika this from_date ada value(datanya) maka
            if (!empty($this->from_date)) {
                //Jika tanggal awal(from_date) hingga tanggal akhir(to_date) adalah sama maka
                if ($this->from_date === $this->to_date) {
                    //kita filter tanggalnya sesuai dengan this from_date
                    $query = Report::query()->whereDate('when', '=', $this->from_date)->where('indicators.id', $id)->with(['user', 'indicators', 'follower'])->whereHas(
                    'indicators',function($target) use($id){
                        $target->where('id', $id);}
                );;
                } else {
                    //kita filter dari tanggal awal ke akhir
                    $query = Report::query()->whereBetween('when', array($this->from_date, $this->to_date))->where('id', $id)->with(['user', 'indicators', 'follower'])->whereHas(
                    'indicators',function($target) use($id){
                        $target->where('id', $id);}
                );;
                }
            } else {
                $query = Report::query()->with(['user', 'indicators', 'follower'])->whereHas(
                    'indicators',function($target) use($id){
                        $target->where('id', $id);}
                );
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
