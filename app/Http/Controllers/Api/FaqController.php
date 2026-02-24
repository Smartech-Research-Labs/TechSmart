<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\{Faq, FaqCategory};
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $categories = FaqCategory::with(['faqs' => function ($query) {
            $query->visible()->orderBy('order');
        }])->orderBy('order')->get();

        return response()->json($categories);
    }

    public function search(Request $request)
    {
        $query = $request->get('q');

        $faqs = Faq::visible()
            ->where(function ($q) use ($query) {
                $q->where('question', 'like', "%{$query}%")
                    ->orWhere('answer', 'like', "%{$query}%");
            })
            ->with('category')
            ->orderBy('order')
            ->get();

        return response()->json($faqs);
    }
}
