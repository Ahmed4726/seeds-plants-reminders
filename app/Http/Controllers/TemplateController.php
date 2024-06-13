<?php

namespace App\Http\Controllers;

use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TemplateController extends Controller
{
    public function index()
    {
        $templates = Template::leftJoin('tasks', 'tasks.template_id', '=', 'templates.id')
                              ->where('templates.user_id', auth()->user()->id)
                              ->select(
                                  'templates.id as id',
                                  'templates.name as name',
                                  'templates.created_at as created_at',
                                  DB::raw('COUNT(tasks.id) as task_count')
                              )
                              ->groupBy('templates.id', 'templates.name', 'templates.created_at')
                              ->get();
        return view('template.index', compact('templates'));
    }


    public function create()
    {
        return view('template.create');
    }


    public function store(Request $request)
    {
        // dd($request);
        $validated = Validator::make($request->all(), [
            'template_name' => 'required|max:255',
            'tasks' => 'required|array',
            'tasks.*.name' => 'required|string|max:255',
            'tasks.*.days_from_start' => 'required|integer',
            'tasks.*.reminder' => 'sometimes',
            'tasks.*.notes' => 'sometimes|array',
            'tasks.*.tags' => 'sometimes|array',
        ]);

        if ($validated->fails()) {
            return redirect()->back()
                             ->withErrors($validated)
                             ->withInput();
        }

        $template = Template::create([
            'name' => $request->template_name,
            'user_id' => auth()->user()->id
        ]);

        foreach ($request->tasks as $taskData) {
            $task = $template->tasks()->create([
                'name' => $taskData['name'],
                'days_from_start' => $taskData['days_from_start'],
                'reminder' => $taskData['reminder'] ?? 0,
            ]);

            if (isset($taskData['notes'])) {
                foreach ($taskData['notes'] as $note) {
                    $task->notes()->create(['note' => $note]);
                }
            }

            if (isset($taskData['tags'])) {
                foreach ($taskData['tags'] as $tag) {
                    $task->tags()->create(['tag' => $tag]);
                }
            }
        }

        return redirect()->route('templates.index')->with('success', 'Template saved successfully');
    }


    public function edit($id)
    {
        $template = Template::with('tasks.notes', 'tasks.tags')->findOrFail($id);
        return view('template.edit', compact('template'));
    }

    public function update(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            'template_name' => 'required|max:255',
            'tasks' => 'required|array',
            'tasks.*.name' => 'required|string|max:255',
            'tasks.*.days_from_start' => 'required|integer',
            'tasks.*.reminder' => 'sometimes',
            'tasks.*.notes' => 'sometimes|array',
            'tasks.*.tags' => 'sometimes|array',
        ]);

        if ($validated->fails()) {
            return redirect()->back()
                ->withErrors($validated)
                ->withInput();
        }

        $template = Template::findOrFail($id);
        $template->update([
            'name' => $request->template_name,
        ]);

        // Clear existing tasks, notes, and tags
        foreach ($template->tasks as $task) {
            $task->notes()->delete();
            $task->tags()->delete();
            $task->delete();
        }

        // Add updated tasks, notes, and tags
        foreach ($request->tasks as $taskData) {
            $task = $template->tasks()->create([
                'name' => $taskData['name'],
                'days_from_start' => $taskData['days_from_start'],
                'reminder' => $taskData['reminder'] ?? 0,
            ]);

            if (isset($taskData['notes'])) {
                foreach ($taskData['notes'] as $note) {
                    $task->notes()->create(['note' => $note]);
                }
            }

            if (isset($taskData['tags'])) {
                foreach ($taskData['tags'] as $tag) {
                    $task->tags()->create(['tag' => $tag]);
                }
            }
        }

        return redirect()->route('templates.index')->with('success', 'Template updated successfully');
    }


    public function destroy($id)
    {
        // dd('ok');
        $template = Template::findOrFail($id);

        // Delete associated tasks, notes, and tags
        foreach ($template->tasks as $task) {
            $task->notes()->delete();
            $task->tags()->delete();
            $task->delete();
        }

        // Delete the template
        $template->delete();

        return redirect()->route('templates.index')->with('success', 'Template and associated data deleted successfully');
    }


}
