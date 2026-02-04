<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tasks;
use Illuminate\Http\Request;

class MyTaskController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');
        $status = $request->query('status');

        $query = Tasks::with('project')
            ->withCount('checklistItems')
            ->where('assigned_to', auth()->id());

        if ($q) {
            $query->where(function ($s) use ($q) {
                $s->where('title', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        $tasks = $query->orderBy('due_date', 'asc')->paginate(10)->withQueryString();

        return view('admin.my-tasks.index', compact('tasks'));
    }
}
