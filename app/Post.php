<?php

namespace App;

use Carbon\Carbon;
use GrahamCampbell\Markdown\Facades\Markdown;
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
        return is_null($this->published_at) ? '' : $this->published_at->diffForHumans();
    }

    public function getBodyHtmlAttribute(){
        return $this->body ? Markdown::convertToHtml(e($this->body)) : null;
    }

    public function getExcerptHtmlAttribute(){
        return $this->excerpt ? Markdown::convertToHtml(e($this->excerpt)) : null;
    }

    public function scopeLatestFirst($query){
        //can be used latest() built-in function
        return $query->orderBy('published_at', 'desc');
    }

    public function scopePublished($query)
    {
        return $query->where('published_at', '<=', Carbon::now());
    }
}
