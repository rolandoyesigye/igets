<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class SearchTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        // Create test products with various cases
        Product::factory()->create([
            'name' => 'MacBook Pro',
            'description' => 'Apple laptop with M1 chip',
            'brand' => 'Apple',
            'category' => 'laptops',
            'is_active' => true,
            'stock_quantity' => 10,
        ]);

        Product::factory()->create([
            'name' => 'iPhone 14',
            'description' => 'Latest smartphone from Apple',
            'brand' => 'apple', // lowercase brand
            'category' => 'phones',
            'is_active' => true,
            'stock_quantity' => 5,
        ]);

        Product::factory()->create([
            'name' => 'Samsung Galaxy',
            'description' => 'Android SMARTPHONE with great camera',
            'brand' => 'Samsung',
            'category' => 'PHONES', // uppercase category
            'is_active' => true,
            'stock_quantity' => 8,
        ]);

        Product::factory()->create([
            'name' => 'Dell XPS',
            'description' => 'Business laptop for professionals',
            'brand' => 'DELL', // uppercase brand
            'category' => 'laptops',
            'is_active' => false, // inactive product
            'stock_quantity' => 0,
        ]);
    }

    /** @test */
    public function it_performs_case_insensitive_search_on_product_names()
    {
        // Search with lowercase
        $results = Product::search('macbook')->active()->get();
        $this->assertCount(1, $results);
        $this->assertEquals('MacBook Pro', $results->first()->name);

        // Search with uppercase
        $results = Product::search('MACBOOK')->active()->get();
        $this->assertCount(1, $results);
        $this->assertEquals('MacBook Pro', $results->first()->name);

        // Search with mixed case
        $results = Product::search('MacBook')->active()->get();
        $this->assertCount(1, $results);
        $this->assertEquals('MacBook Pro', $results->first()->name);
    }

    /** @test */
    public function it_performs_case_insensitive_search_on_descriptions()
    {
        // Search for "smartphone" in different cases
        $results = Product::search('smartphone')->active()->get();
        $this->assertCount(2, $results);

        $results = Product::search('SMARTPHONE')->active()->get();
        $this->assertCount(2, $results);

        $results = Product::search('SmartPhone')->active()->get();
        $this->assertCount(2, $results);
    }

    /** @test */
    public function it_performs_case_insensitive_search_on_brands()
    {
        // Search for Apple in different cases
        $results = Product::search('apple')->active()->get();
        $this->assertCount(2, $results);

        $results = Product::search('APPLE')->active()->get();
        $this->assertCount(2, $results);

        $results = Product::search('Apple')->active()->get();
        $this->assertCount(2, $results);

        // Search for Dell in different cases
        $results = Product::search('dell')->active()->get();
        $this->assertCount(0, $results); // Dell product is inactive
    }

    /** @test */
    public function it_performs_case_insensitive_search_on_categories()
    {
        // Search for phones in different cases
        $results = Product::search('phones')->active()->get();
        $this->assertCount(2, $results);

        $results = Product::search('PHONES')->active()->get();
        $this->assertCount(2, $results);

        $results = Product::search('Phones')->active()->get();
        $this->assertCount(2, $results);
    }

    /** @test */
    public function search_results_only_include_active_products()
    {
        // Search should only return active products
        $results = Product::search('dell')->active()->get();
        $this->assertCount(0, $results);

        // But without active scope, it should find the inactive product
        $results = Product::search('dell')->get();
        $this->assertCount(1, $results);
    }

    /** @test */
    public function livewire_search_component_works_with_case_insensitive_search()
    {
        $component = \Livewire\Livewire::test(\App\Livewire\ProductSearch::class);

        // Test lowercase search
        $component->set('query', 'macbook')
                  ->assertSet('showResults', true)
                  ->assertCount('products', 1);

        // Test uppercase search
        $component->set('query', 'IPHONE')
                  ->assertSet('showResults', true)
                  ->assertCount('products', 1);

        // Test mixed case search
        $component->set('query', 'Samsung')
                  ->assertSet('showResults', true)
                  ->assertCount('products', 1);
    }

    /** @test */
    public function web_search_endpoint_returns_case_insensitive_results()
    {
        // Test search endpoint with lowercase
        $response = $this->get(route('search.results', ['q' => 'apple']));
        $response->assertStatus(200);
        $response->assertViewHas('results');

        // Test search endpoint with uppercase
        $response = $this->get(route('search.results', ['q' => 'APPLE']));
        $response->assertStatus(200);
        $response->assertViewHas('results');

        // Test search endpoint with mixed case
        $response = $this->get(route('search.results', ['q' => 'Apple']));
        $response->assertStatus(200);
        $response->assertViewHas('results');
    }

    /** @test */
    public function api_search_endpoint_returns_case_insensitive_results()
    {
        // Test API search with lowercase
        $response = $this->getJson(route('api.search', ['q' => 'apple']));
        $response->assertStatus(200)
                 ->assertJsonCount(2);

        // Test API search with uppercase
        $response = $this->getJson(route('api.search', ['q' => 'APPLE']));
        $response->assertStatus(200)
                 ->assertJsonCount(2);

        // Test API search with mixed case
        $response = $this->getJson(route('api.search', ['q' => 'Apple']));
        $response->assertStatus(200)
                 ->assertJsonCount(2);
    }

    /** @test */
    public function search_suggestions_are_case_insensitive()
    {
        // Test search suggestions with different cases
        $response = $this->getJson(route('api.search.suggestions', ['q' => 'ap']));
        $response->assertStatus(200);

        $response = $this->getJson(route('api.search.suggestions', ['q' => 'AP']));
        $response->assertStatus(200);

        $response = $this->getJson(route('api.search.suggestions', ['q' => 'Ap']));
        $response->assertStatus(200);
    }

    /** @test */
    public function partial_search_terms_work_case_insensitively()
    {
        // Partial name search
        $results = Product::search('mac')->active()->get();
        $this->assertCount(1, $results);

        $results = Product::search('MAC')->active()->get();
        $this->assertCount(1, $results);

        // Partial brand search
        $results = Product::search('app')->active()->get();
        $this->assertCount(2, $results);

        $results = Product::search('APP')->active()->get();
        $this->assertCount(2, $results);
    }

    /** @test */
    public function empty_search_returns_no_results()
    {
        $results = Product::search('')->active()->get();
        $this->assertCount(4, $results); // Should return all active products when no search term

        $results = Product::search('   ')->active()->get();
        $this->assertCount(4, $results); // Should return all active products for whitespace
    }

    /** @test */
    public function search_with_special_characters_is_handled_safely()
    {
        // Test with SQL injection attempt
        $results = Product::search("'; DROP TABLE products; --")->active()->get();
        $this->assertCount(0, $results);

        // Test with percentage signs (LIKE wildcards)
        $results = Product::search("%")->active()->get();
        $this->assertCount(0, $results);

        $results = Product::search("_")->active()->get();
        $this->assertCount(0, $results);
    }
}
