<?php

namespace App\Http\Controllers\Admin\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Post\StoreRequest;
use App\Models\Post;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        try {


            $data = $request->validated();
            $tagIds = $data['tag_ids'];
            unset($data['tag_ids']);


            $data['preview_image'] = Storage::put('/images', $data['preview_image']);
            $data['main_image'] = Storage::put('/images', $data['main_image']);

            $post = Post::firstOrCreate($data);
            $post->tags()->attach($tagIds);
        } catch (\Exception $exception) {
            Log::error('Ошибка при создании поста: ' . $exception->getMessage());
            return redirect()->back()->withErrors(['error' => 'Ошибка при создании поста. Проверьте данные.']);
        }
        return redirect()->route('admin.post.index');
    }
}
