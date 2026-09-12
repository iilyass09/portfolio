<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaseStudySection extends Model
{
    protected $fillable = ['case_study_id', 'type', 'content', 'sort_order'];

    protected $casts = [
        'content' => 'array',
    ];

    public function caseStudy()
    {
        return $this->belongsTo(CaseStudy::class);
    }
}
