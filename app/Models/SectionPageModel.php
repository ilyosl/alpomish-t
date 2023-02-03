<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionPageModel extends Model
{
    use HasFactory;
    protected $table = 'section_page';

    protected $fillable = ['name','content','img_url','images'];
}
