<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Template;
use App\Models\Task;
use App\Models\Cycle;
use App\Models\CycleTask;
use App\Models\CycleTaskNote;
use App\Models\CycleTaskTag;


class CycleController extends Controller
{
    public function chooseTemplate()
    {
        $templates = auth()->user()->templates;
        return view('cycles.chooseTemplate', compact('templates'));
    }

    public function selectTemplate(Request $request)
    {
        if ($request->template_id != NULL) {
            $template = Template::find($request->template_id);
            return view('cycles.createWithTemplate', compact('template'));
        }
        return redirect()->route('cycles.createNoTemplate');
    }

    public function createNoTemplate()
    {
        return view('cycles.createNoTemplate');
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'cycle_name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'tasks' => 'required|array',
            'tasks.*.name' => 'required|string|max:255',
            'tasks.*.days_from_start' => 'required|integer',
            'tasks.*.reminder' => 'sometimes',
            'tasks.*.notes' => 'sometimes|array',
            'tasks.*.tags' => 'sometimes|array',
        ]);
// dd('ok');
        session(['cycle_data' => $validated]);
        return redirect()->route('cycles.confirmation');
    }

    public function confirmation()
    {
        $cycleData = session('cycle_data');
        return view('cycles.confirmation', compact('cycleData'));
    }

    public function confirm(Request $request)
    {
        $cycleData = session('cycle_data');

        $cycle = Cycle::create([
            'name' => $cycleData['cycle_name'],
            'start_date' => $cycleData['start_date'],
            'user_id' => auth()->id(),
        ]);

        foreach ($cycleData['tasks'] as $taskData) {
            $cycleTask = $cycle->tasks()->create([
                'name' => $taskData['name'],
                'days_from_start' => $taskData['days_from_start'],
                'reminder' => $taskData['reminder'] ?? 0,
            ]);

            if (isset($taskData['notes'])) {
                foreach ($taskData['notes'] as $note) {
                    $cycleTask->notes()->create(['note' => $note]);
                }
            }

            if (isset($taskData['tags'])) {
                foreach ($taskData['tags'] as $tag) {
                    $cycleTask->tags()->create(['tag' => $tag]);
                }
            }
        }

        return redirect()->route('home')->with('success', 'Cycle created successfully');
    }

    public function calendar()
    {
        $cycles = auth()->user()->cycles()->with('tasks')->get();
        return view('cycles.calendar', compact('cycles'));
    }

}
