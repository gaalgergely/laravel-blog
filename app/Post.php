<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function author()
    {
        return $this->belongsTo(User::class);
    }

    public function getImageUrlAttribute(){

        $imageUrl = '';

        if(!is_null($this->image))
        {
            if(file_exists(public_path() . '/img/' . $this->image)){
                $imageUrl = asset('img/' . $this->image);
            }
        }

        return $imageUrl;
    }

    public function getDateAttribute(){
        return $this->created_at->diffForHumans();
    }

    public function scopeLatestFirst(){
        //can be used latest() function
        return $this->orderBy('created_at', 'desc');
    }
}
