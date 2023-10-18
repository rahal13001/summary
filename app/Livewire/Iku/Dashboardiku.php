<?php

namespace App\Livewire\Iku;

use Livewire\Component;
use App\Models\Report;
use App\Models\Category;
use App\Models\Indicator;
use Livewire\Attributes\Rule;
use Livewire\Attributes\On;
use Jantinnerezo\LivewireAlert\LivewireAlert;

// create pagination
use Livewire\WithPagination;

class Dashboardiku extends Component
{
    use WithPagination;
    use LivewireAlert;

    protected $paginationTheme = 'bootstrap';



    protected $listeners = ['sendnotifTambah' => 'notif'];

    public $paginate = 10;
    public $orderby = "created_at";
    public $asc = "DESC";
    public $checked = [];
    public $cari = "";
    public $mulai = "2000";
    public $akhir = "3000";
    public $selectPage= false;
    public $selectAll=false;
    public $nama = "";
    public $nomor = "";
    public $tahun = "";
    public $status = "";
    public $tambahiku, $slug, $newData, $id_iku;
    public $isFormVisible = false;
    public $editForm = false;


    #[Rule('required', message: 'Nama IKU Wajib di Isi')]

    // #[Rule('regex:/^[a-zA-Z0-9]+$/', message: 'Nama IKU harus mengandung huruf atau angka')]
    
   
    public $nama_iku = '';

    #[Rule('required', message: 'Nomor IKU Wajib di Isi')]
    public $nomor_iku = '';

    #[Rule('required', message: 'Tahun IKU Wajib di Isi')]
    public $tahun_iku = '';

    #[Rule('required', message: 'Status IKU Wajib di Isi')]
    public $status_iku = '';

    #[On('iku_saved')]
    public function updatePostList($indicator)
    {
        // ...
    }


    public function mulai(){
        $validatedData = $this->validate([
            'mulai' => 'nullable'
        ]);
    }

    public function showForm()
    {
        $this->reset();
        $this->isFormVisible = true;
    }

    public function hideForm()
    {
        $this->nama_iku = '';
        $this->nomor_iku = '';
        $this->tahun_iku = '';
        $this->status_iku = '';
        $this->isFormVisible = false;
        $this->editForm = false;
    }

    public function saveData(){
        $this->validate();
        $indicator = new Indicator();
        $indicator->nama = $this->nama_iku;
        $indicator->nomor = $this->nomor_iku;
        $indicator->tahun = $this->tahun_iku;
        $indicator->status = $this->status_iku;
        $indicator->save();
    
        $this->alert('success', 'Tambah IKU berhasil', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => false,
            'showConfirmButton' => true,
            'onConfirmed' => '',
            'confirmButtonText' => 'Ok',
            'timerProgressBar' => true,
           ]);

        $this->reset();

        $this->dispatch('iku_saved', $indicator->id)->self();
    
    }

    public function akhir(){
        $validatedData = $this->validate([
            'akhir' => 'after_or_equal:mulai_',
        ], [
            'after_or_equal' => 'Tanggal Harus Sama Dengan Atau Lebih Dari Tanggal Awal',
            ]);
    }

    
    public function render()
    {
        $opsitahuniku = Indicator::groupBy('tahun')->orderBy('tahun', 'DESC')->get('tahun');
              
         return view('livewire.iku.dashboardiku',[
            "datas" => $this->datas,
            "opsitahuniku" => $opsitahuniku
        ]);
    }

 

    public function updatedSelectPage($value){
        if ($value) {
            $this->checked = $this->datas->pluck('id')->toArray();
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

    public function selectAllData(){
        $this->selectAll=true;
        $this->checked = $this->datasQuery->pluck('id')->toArray();
    }

    public function selectPart(){
        $this->selectAll=false;
        $this->checked = $this->datas->pluck('id')->toArray();
    }

    public function getDatasProperty(){
        return $this->datasQuery->paginate($this->paginate);
    }

    public function getDatasQueryProperty(){
       return Indicator::when($this->mulai && $this->akhir, function($query){
                            $query->whereBetween('tahun', [trim($this->mulai), trim($this->akhir)]);})
                        ->when($this->status, function($query){
                            $query->where('status', $this->status);
                        })
                        ->cari(trim($this->cari))
                        ->orderBy($this->orderby, $this->asc);
    }

    public function edit($edit){
       
        $inginEdit = Indicator::whereKey($edit)->first();
        
        $this->nama_iku = $inginEdit->nama;
        $this->nomor_iku = $inginEdit->nomor;
        $this->tahun_iku = $inginEdit->tahun;
        $this->status_iku = $inginEdit->status;
        $this->id_iku = $inginEdit->id;
        $this->isFormVisible = true;
        $this->editForm = true;
    }

    public function perbarui($perbarui){
        Indicator::where('id',$perbarui)->update([
            'nama' => $this->nama_iku,
            'nomor' => $this->nomor_iku,
            'tahun' => $this->tahun_iku,
            'status' => $this->status_iku,
        ]);

        $this->alert('success', 'Edit IKU berhasil', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => false,
            'showConfirmButton' => true,
            'onConfirmed' => '',
            'confirmButtonText' => 'Ok',
            'timerProgressBar' => true,
           ]);

        $this->isFormVisible = false;
        $this->editForm = false;
    }

    public function deleteDatas(){
        
        $reports = Indicator::whereKey($this->checked)->delete();
        $this->checked = [];
        $this->selectAll=false;
        $this->selectPage=false;
        
        $this->alert('success', 'Hapus IKU berhasil', [
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
        
        Indicator::where('id', $data_id)->delete();

        $this->checked = array_diff($this->checked, [$data_id]);
        
        $this->alert('success', 'Hapus IKU berhasil', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => false,
            'showConfirmButton' => true,
            'onConfirmed' => '',
            'confirmButtonText' => 'Ok',
            'timerProgressBar' => true,
           ]);
    }   
  
}
