<?php

namespace App;

use Carbon\Carbon;
use GrahamCampbell\Markdown\Facades\Markdown;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;

class Post extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title', 'slug', 'excerpt', 'body', 'image', 'published_at', 'category_id'
    ];

    protected $dates = ['published_at'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    public function author()
    {
        return $this->belongsTo(User::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function setPublishedAtAttribute($value){
        $this->attributes['published_at'] = $value ?: null;
    }

    public function setImageAttribute($value){
        if($value instanceof UploadedFile){
            /**
             * @todo handle image when editing post
             */
            //$value->storePubliclyAs('img', $value->getClientOriginalName());
            $success = $value->move(config('cms.image.directory'), $value->getClientOriginalName());
            if($success){
                Image::make(config('cms.image.directory').'/'.$value->getClientOriginalName())
                    ->resize(config('cms.image.thumbnail.width'), config('cms.image.thumbnail.height'))
                    ->save(config('cms.image.directory') . '/' .str_replace(".{$value->getClientOriginalExtension()}", "_thumb.{$value->getClientOriginalExtension()}", $value->getClientOriginalName()));
            }
            $this->attributes['image'] = $value->getClientOriginalName();
        }
    }

    public function getImageUrlAttribute(){

        $imageUrl = '';

        if(!is_null($this->image))
        {
            if(file_exists(public_path() . '/' .config('cms.image.directory') . '/' . $this->image)){
                $imageUrl = asset(config('cms.image.directory') . '/' . $this->image);
            }
        }

        return $imageUrl;
    }

    public function getImageThumbUrlAttribute(){

        $imageUrl = '';

        if(!is_null($this->image))
        {
            $ext = substr(strrchr($this->image, '.'), 1);
            $thumbnail = str_replace(".{$ext}", '_thumb.jpg', $this->image);
            if(file_exists(public_path() . '/' .config('cms.image.directory'). '/' . $thumbnail)){
                $imageUrl = asset(config('cms.image.directory') . '/' . $thumbnail);
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

    public function dateFormatted($showTimes = false){
        $format = 'd/m/Y';
        if($showTimes) $format .= ' H:i:s';
        return $this->created_at->format($format);
    }

    public function publicationLabel()
    {
        if(!$this->published_at) return '<span class="label label-warning">Draft</span>';
        elseif($this->published_at && $this->published_at->isFuture()) return '<span class="label label-info">Scheduled</span>';
        else return '<span class="label label-success">Published</span>';
    }

    public function scopeLatestFirst($query){
        //can be used latest() built-in function
        return $query->orderBy('published_at', 'desc');
    }

    public function scopePopular($query)
    {
        return $query->orderBy('view_count', 'desc');
    }

    public function scopePublished($query)
    {
        return $query->where('published_at', '<=', Carbon::now());
    }
}
