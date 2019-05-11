<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function getImageUrlAttribute($value){

        $imageUrl = '';

        if(!is_null($this->image))
        {
            if(file_exists(public_path() . '/img/' . $this->image)){
                $imageUrl = asset('img/' . $this->image);
            }
        }

        return $imageUrl;
    }
}
