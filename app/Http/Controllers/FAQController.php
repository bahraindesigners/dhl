<?php

namespace App\Http\Controllers;

use App\Models\FAQ;
use App\Models\FAQCategory;
use Inertia\Inertia;
use Inertia\Response;

class FAQController extends Controller
{
    public function index(): Response
    {
        // Get all active FAQ categories with their FAQs
        $categories = FAQCategory::active()
            ->ordered()
            ->with([
                'faqs' => function ($query) {
                    $query->active()
                        ->published()
                        ->ordered();
                }
            ])
            ->get();

        // Get featured FAQs
        $featuredFaqs = FAQ::active()
            ->published()
            ->featured()
            ->ordered()
            ->limit(5)
            ->get();

        return Inertia::render('QuestionsAndAnswers/index', [
            'categories' => $categories,
            'featuredFaqs' => $featuredFaqs,
        ]);
    }
}
