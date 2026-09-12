<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    public function index()
    {
        $experiences = Experience::orderBy('sort_order')->get();

        $items = $experiences->map(fn ($e) => [
            'id' => $e->id,
            'title' => $e->title,
            'company' => $e->company,
            'location' => $e->location,
            'job_type' => $e->job_type,
            'period' => $e->period,
            'description' => (string) $e->description,
            'editUrl' => route('admin.experiences.edit', $e->id),
            'deleteUrl' => route('admin.experiences.destroy', $e->id),
        ])->values();

        return view('admin.experiences.index', compact('experiences', 'items'));
    }

    public function reorder(Request $request)
    {
        $validated = $request->validate([
            'order' => 'required|array',
            'order.*' => 'integer|distinct',
        ]);

        foreach ($validated['order'] as $index => $id) {
            Experience::whereKey($id)->update(['sort_order' => $index + 1]);
        }

        return response()->json(['status' => 'ok']);
    }

    public function create()
    {
        return view('admin.experiences.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'job_type' => 'nullable|string|in:' . implode(',', array_keys(Experience::JOB_TYPES)),
            'period' => 'required|string|max:50',
            'description' => 'required|string',
            'sort_order' => 'required|integer',
        ]);

        Experience::create($validated);
        return redirect()->route('admin.experiences.index')->with('success', 'Pengalaman berhasil ditambahkan.');
    }

    public function edit(Experience $experience)
    {
        return view('admin.experiences.edit', compact('experience'));
    }

    public function update(Request $request, Experience $experience)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'job_type' => 'nullable|string|in:' . implode(',', array_keys(Experience::JOB_TYPES)),
            'period' => 'required|string|max:50',
            'description' => 'required|string',
            'sort_order' => 'required|integer',
        ]);

        $experience->update($validated);
        return redirect()->route('admin.experiences.index')->with('success', 'Pengalaman berhasil diupdate.');
    }

    public function destroy(Experience $experience)
    {
        $experience->delete();
        return redirect()->route('admin.experiences.index')->with('success', 'Pengalaman berhasil dihapus.');
    }
}
