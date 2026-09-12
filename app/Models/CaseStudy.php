<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaseStudy extends Model
{
    protected $fillable = [
        'project_id', 'tagline', 'duration', 'role', 'tools', 'hero_bg',
        'layout', 'figma_prototype_url', 'figma_lofi_url',
        'background', 'problem', 'goal', 'footer_description',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function sections()
    {
        return $this->hasMany(CaseStudySection::class)->orderBy('sort_order');
    }
}
