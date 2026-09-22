<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\OpenAIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AIController extends Controller
{
    protected $aiService;

    public function __construct(OpenAIService $aiService)
    {
        $this->aiService = $aiService;
    }

    /**
     * Generate content suggestions
     * POST /api/v1/admin/ai/generate-content
     */
    public function generateContent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'content_type' => 'nullable|in:description,features,benefits',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $content = $this->aiService->generateContentSuggestion(
                $request->title,
                $request->category,
                $request->content_type ?? 'description'
            );

            return response()->json([
                'success' => true,
                'content' => $content,
            ]);

        } catch (\Exception $e) {
            Log::error('AI request failed', [
                'action' => $request->route()?->getActionMethod(),
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'The AI request could not be completed. Please try again.',
            ], 500);
        }
    }

    /**
     * Generate SEO meta tags
     * POST /api/v1/admin/ai/generate-seo
     */
    public function generateSEO(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $seo = $this->aiService->generateSEO(
                $request->content,
                $request->title
            );

            return response()->json([
                'success' => true,
                'seo' => $seo,
            ]);

        } catch (\Exception $e) {
            Log::error('AI request failed', [
                'action' => $request->route()?->getActionMethod(),
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'The AI request could not be completed. Please try again.',
            ], 500);
        }
    }

    /**
     * Analyze review sentiment
     * POST /api/v1/admin/ai/analyze-sentiment
     */
    public function analyzeSentiment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'text' => 'required|string',
            'review_id' => 'nullable|integer|exists:reviews,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $analysis = $this->aiService->analyzeReviewSentiment($request->text);

            // Optionally save sentiment to review
            if ($request->review_id) {
                $review = \App\Models\Review::find($request->review_id);
                if ($review) {
                    $review->update([
                        'sentiment' => $analysis['sentiment'],
                        'sentiment_score' => $analysis['score'],
                    ]);
                }
            }

            return response()->json([
                'success' => true,
                'analysis' => $analysis,
            ]);

        } catch (\Exception $e) {
            Log::error('AI request failed', [
                'action' => $request->route()?->getActionMethod(),
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'The AI request could not be completed. Please try again.',
            ], 500);
        }
    }

    /**
     * AI chatbot response
     * POST /api/v1/admin/ai/chatbot
     */
    public function chatbot(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'message' => 'required|string',
            'context' => 'nullable|array',
            'session_id' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            // Get company info from settings for context
            $settings = \App\Models\Setting::all()->pluck('value', 'key');
            $companyInfo = [
                'name' => $settings['site_name'] ?? 'OmniviaTech',
                'email' => $settings['contact_email'] ?? 'info@omniviatech.com',
                'phone' => $settings['contact_phone'] ?? '+254 710 351 517',
            ];

            $response = $this->aiService->chatbotResponse(
                $request->message,
                $request->context ?? [],
                $companyInfo
            );

            return response()->json([
                'success' => true,
                'response' => $response,
            ]);

        } catch (\Exception $e) {
            Log::error('AI request failed', [
                'action' => $request->route()?->getActionMethod(),
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'The AI request could not be completed. Please try again.',
            ], 500);
        }
    }

    /**
     * Generate process steps
     * POST /api/v1/admin/ai/generate-steps
     */
    public function generateSteps(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $steps = $this->aiService->generateProcessSteps(
                $request->title,
                $request->category
            );

            return response()->json([
                'success' => true,
                'steps' => $steps,
            ]);

        } catch (\Exception $e) {
            Log::error('AI request failed', [
                'action' => $request->route()?->getActionMethod(),
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'The AI request could not be completed. Please try again.',
            ], 500);
        }
    }

    /**
     * Improve text
     * POST /api/v1/admin/ai/improve-text
     */
    public function improveText(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'text' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $improved = $this->aiService->improveText($request->text);

            return response()->json([
                'success' => true,
                'original' => $request->text,
                'improved' => $improved,
            ]);

        } catch (\Exception $e) {
            Log::error('AI request failed', [
                'action' => $request->route()?->getActionMethod(),
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'The AI request could not be completed. Please try again.',
            ], 500);
        }
    }
}
