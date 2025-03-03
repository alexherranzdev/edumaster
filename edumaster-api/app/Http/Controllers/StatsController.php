<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Worksheet;
use Edumaster\Learning\Worksheet\Infrastructure\Persistence\EloquentWorksheetStudent;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    public function getTotals(Request $request)
    {
        $totalStudents = 0;
        $totalWorksheets = Worksheet::count();

        if ($request->user()->role === 'student' || ($request->has('student_id') && $request->user()->role === 'teacher')) {
            $userId = $request->has('student_id') ? $request->input('student_id') : $request->user()->user_id;
            $totalInProgressWorksheets = EloquentWorksheetStudent::where('status', 'in_progress')->where('student_id', $userId)->count();
            $totalCompletedWorksheets = EloquentWorksheetStudent::where('status', 'completed')->where('student_id', $userId)->count();
        } else {
            $totalStudents = User::where('role', 'student')->count();
            $totalInProgressWorksheets = EloquentWorksheetStudent::where('status', 'in_progress')->count();
            $totalCompletedWorksheets = EloquentWorksheetStudent::where('status', 'completed')->count();
        }

        $response = [
            'total_students' => $totalStudents,
            'total_worksheets' => $totalWorksheets,
            'total_in_progress_worksheets' => $totalInProgressWorksheets,
            'total_completed_worksheets' => $totalCompletedWorksheets,
        ];

        return response()->json($response);
    }
}
