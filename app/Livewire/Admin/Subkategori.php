<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Livewire\Attributes\Rule;
use Livewire\Attributes\On;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Subkategori extends Component
{

    use WithPagination;
    use LivewireAlert;


    protected $paginationTheme = 'bootstrap';
    public $cari ="";
    public $checked = [];
    public $selectPage= false;
    public $selectAll=false;
    public $paginate = 10;
    public $orderby = "created_at";
    public $asc = "DESC";
    public $editedSubcategoryIndex = Null;
    public $setsubcategories = [];
    public $isFormVisible = false;
    // public $submit;
    public $selected = '';


    #[On('update_category')] 
    public function updatePostList($subcategory)
    {
        // ...
    }

    #[Rule('required', message: 'Nama Kelompok Kerja Wajib di Isi')]
    #[Rule('max:255', message: 'Jumlah karakter maksimal 255 (Termasuk Spasi)')]
    #[Rule('unique:subcategories,nama,except,id', message: 'Nama Sub Pokja Sudah Digunakan')]
    public $nama;

    // #[Rule('required', message: 'Nama Kelompok Kerja Wajib di Mengandung Huruf atau Angka')]
    public $slug;

    #[Rule('required', message: 'Kelompok Kerja Wajib di Pilih')]
    public $category_id;

    public function updatedChecked(){
        $this->selectPage =false;
    }

    public function showForm()
    {
        $this->reset();
        $this->isFormVisible = true;
    }

    public function hideForm()
    {
       $this->reset();
        $this->isFormVisible = false;
    }

    public function generateSlug()
    {
        $this->slug = SlugService::createSlug(Subcategory::class, 'slug', $this->nama);
    }
    

    public function submit()
    {
        
       $this->validate();
 
       $subcategory = Subcategory::create([
            'nama' => $this->nama,
            'slug'  => $this->slug,
            'category_id' => $this->category_id
        ]);

        $this->alert('success', 'Tambah Pokja berhasil', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => false,
            'showConfirmButton' => true,
            'onConfirmed' => '',
            'confirmButtonText' => 'Ok',
            'timerProgressBar' => true,
           ]);
        
   
        $this->dispatch('updateSubcategory', $subcategory)->self();
    }

    
    public function isChecked($subcategory_id)
    {
        return in_array($subcategory_id, $this->checked);
    }

    public function deleteDatas(){
        
        $subcategories = Subcategory::whereKey($this->checked)->delete();
        $this->checked = [];
        $this->selectAll=false;
        $this->selectPage=false;
        
        $this->alert('success', 'Hapus Sub Pokja berhasil', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => false,
            'showConfirmButton' => true,
            'onConfirmed' => '',
            'confirmButtonText' => 'Ok',
            'timerProgressBar' => true,
           ]);
    }


    public function deleteSatuData($subcategory_id){
        
        Subcategory::where('id', $subcategory_id)->delete();

        $this->checked = array_diff($this->checked, [$subcategory_id]);
        
        $this->alert('success', 'Hapus Sub Pokja berhasil', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => false,
            'showConfirmButton' => true,
            'onConfirmed' => '',
            'confirmButtonText' => 'Ok',
            'timerProgressBar' => true,
           ]);
    }

    public function render() : View
    {
        $this->setsubcategories = Subcategory::all()->toArray();

        return view('livewire.admin.subkategori', [
        "subcategories" => $this->subcategories,
        "categories" => Category::all(),
        "setsubcategories" => $this->setsubcategories
        ]);
    }


    public function selectAllData(){
        $this->selectAll=true;
        $this->checked = $this->subcategoriesQuery->pluck('id')->toArray();
    }

    public function selectPart(){
        $this->selectAll=false;
        $this->checked = $this->subcategories->pluck('id')->toArray();
    }

    public function updatedSelectPage($value){
        if ($value) {
            $this->checked = $this->subcategories->pluck('id')->toArray();
        } else {
            $this->checked = [];
        }
        
    }

    public function getSubcategoriesProperty(){
        return $this->subcategoriesQuery->paginate($this->paginate);
    }

    public function getSubcategoriesQueryProperty(){
       return Subcategory::with('categories')
                ->cari(trim($this->cari))
                ->orderBy($this->orderby, $this->asc);
    }


    public function editSubcategory($subcategoryIndex){
        $this->editedSubcategoryIndex = $subcategoryIndex;
    }


    public function saveSubcategory($subcategoryIndex){
        $subcategory = $this->setsubcategories[$subcategoryIndex] ?? NULL;
      
        if (!is_null($subcategory)) {
            $editedSubcategory = Subcategory::where('id', $this->editedSubcategoryIndex);
            if ($editedSubcategory) {
                $editedSubcategory->update($subcategory);
            }

        }

        $this->alert('success', 'Edit Sub Pokja berhasil', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => false,
            'showConfirmButton' => true,
            'onConfirmed' => '',
            'confirmButtonText' => 'Ok',
            'timerProgressBar' => true,
           ]);

        $this->editedSubcategoryIndex = null;
    }

}
