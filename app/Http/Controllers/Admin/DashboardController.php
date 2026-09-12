<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Skill;
use App\Models\Education;
use App\Models\Experience;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'projects' => Project::count(),
            'skills' => Skill::count(),
            'educations' => Education::count(),
            'experiences' => Experience::count(),
        ];
        return view('admin.dashboard', compact('stats'));
    }
}
