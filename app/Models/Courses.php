<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Courses extends Model
{
    //
    protected $table = "courses";

    protected $fillable = ['avatar', 'title', 'category_id', 'description', 'materials', 'status', 'price', 'vacancies', 'updated_by', 'date_ini', 'date_end'];
}
