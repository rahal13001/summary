<?php

namespace App\Livewire\User\Chart;

use Livewire\Component;
use App\Models\Indicator;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Illuminate\Support\Facades\Auth;

class Userchartiku extends Component
{
    public function getIndicatorsQueryProperty(){
        
      
          return  Indicator::where('status', 'aktif')
            ->withCount(['report' => function ($query) {
                $query->where('user_id', Auth::user()->id);
            }])->orderBy('nomor');
       
    }

    public function getIndicatorsProperty(){
        return $this->IndicatorsQuery->get();
    }


    public function render()
    {
        $colors = [
            '#1abc9c', // Turquoise
            '#2ecc71', // Emerald
            '#3498db', // Peter River
            '#9b59b6', // Amethyst
            '#34495e', // Wet Asphalt
            '#16a085', // Green Sea
            '#27ae60', // Nephritis
            '#2980b9', // Belize Hole
            '#8e44ad', // Wisteria
            '#2c3e50', // Midnight Blue
            '#f1c40f', // Sunflower
            '#e67e22', // Carrot
            '#e74c3c', // Alizarin
            '#ecf0f1', // Clouds
            '#95a5a6', // Concrete
            '#f39c12', // Orange
            '#d35400', // Pumpkin
            '#c0392b'  // Pomegranate
        ];
        
        $userIkuChart = (new ColumnChartModel())
                            ->setTitle('Jumlah');
                            // ->withOnColumnClickEventName('onColumnClick');
                    
        foreach ($this->indicators as $indexiku => $indicator) {
            $color = $colors[$indexiku % count($colors)]; // untuk setup warna
            $userIkuChart->addColumn($indicator->nomor, $indicator->report_count, $color);
        }
        return view('livewire.user.chart.userchartiku', compact('userIkuChart'));
    }
}
