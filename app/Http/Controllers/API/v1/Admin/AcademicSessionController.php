<?php

namespace App\Http\Controllers\API\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\AcademicSessionResource;
use App\Models\AcademicSession;
use Illuminate\Http\Request;

class AcademicSessionController extends Controller
{
    public function index(Request $request)
    {
        $instituteId = $request->user()->institute_id;
        $sessions = AcademicSession::where('institute_id', $instituteId)
            ->orderBy('start_date', 'desc')
            ->paginate(5);
        $currentSession = AcademicSession::where('institute_id', $instituteId)
            ->whereDate('start_date', '<=', now()->toDateString())
            ->whereDate('end_date', '>=', now()->toDateString())
            ->first();    
        return response()->json([
            'status' => true,
            'message' => 'Academic sessions retrieved successfully.',
            'current_session' => $currentSession
                ? new AcademicSessionResource($currentSession)
                : null,
            'data' => AcademicSessionResource::collection($sessions),
        ], 200);
    }

    public function store(Request $request)
    {
        $instituteId = $request->user()->institute_id;
        $validatedData = $request->validate([
            'name' => 'required|string|max:100|unique:academic_sessions,name,NULL,id,institute_id,' . $instituteId,
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'sometimes|boolean',
        ]);
        $session = AcademicSession::create([
            'institute_id' => $instituteId,
            'name' => $validatedData['name'],
            'start_date' => $validatedData['start_date'],
            'end_date' => $validatedData['end_date'],
            'status' => $validatedData['status'] ?? true,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Academic session created successfully.',
            'data' => new AcademicSessionResource($session),
        ], 201);
    }

    public function show(Request $request,AcademicSession $academicSession) 
    {
        $instituteId = $request->user()->institute_id;
        if ($academicSession->institute_id !== $instituteId) {
            return response()->json([
                'status' => false,
                'message' => 'Academic session not found.',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Academic session retrieved successfully.',
            'data' => new AcademicSessionResource($academicSession),
        ], 200);
    }

    public function update(Request $request,AcademicSession $academicSession)
    {
        $instituteId = $request->user()->institute_id;
        if ($academicSession->institute_id !== $instituteId) {
            return response()->json([
                'status' => false,
                'message' => 'Academic session not found.',
            ], 404);
        }
        $validatedData = $request->validate([
            'name' => 'required|string|max:100|unique:academic_sessions,name,' . $academicSession->id . ',id,institute_id,' . $instituteId,
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);
        $academicSession->update([
            'name' => $validatedData['name'],
            'start_date' => $validatedData['start_date'],
            'end_date' => $validatedData['end_date'],
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Academic session updated successfully.',
            'data' => new AcademicSessionResource($academicSession),
        ], 200);
    }

    public function destroy(Request $request,AcademicSession $academicSession) 
    {
        $instituteId = $request->user()->institute_id;
        if ($academicSession->institute_id !== $instituteId) {
            return response()->json([
                'status' => false,
                'message' => 'Academic session not found.',
            ], 404);
        }
        if ($academicSession->enrollments()->exists()) {
            return response()->json([
                'status' => false,
                'message' => 'Academic session cannot be deleted because it has enrollment records.',
            ], 422);
        }
        if ($academicSession->teacherAssignments()->exists()) {
            return response()->json([
                'status' => false,
                'message' => 'Academic session cannot be deleted because it has teacher assignments.',
            ], 422);
        }
        $academicSession->delete();

        return response()->json([
            'status' => true,
            'message' => 'Academic session deleted successfully.',
        ], 200);
    }

    public function updateStatus(Request $request,AcademicSession $academicSession) 
    {
        $instituteId = $request->user()->institute_id;
        if ($academicSession->institute_id !== $instituteId) {
            return response()->json([
                'status' => false,
                'message' => 'Academic session not found.',
            ], 404);
        }
        $academicSession->status = !$academicSession->status;
        $academicSession->save();

        return response()->json([
            'status' => true,
            'message' => $academicSession->status
                ? 'Academic session activated successfully.'
                : 'Academic session deactivated successfully.',
            'data' => new AcademicSessionResource($academicSession),
        ], 200);
    }
}