<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['title', 'subtitle', 'description', 'thumbnail', 'slug', 'type', 'is_active', 'sort_order'];

    public function caseStudy()
    {
        return $this->hasOne(CaseStudy::class);
    }
}
