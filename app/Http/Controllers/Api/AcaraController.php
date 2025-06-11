<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Acara;
use App\Models\Panitia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AcaraController extends Controller
{
    /**
     * Create a new event
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal_acara' => 'required|date|after_or_equal:today',
            'batas_pendaftaran' => 'required|date|before_or_equal:tanggal_acara',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Check if the authenticated user is a committee member
        if (Auth::user()->role !== 'panitia') {
            return response()->json([
                'status' => 'error',
                'message' => 'Only committee members can create events'
            ], 403);
        }

        // Get the panitia record
        $panitia = Panitia::where('user_id', Auth::id())->first();
        if (!$panitia) {
            return response()->json([
                'status' => 'error',
                'message' => 'Committee member profile not found'
            ], 404);
        }

        // Prepare data
        $data = $request->except('image');
        $data['panitia_id'] = $panitia->id;
        $data['status'] = 'pending';

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/acara', $imageName);
            $data['image'] = $imageName;
        }

        // Create the event
        $acara = Acara::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Event created successfully and waiting for approval',
            'data' => $acara
        ], 201);
    }
}