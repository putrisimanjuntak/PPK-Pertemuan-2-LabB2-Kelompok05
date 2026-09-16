<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /** Pastikan hanya pemilik project yang boleh mengakses/mengubahnya. */
    private function own(Project $p)
    {
        abort_unless($p->user_id === auth()->id(), 403);
    }

    public function index()
    {
        // SRS-009: withCount('tasks') dipakai di kartu daftar project agar
        // total tugas per project bisa dibandingkan dengan tugas selesai
        // (lihat resources/views/projects/index.blade.php untuk progres tiap project).
        $projects = Project::withCount('tasks')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('projects.index', ['projects' => $projects]);
    }

    public function create()
    {
        return view('projects.create', ['project' => new Project]);
    }

    public function store(Request $r)
    {
        $d = $r->validate([
            'name' => 'required|max:150',
            'description' => 'nullable',
        ]);
        $d['user_id'] = auth()->id();
        Project::create($d);

        return redirect()->route('projects.index')->with('success', 'Project dibuat.');
    }

    public function show(Project $project)
    {
        $this->own($project);
        $project->load('tasks');

        // SRS-009: data progres (jumlah selesai/belum selesai & persentase)
        // dihitung dari method di App\Models\Project dan dikirim ke view
        // projects/show.blade.php agar anggota yang terlibat dapat melihatnya.
        return view('projects.show', [
            'project' => $project,
            'tasksTotal' => $project->tasksTotalCount(),
            'tasksDone' => $project->tasksDoneCount(),
            'tasksRemaining' => $project->tasksRemainingCount(),
            'progressPercentage' => $project->progressPercentage(),
        ]);
    }

    public function edit(Project $project)
    {
        $this->own($project);

        return view('projects.create', compact('project'));
    }

    public function update(Request $r, Project $project)
    {
        $this->own($project);
        $project->update($r->validate([
            'name' => 'required|max:150',
            'description' => 'nullable',
        ]));

        return redirect()->route('projects.show', $project)->with('success', 'Project diperbarui.');
    }

    public function destroy(Project $project)
    {
        $this->own($project);
        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Project dihapus.');
    }
}
