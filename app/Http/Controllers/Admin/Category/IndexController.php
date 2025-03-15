<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function __invoke()
    {
        return view('admin.categories.index');
    }
}
