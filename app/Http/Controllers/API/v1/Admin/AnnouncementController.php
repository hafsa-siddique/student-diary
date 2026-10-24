<?php

namespace App\Http\Controllers\API\v1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);
        $user = $request->user();
        $announcement = Announcement::create([
            'institute_id' => $user->institute_id,
            'user_id' => $user->id,
            'message' => $request->message,
            'date' => now()->toDateString(), 
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Announcement published successfully!',
            'data' => $announcement
        ], 201);
    }
    public function getActiveAnnouncement(Request $request)
    {
        $user = $request->user();
        $today = now()->toDateString();
        $announcement = Announcement::where('institute_id', $user->institute_id)
            ->where('date', $today)
            ->latest()
            ->first();
        if (!$announcement) {
            return response()->json([
                'status' => false,
                'message' => 'No announcement for today'
            ], 404);
        }
        return response()->json([
            'status' => true,
            'data' => $announcement
        ]);
    }
}
