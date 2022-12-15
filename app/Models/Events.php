<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
class Events extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'title','desc','slug','age_limit',
        'image','cover','meta_title','meta_keywords',
        'meta_desc','status'
    ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function eventDate(){
        return $this->hasMany(EventTime::class, 'event_id');
    }

}
