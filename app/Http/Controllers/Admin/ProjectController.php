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
        } catch (\Throwable $e) {
            return log_error($e);
        }
    }

    public function create()
    {
        try {
            $clients = Clients::orderBy('name')->get(['id', 'name']);
            return view('admin.project.create', compact('clients'));
        } catch (\Throwable $e) {
            return log_error($e);
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

            $assignBy = Auth::user();
            $project = Projects::create([
                'name' => $request->name,
                'description' => $request->description,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'status' => $request->status,
                'budget' => $request->budget,
                'client_id' => $request->client_id,
                'user_id' => $assignBy->id,
                'company_id' => session('company_id'),
            ]);

            return redirect()->route('projects.index')->with('success', 'Project created successfully.');
        } catch (\Throwable $e) {
            return log_error($e);
        }
    }

    public function show(Projects $project)
    {
        try {
            $teamMembers = $project->users()->get();
            $users = User::all();
            return view('admin.project.show', compact('project', 'teamMembers', 'users'));
        } catch (\Throwable $e) {
            return log_error($e);
        }
    }

    public function edit(Projects $project)
    {
        try {

            $clients = Clients::orderBy('name')->get(['id', 'name']);
            return view('admin.project.edit', compact('project', 'clients'));
        } catch (\Throwable $e) {
            return log_error($e);
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

            // dd($request->all());
            $project->update($request->all() + ['company_id' => session('company_id')]);
            return redirect()->route('projects.index')->with('success', 'Project updated successfully.');
        } catch (\Throwable $e) {
            return log_error($e);
        }
    }

    public function destroy(Projects $project)
    {
        try {
            if (! $project->teams()->exists()) {
                $project->delete();
            }
            return redirect()->route('projects.index')->with('success', 'Project deleted successfully.');
        } catch (\Throwable $e) {
            return log_error($e);
        }
    }

    public function addMember(Request $request)
    {
        try {
            $request->validate([
                'project_id' => 'required|exists:projects,id',
                'user_id' => 'required|exists:users,id',
            ]);
            $project = Projects::findOrFail($request->project_id);
            $project->users()->syncWithoutDetaching([
                $request->user_id => ['company_id' => session('company_id')]
            ]);

            return redirect()->back()->with('success', 'User added successfully.');
        } catch (\Throwable $e) {
            return log_error($e);
        }
    }

    public function removeMember(Request $request)
    {
        try {

            $request->validate([
                'project_id' => 'required|exists:projects,id',
                'user_id' => 'required|exists:users,id',
            ]);

            $project = Projects::findOrFail($request->project_id);
            $project->users()->detach($request->user_id);
            return redirect()->back()->with('success', 'Team member removed successfully.');
        } catch (\Throwable $e) {
            return log_error($e);
        }
    }
}
