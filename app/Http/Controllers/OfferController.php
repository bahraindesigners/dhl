<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OfferController extends Controller
{
    /**
     * Display a listing of the offers.
     */
    public function index(Request $request)
    {
        $offers = Offer::active()
            ->ordered()
            ->get()
            ->map(function ($offer) {
                return [
                    'id' => $offer->id,
                    'title' => $offer->title, // Laravel auto-resolves based on current locale
                    'description' => $offer->description,
                    'company_name' => $offer->company_name,
                    'discount' => $offer->discount,
                    'offer_description' => $offer->offer_description,
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
        if (!$offer->is_active) {
            abort(404);
        }

        return Inertia::render('Offers/show', [
            'offer' => [
                'id' => $offer->id,
                'title' => $offer->title, // Laravel auto-resolves based on current locale
                'description' => $offer->description,
                'company_name' => $offer->company_name,
                'discount' => $offer->discount,
                'offer_description' => $offer->offer_description,
                'created_at' => $offer->created_at,
                'updated_at' => $offer->updated_at,
            ],
        ]);
    }
}
