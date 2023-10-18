<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Indicator;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function Subcategory(){

        $categories = Category::get();

        return view('admin.subkategori', compact('categories'));
    }

    public function Categorydasboard(Category $category){
        return view('admin.dashboardkategori', compact('category'));
    }

    public function IKUdasboard(Indicator $indicator){
        return view('admin.iku.dashboardperiku', compact('indicator'));
    }
}
