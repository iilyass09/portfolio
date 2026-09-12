<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\CaseStudy;
use App\Models\Setting;

class HomeController extends Controller
{
    public function index()
    {
        $skills = \App\Models\Skill::orderBy('sort_order')->get();
        $projects = Project::orderBy('sort_order')->get();
        $activeProjects = $projects->filter(fn($p) => $p->is_active);
        return view('pages.home', compact('skills', 'projects', 'activeProjects'));
    }

    public function about()
    {
        $educations = \App\Models\Education::orderBy('sort_order')->get();
        $experiences = \App\Models\Experience::orderBy('sort_order')->get();
        $skills = \App\Models\Skill::orderBy('sort_order')->get();
        return view('pages.about', compact('educations', 'experiences', 'skills'));
    }

    public function caseStudy($slug)
    {
        $project = Project::where('slug', $slug)->firstOrFail();
        $caseStudy = $project->caseStudy;
        if (!$caseStudy) {
            abort(404);
        }
        $sections = $caseStudy->sections;
        return view('pages.casestudy', compact('project', 'caseStudy', 'sections'));
    }
}
