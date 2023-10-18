<?php

namespace App\Livewire\Admin;

use App\Exports\ReportsExport;
use App\Models\Category;
use App\Models\Report;
use App\Models\Report_User;
use App\Models\Subcategory;
use App\Models\Subcategory_Report;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Models\Indicator;
use Livewire\Attributes\Rule;


class Dashboard extends Component
{
    use WithPagination;
    use LivewireAlert;

    protected $paginationTheme = 'bootstrap';
    public $paginate = 10;
    public $orderby = "created_at";
    public $asc = "DESC";
    public $checked = [];
    public $cari = ""; 
    public $selectPage= false;
    public $selectAll=false;
    public $selectedSubkategori = [];
    public $subkategori = [];
    public $kategori = [];
    public $mulai = "";
    public $iku = [];
    

    #[Rule('after_or_equal:mulai_', message: 'Tanggal Harus Sama Dengan Atau Lebih Dari Tanggal Mulai')]
    public $akhir = "";



    // public function mulai(){
    //     $validatedData = $this->validate([
    //         'mulai' => 'nullable'
    //     ]);
    // }

    // public function akhir(){
    //     $validatedData = $this->validate([
    //         'akhir' => 'after_or_equal:mulai_',
    //     ], [
    //         'after_or_equal' => 'Tanggal Harus Sama Dengan Atau Lebih Dari Tanggal Awal',
    //         ]);
    // }
    // public function resetdata(){
    //   return redirect()->route('userdashboard');
    // }
    
    public function updatedKategori(){
        
        $this->selectedSubkategori = Category::with('subcategories')->whereIn('id', $this->kategori)->get(); 
         
    }

    public function afterLivewireDomUpdate()
    {
        // Initialize Select2 after Livewire updates the DOM
        if (count($this->selectedSubkategori) > 0) {
            $this->dispatchBrowserEvent('initSelect2');
        }
    }

    public function render()
    {
        return view('livewire.admin.dashboard',[
            "datas" => $this->datas,
            
            "categories" => Category::select('id', 'nama')->get(),
            "indicators" => Indicator::where('status', 'aktif')->get()
        ]);
    }
    //jadi select all langsung
    public function updatedSelectPage($value){
        if ($value) {
            $this->checked = $this->datasQuery->pluck('id')->toArray();
        } else {
            $this->checked = [];
        }
        
    }

    public function updatedChecked(){
        $this->selectPage =false;
    }

    
    public function isChecked($data_id)
    {
        return in_array($data_id, $this->checked);
    }

    // public function selectAll(){
    //     $this->selectAll=true;
    //     $this->checked = $this->datasQuery->pluck('id')->toArray();
    // }

    // public function selectPart(){
    //     $this->selectAll=false;
    //     $this->checked = $this->datas->pluck('id')->toArray();
    // }

    public function getDatasProperty(){
        return $this->datasQuery->paginate($this->paginate);
    }

    public function getDatasQueryProperty(){
       return Report::with('user', 'category', 'indicator')
                        ->when($this->mulai, function($query){
                            $query->whereDate('when','>=',$this->mulai);
                        })
                        ->when($this->akhir, function($query){
                            $query->whereDate('when', '<=', $this->akhir);
                        })
                        ->when($this->mulai && $this->akhir, function($query){
                            $query->whereBetween('when', [$this->mulai, $this->akhir]);
                        })
                        ->when($this->kategori, function($query){
                                $query->whereHas('category', function($categoryId){
                                $categoryId->where('categories.id', $this->kategori);
                            });
                        })
                        ->when($this->iku, function($query){
                            $query->whereHas('indicator', function($ikuId){
                            $ikuId->where('indicators.id', $this->iku);
                            });
                        })
                      ->cari(trim($this->cari))
                      ->orderBy($this->orderby, $this->asc);
    }

    public function deleteDatas(){
        
        $reports = Report::whereKey($this->checked)->delete();
        $this->checked = [];
        $this->selectAll=false;
        $this->selectPage=false;
        
        $this->alert('success', 'Hapus Data Berhasil', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => false,
            'showConfirmButton' => true,
            'onConfirmed' => '',
            'confirmButtonText' => 'Ok',
            'timerProgressBar' => true,
           ]);
    }


    public function deleteSatuData($data_id){
        
        Report::where('id', $data_id)->delete();

        $this->checked = array_diff($this->checked, [$data_id]);
        
        $this->alert('success', 'Hapus Data Berhasil', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => false,
            'showConfirmButton' => true,
            'onConfirmed' => '',
            'confirmButtonText' => 'Ok',
            'timerProgressBar' => true,
           ]);
    }

    public function eksporexcel(){
        
        // return (new ReportsExport($this->checked))->download('laporan.xlsx');
        return Excel::download(new ReportsExport($this->checked), 'laporan.xlsx');
    }

    
}
