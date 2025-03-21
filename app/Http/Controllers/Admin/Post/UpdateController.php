<?php

namespace App\Http\Controllers\Admin\Post;

use App\Http\Requests\Admin\Post\UpdateRequest;
use App\Models\Post;
use App\Service\PostService;
class UpdateController extends BaseController
{
    public function __invoke(UpdateRequest $request , Post $post)
    {
        $data = $request->validated();
        $post = $this->service->update($data,$post);

        return view('admin.post.show',compact('post'));
    }
}
