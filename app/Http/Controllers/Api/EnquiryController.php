<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EnquiryController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'enquirable_type' => 'required|in:App\\Models\\Service,App\\Models\\Product,App\\Models\\Bundle',
            'enquirable_id' => 'required|integer',
            'message' => 'required|string',
            'form_data' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $enquiry = Enquiry::create([
            ...$request->only(['name', 'email', 'phone', 'company', 'message', 'form_data']),
            'enquirable_type' => $request->enquirable_type,
            'enquirable_id' => $request->enquirable_id,
            'user_id' => auth()->id(),
        ]);

        // TODO: Dispatch job to send email notification to admin
        // TODO: Broadcast Socket.IO event to admin dashboard

        return response()->json([
            'message' => 'Enquiry submitted successfully',
            'enquiry' => $enquiry->load('enquirable'),
        ], 201);
    }
}
