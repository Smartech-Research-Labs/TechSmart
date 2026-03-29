<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use App\Models\User;
use App\Notifications\EnquiryNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class EnquiryController extends Controller
{
    public function store(Request $request)
    {
        $type = $request->input('type', 'general');

        // Base validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'type' => 'nullable|string|in:contact,quote,consultation,general,service_enquiry,product_enquiry',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
            'form_data' => 'nullable|array',
        ];

        // Only require enquirable fields for service/product enquiries
        if (in_array($type, ['service_enquiry', 'product_enquiry'])) {
            $rules['enquirable_type'] = 'required|in:App\\Models\\Service,App\\Models\\Product,App\\Models\\Bundle';
            $rules['enquirable_id'] = 'required|integer';
        } else {
            $rules['enquirable_type'] = 'nullable|string';
            $rules['enquirable_id'] = 'nullable|integer';
        }

        // Extra validation for quote requests
        if ($type === 'quote') {
            $rules['service'] = 'nullable|string|max:255';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Build form_data with extra fields
        $formData = $request->form_data ?? [];
        if ($request->has('service') && $type === 'quote') {
            $formData['requested_service'] = $request->service;
        }
        if ($request->has('subject')) {
            $formData['subject'] = $request->subject;
        }

        $enquiry = Enquiry::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'company' => $request->company,
            'type' => $type,
            'subject' => $request->subject,
            'enquirable_type' => $request->enquirable_type,
            'enquirable_id' => $request->enquirable_id,
            'message' => $request->message,
            'form_data' => !empty($formData) ? $formData : null,
            'user_id' => auth()->id(),
        ]);

        // Notify all admins
        $admins = User::role(['admin', 'superadmin', 'super-admin'])->get();
        if ($admins->isNotEmpty()) {
            Notification::send($admins, new EnquiryNotification(
                $request->name,
                $request->email,
                $request->message ? mb_substr($request->message, 0, 80) : 'New ' . $type . ' enquiry',
                $enquiry->id,
            ));
        }

        return response()->json([
            'message' => 'Your message has been sent successfully. We\'ll get back to you soon!',
            'enquiry' => $enquiry,
        ], 201);
    }
}
