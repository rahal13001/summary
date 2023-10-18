<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On; 
use Livewire\Attributes\Rule;
use \Cviebrock\EloquentSluggable\Services\SlugService;


class Kategori extends Component
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
    public $editedcategoryIndex = Null;
    public $setcategories = [];
    public $isFormVisible = false;

    public $slug, $submit;

    #[On('update_category')] 
    public function updatePostList($category)
    {
        // ...
    }

    #[Rule('required', message: 'Nama Kelompok Kerja Wajib di Isi')]
    #[Rule('max:255', message: 'Jumlah karakter maksimal 255 (Termasuk Spasi)')]
    #[Rule('unique:categories,nama,except,id', message: 'Nama Pokja Sudah Digunakan')]
    public $nama;

    #[Rule('required', message: 'Status Wajib di Isi')]
    public $status;

    #[Rule('required', message: 'Status Wajib di Isi')]
    #[Rule('numeric', message: 'Nomor Harus Berisi Angka')]
    public $nomor;

    public function generateSlug()
    {
        $this->slug = SlugService::createSlug(Category::class, 'slug', $this->nama);
    }

    public function showForm()
    {
        $this->reset();
        $this->isFormVisible = true;
    }

    public function hideForm()
    {
        $this->nama = '';
        $this->status = '';
        $this->nomor = '';
        $this->isFormVisible = false;
    }

    public function saveData()
    {
        $this->validate();
 
       $category = new Category;
            $category->nama = $this->nama;
            $category->status = $this->status;
            $category->nomor = $this->nomor;
            $category->slug = $this->slug;
            $category->save();
    
      

        $this->alert('success', 'Tambah Pokja berhasil', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => false,
            'showConfirmButton' => true,
            'onConfirmed' => '',
            'confirmButtonText' => 'Ok',
            'timerProgressBar' => true,
           ]);

        $this->nama = '';
        $this->status = '';
        $this->nomor = '';
        $this->dispatch('update_category', $category->id)->self();
    }


      
    public function updatedChecked(){
        $this->selectPage =false;
    }

    
    public function isChecked($category_id)
    {
        return in_array($category_id, $this->checked);
    }

    public function deleteDatas(){
        
        $categories = Category::whereKey($this->checked)->delete();
        $this->checked = [];
        $this->selectAll=false;
        $this->selectPage=false;
        
        $this->editedcategoryIndex = Null;
        $this->alert('success', 'Pokja Berhasil Di Hapus', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => false,
            'showConfirmButton' => true,
            'onConfirmed' => '',
            'confirmButtonText' => 'Ok',
            'timerProgressBar' => true,
           ]);
    }


    public function deleteSatuData($category_id){
        
        Category::where('id', $category_id)->delete();

        $this->checked = array_diff($this->checked, [$category_id]);
        
        $this->editedcategoryIndex = Null;
        $this->alert('success', 'Pokja Berhasil Di Hapus', [
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
        $this->setcategories = Category::all()->toArray();

        return view('livewire.admin.kategori', [
        "categories" => $this->categories,
        "setcategories" => $this->setcategories
        ]);
    }


    public function selectAllData(){
        $this->selectAll=true;
        $this->checked = $this->categoriesQuery->pluck('id')->toArray();
    }

    public function selectPart(){
        $this->selectAll=false;
        $this->checked = $this->categories->pluck('id')->toArray();
    }

    public function updatedSelectPage($value){
        if ($value) {
            $this->checked = $this->categories->pluck('id')->toArray();
        } else {
            $this->checked = [];
        }
        
    }

    public function getcategoriesProperty(){
        return $this->categoriesQuery->paginate($this->paginate);
    }

    public function getcategoriesQueryProperty(){
       return Category::cari(trim($this->cari))
                ->orderBy($this->orderby, $this->asc);
    }


    public function editcategory($categoryIndex){
        $this->editedcategoryIndex = $categoryIndex;
    }


    public function savecategory($categoryIndex){
            
        $category = $this->setcategories[$categoryIndex] ?? NULL;
   
      
        if (!is_null($category)) {
            $editedcategory = Category::where('id', $this->editedcategoryIndex);
            if ($editedcategory) {
                $editedcategory->update($category);
            }

            $this->alert('success', 'Pokja Berhasil Di Edit', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => false,
                'showConfirmButton' => true,
                'onConfirmed' => '',
                'confirmButtonText' => 'Ok',
                'timerProgressBar' => true,
               ]);

        }
        
        $this->editedcategoryIndex = Null;
       
    }


  

}
