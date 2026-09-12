<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    protected $table = 'experiences';
    protected $fillable = ['title', 'company', 'location', 'job_type', 'period', 'description', 'sort_order'];

    public const JOB_TYPES = [
        'full_time' => 'Full-time',
        'part_time' => 'Part-time',
        'freelance' => 'Freelance',
        'internship' => 'Internship',
        'contract' => 'Kontrak',
    ];

    public $timestamps = false;
}
