<?php

namespace App\Http\Controllers;

use App\Exercise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExerciseController extends Controller
{
    public function getListExercise()
    {
        $exercises = Exercise::select('topic')->distinct('')->get();
        $self_solution = Exercise::select('topic', 'solution')->where('user_submit', Auth::user()->username);
        return view('auth.list_exercise')->with(['exercises' => $exercises, 'self_solution' => $self_solution]);
    }

    public function addExercise(Request $request)
    {
        if ($request->hasFile('filename')) {
            $file = $request->file('filename');
            $file->move(
                'document/exercise',
                $file->getClientOriginalName()
            );
        } else {
            echo "Chưa có file";
        }
        $link = 'document/exercise/' . $request->file('filename')->getClientOriginalName();
        $exercise = new Exercise();
        $exercise->topic = $request->topic;
        $exercise->exercise = $link;
        $exercise->solution = 'null';
        $exercise->user_submit = 'giaovien';
        $exercise->save();
        return redirect()->action('\App\Http\Controllers\ExerciseController@getListExercise');
    }

    public function uploadSolution(Request $request, $topic)
    {
        $exercise_upload = Exercise::where('topic', $topic)->first()->exercise;
        if ($request->hasFile('filename')) {
            $file = $request->file('filename');
            $file->move(
                'document/solution',
                $file->getClientOriginalName()
            );
        } else {
            echo "Chưa có file";
        }
        $link = 'document/solution/' . $request->file('filename')->getClientOriginalName();
        Exercise::updateOrCreate(
            ['exercise' => $exercise_upload, 'topic' => $topic, 'user_submit' => Auth::user()->username],
            ['id'=>'null','solution' => $link]
    );
        return redirect()->action('\App\Http\Controllers\ExerciseController@getListExercise');
    }
}
