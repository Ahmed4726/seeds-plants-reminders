<?php

namespace App\Http\Controllers;

use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TemplateController extends Controller
{
    public function index()
    {
        return view('template.index');
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

}
