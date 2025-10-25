<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transcription;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TranscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $transcriptions = Auth::user()->transcriptions()
            ->latest()
            ->paginate(10);

        return response()->json([
            'data' => $transcriptions,
            'message' => 'Transcriptions retrieved successfully.'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'language' => 'sometimes|string|max:10',
            'status' => 'sometimes|in:draft,in_progress,completed,archived',
            'metadata' => 'sometimes|json',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $transcription = Auth::user()->transcriptions()->create([
            'title' => $request->title,
            'content' => $request->content,
            'language' => $request->language ?? 'en',
            'status' => $request->status ?? 'draft',
            'metadata' => $request->metadata ?? '{}',
        ]);

        return response()->json([
            'data' => $transcription,
            'message' => 'Transcription created successfully.'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Transcription $transcription): JsonResponse
    {
        $this->authorize('view', $transcription);

        return response()->json([
            'data' => $transcription,
            'message' => 'Transcription retrieved successfully.'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transcription $transcription): JsonResponse
    {
        $this->authorize('update', $transcription);

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
            'language' => 'sometimes|string|max:10',
            'status' => 'sometimes|in:draft,in_progress,completed,archived',
            'metadata' => 'sometimes|json',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $transcription->update($request->only([
            'title', 'content', 'language', 'status', 'metadata'
        ]));

        return response()->json([
            'data' => $transcription->fresh(),
            'message' => 'Transcription updated successfully.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transcription $transcription): JsonResponse
    {
        $this->authorize('delete', $transcription);
        
        $transcription->delete();

        return response()->json([
            'message' => 'Transcription deleted successfully.'
        ], 204);
    }
}
