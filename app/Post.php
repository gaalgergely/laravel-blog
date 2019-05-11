<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $dates = ['published_at'];

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

    public function scopeLatestFirst($query){
        //can be used latest() function
        return $query->orderBy('published_at', 'desc');
    }

    public function scopePublished($query)
    {
        return $query->where('published_at', '<=', Carbon::now());
    }
}
