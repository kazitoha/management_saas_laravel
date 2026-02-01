<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Clients;
use App\Models\Files;
use App\Models\Projects;
use App\Models\ProjectTeams;
use App\Models\Tasks;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ProjectController extends Controller
{
    public function index()
    {
        try {
            $projects = Projects::paginate(30)->load('tasks');

            return view('admin.project.index', compact('projects'));
        } catch (\Exception $e) {
            return back()->with('error', 'Could not load projects.');
        }
    }

    public function create()
    {
        try {
            $clients = Clients::orderBy('name')->get(['id', 'name']);
            return view('admin.project.create', compact('clients'));
        } catch (\Exception $e) {
            return back()->with('error', 'Could not open create form.');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date',
                'status' => 'required|in:not_started,in_progress,completed',
                'budget' => 'nullable|numeric',
                'client_id' => 'required|exists:clients,id',
            ]);

            Auth::user()->projects()->create($request->all());
            return redirect()->route('projects.index')->with('success', 'Project created successfully.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Could not create project.');
        }
    }

    public function show(Projects $project)
    {
        try {
            $teamMembers = $project->users()->get();
            $users = User::all();
            return view('admin.project.show', compact('project', 'teamMembers', 'users'));
        } catch (\Exception $e) {
            return back()->with('error', 'Could not load project.');
        }
    }

    public function edit(Projects $project)
    {
        try {

            $clients = Clients::orderBy('name')->get(['id', 'name']);
            return view('admin.project.edit', compact('project', 'clients'));
        } catch (\Exception $e) {
            return back()->with('error', 'Could not open edit form.');
        }
    }

    public function update(Request $request, Projects $project)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date',
                'status' => 'required|in:not_started,in_progress,completed',
                'budget' => 'nullable|numeric',
                'client_id' => 'required|exists:clients,id',
            ]);

            $project->update($request->all());

            return redirect()->route('projects.index')->with('success', 'Project updated successfully.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Could not update project.');
        }
    }

    public function destroy(Project $project)
    {
        try {
            $project->teams()->delete();
            $project->delete();

            return redirect()->route('projects.index')->with('success', 'Project deleted successfully.');
        } catch (\Exception $e) {
            return back()->withErrors([
                'delete' => 'Cannot work.',
            ]);
        }
    }

    public function addMember(Request $request)
    {
        try {
            $request->validate([
                'project_id' => 'required|exists:projects,id',
                'user_id' => 'required|exists:users,id',
            ]);

            $project = Project::find($request->project_id);
            // Attach user to project via pivot table without creating duplicates
            $project->users()->syncWithoutDetaching([$request->user_id]);
            return redirect()->back()->with('success', 'User added successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Could not add team member.');
        }
    }

    public function removeMember(Request $request)
    {
        try {
            $request->validate([
                'project_id' => 'required|exists:projects,id',
                'user_id' => 'required|exists:users,id',
            ]);

            $project = Project::findOrFail($request->project_id);
            $actor = Auth::user();
            $isOwner = (int)$project->user_id === (int)$actor->id;
            $isAdmin = method_exists($actor, 'hasAnyRole') ? $actor->hasAnyRole(['admin', 'manager']) : false;
            if (!($isOwner || $isAdmin)) {
                abort(403);
            }

            $project->users()->detach($request->user_id);
            return redirect()->back()->with('success', 'Team member removed successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Could not remove team member.');
        }
    }
}
