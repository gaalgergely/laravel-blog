<?php

namespace App;

use GrahamCampbell\Markdown\Facades\Markdown;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'author_name', 'author_email', 'author_url', 'body'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function getDateAttribute(){
        return $this->created_at->diffForHumans();
    }

    public function getBodyHtmlAttribute(){
        return Markdown::convertToHtml(e($this->body));
    }
}
