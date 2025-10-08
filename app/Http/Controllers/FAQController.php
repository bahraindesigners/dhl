<?php

namespace App\Http\Controllers;

use App\Models\FAQ;
use App\Models\FAQCategory;
use Filament\Forms\Components\RichEditor\RichContentRenderer;
use Inertia\Inertia;
use Inertia\Response;

class FAQController extends Controller
{
    public function index(): Response
    {
        $locale = app()->getLocale();

        // Get all active FAQ categories with their FAQs
        $categories = FAQCategory::active()
            ->ordered()
            ->with([
                'faqs' => function ($query) {
                    $query->active()
                        ->published()
                        ->ordered();
                },
            ])
            ->get()
            ->map(function ($category) use ($locale) {
                return [
                    'id' => $category->id,
                    'name' => $category->getTranslation('name', $locale),
                    'description' => $category->getTranslation('description', $locale),
                    'slug' => $category->slug,
                    'is_active' => $category->is_active,
                    'sort_order' => $category->sort_order,
                    'faqs' => $category->faqs->map(function ($faq) use ($locale) {
                        // Get the answer translation
                        $answer = $faq->getTranslation('answer', $locale);

                        // Convert TipTap JSON to HTML if it's an array
                        if (is_array($answer)) {
                            $answer = RichContentRenderer::make($answer)->toHtml();
                        }

                        return [
                            'id' => $faq->id,
                            'question' => $faq->getTranslation('question', $locale),
                            'answer' => $answer,
                            'faq_category_id' => $faq->faq_category_id,
                            'category' => $faq->category,
                            'sort_order' => $faq->sort_order,
                            'is_featured' => $faq->is_featured,
                            'status' => $faq->status,
                            'slug' => $faq->slug,
                            'published_at' => $faq->published_at?->toISOString(),
                            'created_at' => $faq->created_at->toISOString(),
                            'updated_at' => $faq->updated_at->toISOString(),
                        ];
                    }),
                    'created_at' => $category->created_at->toISOString(),
                    'updated_at' => $category->updated_at->toISOString(),
                ];
            });

        // Get featured FAQs
        $featuredFaqs = FAQ::active()
            ->published()
            ->featured()
            ->ordered()
            ->limit(5)
            ->get()
            ->map(function ($faq) use ($locale) {
                // Get the answer translation
                $answer = $faq->getTranslation('answer', $locale);

                // Convert TipTap JSON to HTML if it's an array
                if (is_array($answer)) {
                    $answer = RichContentRenderer::make($answer)->toHtml();
                }

                return [
                    'id' => $faq->id,
                    'question' => $faq->getTranslation('question', $locale),
                    'answer' => $answer,
                    'faq_category_id' => $faq->faq_category_id,
                    'category' => $faq->category,
                    'sort_order' => $faq->sort_order,
                    'is_featured' => $faq->is_featured,
                    'status' => $faq->status,
                    'slug' => $faq->slug,
                    'published_at' => $faq->published_at?->toISOString(),
                    'created_at' => $faq->created_at->toISOString(),
                    'updated_at' => $faq->updated_at->toISOString(),
                ];
            });

        return Inertia::render('QuestionsAndAnswers/index', [
            'categories' => $categories,
            'featuredFaqs' => $featuredFaqs,
        ]);
    }
}
