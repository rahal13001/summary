<?php

namespace App\Livewire\Iku;

use Livewire\Component;

class Formtambahdata extends Component
{

    public $isFormVisible = false;

    public function showForm()
    {
        $this->isFormVisible = true;
    }

    public function hideForm()
    {
        $this->isFormVisible = false;
    }

    public function render()
    {
        if ($this->isFormVisible) {
        return view('livewire.iku.formtambahdata');
        }
        else {
            return null;
        }
    }
}
