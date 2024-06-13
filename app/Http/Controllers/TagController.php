<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\Cycle;
use App\Models\CycleTask;
use App\Models\CycleTaskTag;

class TagController extends Controller
{
    public function index()
    {
        $tags = auth()->user()->cycleTags;
        return view('tags.index', compact('tags'));
    }

    public function show($tag)
    {
        $tag = CycleTaskTag::where('tag', $tag)->first();
        if (!$tag) {
            abort(404);
        }

        $cycles = Cycle::leftJoin('cycletasks','cycletasks.cycle_id', '=', 'cycles.id')
                        ->leftJoin('cycletask_tags','cycletask_tags.cycle_task_id', '=', 'cycletasks.id')
                        ->where('cycletask_tags.tag',$tag->tag)
                        ->where('cycles.user_id', auth()->user()->id)
                        ->select('cycles.start_date as start_date','cycles.name as name','cycletasks.days_from_start as days_from_start','cycletasks.reminder as reminder','cycletasks.name as task_name')
                        ->get();

                        // dd($cycles);

        return view('tags.show', compact('tag', 'cycles'));
    }
}
