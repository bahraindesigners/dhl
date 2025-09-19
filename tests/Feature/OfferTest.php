<?php

use App\Models\Offer;

test('offers page loads successfully', function () {
    $response = $this->get('/offers');
    
    $response->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('Offers/index')
            ->has('offers')
        );
});

test('offers page displays active offers only', function () {
    // Create active and inactive offers
    $activeOffer = Offer::factory()->create(['is_active' => true]);
    $inactiveOffer = Offer::factory()->create(['is_active' => false]);
    
    $response = $this->get('/offers');
    
    $response->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('Offers/index')
            ->has('offers', 1) // Should only have 1 active offer
            ->where('offers.0.id', $activeOffer->id)
        );
});

test('single offer page loads successfully', function () {
    $offer = Offer::factory()->create(['is_active' => true]);
    
    $response = $this->get("/offers/{$offer->id}");
    
    $response->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('Offers/show')
            ->has('offer')
            ->where('offer.id', $offer->id)
        );
});

test('inactive offer returns 404', function () {
    $offer = Offer::factory()->create(['is_active' => false]);
    
    $response = $this->get("/offers/{$offer->id}");
    
    $response->assertNotFound();
});

test('offers are ordered by sort_order and created_at', function () {
    // Create offers with different sort orders and dates
    $offer1 = Offer::factory()->create([
        'is_active' => true,
        'sort_order' => 2,
        'created_at' => now()->subDays(2)
    ]);
    
    $offer2 = Offer::factory()->create([
        'is_active' => true,
        'sort_order' => 1,
        'created_at' => now()->subDay()
    ]);
    
    $offer3 = Offer::factory()->create([
        'is_active' => true,
        'sort_order' => 1,
        'created_at' => now()
    ]);
    
    $response = $this->get('/offers');
    
    $response->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('Offers/index')
            ->has('offers', 3)
            // Should be ordered by sort_order ASC, then created_at DESC
            ->where('offers.0.id', $offer3->id) // sort_order 1, newest
            ->where('offers.1.id', $offer2->id) // sort_order 1, older
            ->where('offers.2.id', $offer1->id) // sort_order 2
        );
});
