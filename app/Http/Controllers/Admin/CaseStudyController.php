<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\CaseStudy;
use App\Models\CaseStudySection;
use Illuminate\Http\Request;

class CaseStudyController extends Controller
{
    public function index()
    {
        $caseStudies = CaseStudy::with('project')->get();
        return view('admin.casestudies.index', compact('caseStudies'));
    }

    public function edit(CaseStudy $caseStudy)
    {
        $caseStudy->load(['sections', 'project']);
        return view('admin.casestudies.edit', compact('caseStudy'));
    }

    public function update(Request $request, CaseStudy $caseStudy)
    {
        $validated = $request->validate([
            'tagline' => 'required|string|max:255',
            'duration' => 'required|string|max:50',
            'role' => 'required|string|max:255',
            'tools' => 'required|string|max:255',
            'figma_prototype_url' => 'nullable|string',
            'figma_lofi_url' => 'nullable|string',
            'background' => 'nullable|string',
            'problem' => 'nullable|string',
            'goal' => 'nullable|string',
            'footer_description' => 'nullable|string',
        ]);

        $caseStudy->update($validated);

        if ($request->has('sections')) {
            foreach ($request->input('sections', []) as $sectionData) {
                if (isset($sectionData['id'])) {
                    $section = CaseStudySection::find($sectionData['id']);
                    if ($section) {
                        $content = $sectionData['content'] ?? [];
                        if (is_string($content)) {
                            $decoded = json_decode($content, true);
                            $content = is_array($decoded) ? $decoded : [];
                        }
                        $section->update(['content' => $content]);
                    }
                }
            }
        }

        return redirect()->route('admin.casestudies.edit', $caseStudy)->with('success', 'Case study berhasil diupdate.');
    }
}
