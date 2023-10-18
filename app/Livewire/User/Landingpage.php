<?php

namespace App\Livewire\User;

use App\Models\Category;
use App\Models\Indicator;
use App\Models\Indicator_Report;
use App\Models\Report;
use Livewire\Component;
use Asantibanez\LivewireCharts\Facades\LivewireCharts;
use Asantibanez\LivewireCharts\Models\RadarChartModel;
use Asantibanez\LivewireCharts\Models\TreeMapChartModel;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class Landingpage extends Component
{
    public $pokja, $ketentuanpokja;
    public $iku;
    public $waktuiku = 1;
    public $waktupokja = 1;
    public $ikuUser;
    public $firstRun = true;
    public $showDataLabels = false;
    public $categoryUser;
    public $summary_ku, $summary_tahun_ini, $summary_bulan_ini;
 

    // #[On('onColumnClick')]

    // public function handleOnColumnClick($column)
    // {
    //     dd('huasu');
    // }

    public function mount(){
        $this->summary_ku = Report::where('user_id', Auth::user()->id)->count();
        $this->summary_tahun_ini = Report::where('user_id', Auth::user()->id)->whereYear('when', date('Y'))->count();
        $this->summary_bulan_ini = Report::where('user_id', Auth::user()->id)->whereYear('when', date('m'))->whereMonth('when', date('m'))->count();
    }

    public function updatedIkuUser($value){
        $this->ikuUser = filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }

    public function updtatedWaktuiku($value){
        $this->waktuiku = $value;
    }

    public function updatedCategoryUser($value){
        $this->categoryUser = filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }

    public function updtatedWaktupokja($value){
        $this->waktupokja = $value;
    }

    public function getIndicatorsQueryProperty(){
        
        if ($this->ikuUser == true) {
          return  Indicator::where('status', 'aktif')
            ->withCount(['report' => function ($query) {
                $query->where('user_id', Auth::user()->id)
                ->when($this->waktuiku == '1', function ($waktu){  
                    $waktu->whereYear('when', date('Y'));
                })
                ->when($this->waktuiku == '2', function ($data){
                    $data->whereMonth('when', date('m'));
                })
                ->when($this->waktuiku == '3', function ($data){
                    $data->whereBetween('when', [now()->startOfWeek(), now()->endOfWeek()]);
                })
                ->when($this->waktuiku == '4', function ($data){
                    $data->whereDate('when', Carbon::today());
                });
            }])
            
            ->orderBy('nomor');

        } else {
            return  Indicator::where('status', 'aktif')
            -> withCount(['report' => function ($query) {
                $query->when($this->waktuiku == '1', function ($waktu){  
                        $waktu->whereYear('when', date('Y'));
                });
                $query->when($this->waktuiku == '2', function ($data){
                        $data->whereMonth('when', date('m'));
                });
                $query->when($this->waktuiku == '3', function ($data){
                        $data->whereBetween('when', [now()->startOfWeek(), now()->endOfWeek()]);
                });
                $query->when($this->waktuiku == '4', function ($data){
                        $data->whereDate('when', Carbon::today());
                });
            }])
            
            ->orderBy('nomor');
        }    
    }

    public function getIndicatorsProperty(){
        return $this->IndicatorsQuery->get();
    }

    public function getCategoriesQueryProperty(){
        if ($this->categoryUser == true) {
            return  Category::where('status', 'aktif')
              ->withCount(['reports' => function ($query) {
                  $query->where('user_id', Auth::user()->id)
                  ->when($this->waktupokja == '1', function ($waktu){  
                      $waktu->whereYear('when', date('Y'));
                  })
                  ->when($this->waktupokja == '2', function ($data){
                      $data->whereMonth('when', date('m'));
                  })
                  ->when($this->waktupokja == '3', function ($data){
                      $data->whereBetween('when', [now()->startOfWeek(), now()->endOfWeek()]);
                  })
                  ->when($this->waktupokja == '4', function ($data){
                      $data->whereDate('when', Carbon::today());
                  });
              }])
              
              ->orderBy('nomor');
  
          } else {
              return  Category::where('status', 'aktif')
              -> withCount(['reports' => function ($query) {
                  $query->when($this->waktupokja == '1', function ($waktu){  
                          $waktu->whereYear('when', date('Y'));
                  });
                  $query->when($this->waktupokja == '2', function ($data){
                          $data->whereMonth('when', date('m'));
                  });
                  $query->when($this->waktupokja == '3', function ($data){
                          $data->whereBetween('when', [now()->startOfWeek(), now()->endOfWeek()]);
                  });
                  $query->when($this->waktupokja == '4', function ($data){
                          $data->whereDate('when', Carbon::today());
                  });
              }])
              
              ->orderBy('nomor');
          }    
    }

    public function getCategoriesProperty(){
        return $this->CategoriesQuery->get();
    }

    public function getYearlyLeaderBoardsQueryProperty(){
        return Report::selectRaw('user_id, count(*) as report_count')
            ->with('user')
            ->whereYear('when', date('Y'))
            ->groupBy('user_id')
            ->orderBy('report_count', 'desc')
            ->limit(5);
    }

    public function getYearlyLeaderBoardsProperty(){
        return $this->yearlyLeaderBoardsQuery->get();
    }

    public function getMonthlyLeaderBoardsQueryProperty(){
        return Report::selectRaw('user_id, count(*) as report_count')
            ->with('user')
            ->whereYear('when', date('Y'))
            ->whereMonth('when', date('m'))
            ->groupBy('user_id')
            ->orderBy('report_count', 'desc')
            ->limit(5);
    }

    public function getMonthlyLeaderBoardsProperty(){
        return $this->monthlyLeaderBoardsQuery->get();
    }

    public function render()
    {   
        $yearlyLeaderBoards = $this->yearlyLeaderBoards;
        $monthlyLeaderBoards = $this->monthlyLeaderBoards;
       
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
                    '#c0392b',  // Pomegranate
                    '#D2691E', // Chocolate
                    '#FF7F50', // Coral
                    '#6495ED', // CornflowerBlue
                    '#DC143C', // Crimson
                    '#00FFFF', // Cyan
                    '#00008B', // DarkBlue
                    '#008B8B', // DarkCyan
                    '#B8860B', // DarkGoldenRod
                    '#A9A9A9', // DarkGray
                    '#006400'  // DarkGreen
                ];
                
        $columnChartModel = (new ColumnChartModel())
                            ->setTitle('Jumlah');
                            // ->withOnColumnClickEventName('onColumnClick');
                       
                            foreach ($this->indicators as $indexiku => $indicator) {
                                $color = $colors[$indexiku % count($colors)]; // untuk setup warna
                                $columnChartModel->addColumn($indicator->nomor, (int) $indicator->report_count, $color); // cast report_count to int
                            }
                            

        $pokjacolumnChartModel = (new ColumnChartModel())
                            ->setTitle('Jumlah');
                            // ->withOnColumnClickEventName('onColumnClick');
                       
                            foreach ($this->categories as $indexpokja => $category) {
                                $color = $colors[$indexpokja % count($colors)]; // untuk setup warna
                                $pokjacolumnChartModel->addColumn($category->nomor, (int) $category->reports_count, $color); // cast report_count to int
                            }
                            
        
        return view('livewire.user.landingpage', compact('columnChartModel', 'pokjacolumnChartModel', 'yearlyLeaderBoards', 'monthlyLeaderBoards'));
    }
}
