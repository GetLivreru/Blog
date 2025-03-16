<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;

class UpdateController extends Controller
{
    public function __invoke(Category $category)
    {
        return view('admin.categories.edit',compact('category'));
    }
}
