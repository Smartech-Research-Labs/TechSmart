<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use App\Models\User;
use App\Notifications\NewsletterNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:newsletter_subscribers,email',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $subscriber = NewsletterSubscriber::create([
            'email' => $request->email,
        ]);

        // Notify admins about new subscriber
        $admins = User::role(['admin', 'superadmin', 'super-admin'])->get();
        Notification::send($admins, new NewsletterNotification($request->email));

        // TODO: Dispatch job to send welcome email

        return response()->json([
            'message' => 'Successfully subscribed to newsletter!',
        ], 201);
    }

    public function unsubscribe(Request $request)
    {
        $subscriber = NewsletterSubscriber::where('email', $request->email)
            ->where('token', $request->token)
            ->firstOrFail();

        $subscriber->unsubscribe();

        return response()->json([
            'message' => 'Successfully unsubscribed from newsletter.',
        ]);
    }
}
