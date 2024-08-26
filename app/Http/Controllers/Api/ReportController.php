<?php

namespace App\Http\Controllers\Api;

use App\Exports\ProjectReportExport;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $currentUser = auth()->user();
        // Check if the current user is an admin or team-leader
        if ($currentUser->type !== 'admin' && $currentUser->type !== 'team-leader') {
            return response()->json([ 'message' => 'Unauthorized. Only admin or team-leader take this action.'], 403);
        }

        $validator = Validator::make($request->all(), [
            'start_date' => 'required|date|date_format:Y-m-d',
            'end_date'   => 'required|date|date_format:Y-m-d|after_or_equal:start_date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $projects = Project::with('teamLeader', 'tasks')
            ->whereBetween('created_at', [$request->start_date, $request->end_date])
            ->paginate($request->input('per_page', 15));

        return ProjectResource::collection($projects);
    }

    public function export(Request $request)
    {
        $currentUser = auth()->user();
        // Check if the current user is an admin or team-leader
        if ($currentUser->type !== 'admin' && $currentUser->type !== 'team-leader') {
            return response()->json([ 'message' => 'Unauthorized. Only admin or team-leader take this action.'], 403);
        }

        $validator = Validator::make($request->all(), [
            'start_date' => 'required|date|date_format:Y-m-d',
            'end_date'   => 'required|date|date_format:Y-m-d|after_or_equal:start_date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $params   = $request->all();
        $filePath = 'reports/project_report_' . now()->format('Ymd_His') . '.xlsx';
        Excel::store(new ProjectReportExport($params), $filePath, 'public');
        $fileUrl  = Storage::url($filePath);
        return response()->json(['file_url' => url($fileUrl)], 200);
    }
}
