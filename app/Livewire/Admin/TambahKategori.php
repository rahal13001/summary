<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use Livewire\Component;
use Livewire\Attributes\Rule;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class TambahKategori extends Component
{
    public $slug, $submit;

    #[Rule('required', message: 'Nama Kelompok Kerja Wajib di Isi')]
    #[Rule('max:255', message: 'Jumlah karakter maksimal 255 (Termasuk Spasi)')]
    #[Rule('unique:categories,nama,except,id', message: 'Nama Pokja Sudah Digunakan')]
    public $nama;

    public function generateSlug()
    {
        $this->slug = SlugService::createSlug(Category::class, 'slug', $this->nama);
    }
    


    public function submit()
    {
        // $validatedData = $this->validate([
        //     'nama' => 'required|max:255|unique:categories,nama,except,id',
        // ], [
        //     'required' => 'Harap Jawab Pertanyaan Ini',
        //     'max' => 'Jumlah Karakter Maksimal Adalah 255 Karaker (Termasuk Spasi)',   
        //     'unique' => 'Kategori Telah Tersedia'   
        //     ]);`

        $this->validate();
 
        Category::create([
            'nama' => $this->nama,
            'slug'  => $this->slug
        ]);

        $this->dispatch('swal:modal', [
            'icon' => 'success',
            'title' => 'Berhasil',
            'text' => 'Terimakasih Telah Menambahkan Kategori',
            'timer' => 5000,
            'timerProgressBar' => true,
        ]);

        $this->clearForm();
        $this->dispatch('updatecategory')->to(Kategori::class);
    }

    public function clearForm()
    {
        $this->nama = "";
    }

    public function render()
    {
        return view('livewire.admin.tambah-kategori');
    }


}
