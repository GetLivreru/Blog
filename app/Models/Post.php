<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $table = 'posts';
    protected $guarded = false;

    public function tags(){
        return $this->belongsToMany(Tag::class,'post_tags','post_id','tag_id');
    }
}
