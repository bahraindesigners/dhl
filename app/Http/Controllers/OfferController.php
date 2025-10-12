<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Filament\Forms\Components\RichEditor\RichContentRenderer;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OfferController extends Controller
{
    /**
     * Display a listing of the offers.
     */
    public function index(Request $request)
    {
        $locale = app()->getLocale();

        $offers = Offer::active()
            ->ordered()
            ->get()
            ->map(function ($offer) use ($locale) {
                // Get the offer_description translation
                $offerDescription = $offer->getTranslation('offer_description', $locale);

                // Convert TipTap JSON to HTML if it's an array
                if (is_array($offerDescription)) {
                    $offerDescription = RichContentRenderer::make($offerDescription)->toHtml();
                }

                return [
                    'id' => $offer->id,
                    'title' => $offer->getTranslation('title', $locale),
                    'description' => $offer->getTranslation('description', $locale),
                    'company_name' => $offer->getTranslation('company_name', $locale),
                    'discount' => $offer->discount,
                    'offer_description' => $offerDescription,
                    'created_at' => $offer->created_at,
                    'updated_at' => $offer->updated_at,
                ];
            });

        return Inertia::render('Offers/index', [
            'offers' => $offers,
        ]);
    }

    /**
     * Display the specified offer.
     */
    public function show(Offer $offer)
    {
        // Only show active offers to the public
        if (! $offer->is_active) {
            abort(404);
        }

        $locale = app()->getLocale();

        // Get the offer_description translation
        $offerDescription = $offer->getTranslation('offer_description', $locale);

        // Convert TipTap JSON to HTML if it's an array
        if (is_array($offerDescription)) {
            $offerDescription = RichContentRenderer::make($offerDescription)->toHtml();
        }

        return Inertia::render('Offers/show', [
            'offer' => [
                'id' => $offer->id,
                'title' => $offer->getTranslation('title', $locale),
                'description' => $offer->getTranslation('description', $locale),
                'company_name' => $offer->getTranslation('company_name', $locale),
                'discount' => $offer->discount,
                'offer_description' => $offerDescription,
                'created_at' => $offer->created_at,
                'updated_at' => $offer->updated_at,
            ],
        ]);
    }
}
