<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;

class DeleteController extends Controller
{
    public function __invoke(User $user)
    {
        $user->delete();
        return redirect()->route('admin.user.index');
    }
}
