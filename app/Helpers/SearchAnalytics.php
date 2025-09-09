<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class SearchAnalytics
{
    /**
     * Track a search query
     */
    public static function trackSearch(string $query, int $resultsCount = 0, string $userId = null)
    {
        try {
            $searchData = [
                'query' => trim($query),
                'results_count' => $resultsCount,
                'user_id' => $userId,
                'timestamp' => now(),
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ];

            // Store in cache for processing
            $cacheKey = 'search_analytics_' . md5($query . $userId . time());
            Cache::put($cacheKey, $searchData, now()->addHours(24));

            // Update popular searches
            self::updatePopularSearches($query);

            // Track zero results searches
            if ($resultsCount === 0) {
                self::trackZeroResultsSearch($query);
            }

            Log::info('Search tracked', $searchData);
        } catch (\Exception $e) {
            Log::error('Failed to track search analytics', [
                'query' => $query,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Track product click from search results
     */
    public static function trackProductClick(string $query, int $productId, int $position = 0)
    {
        try {
            $clickData = [
                'query' => trim($query),
                'product_id' => $productId,
                'position' => $position,
                'timestamp' => now(),
                'user_id' => auth()->id(),
                'ip_address' => request()->ip(),
            ];

            $cacheKey = 'search_click_' . md5($query . $productId . time());
            Cache::put($cacheKey, $clickData, now()->addHours(24));

            Log::info('Search product click tracked', $clickData);
        } catch (\Exception $e) {
            Log::error('Failed to track search click', [
                'query' => $query,
                'product_id' => $productId,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Get popular search queries
     */
    public static function getPopularSearches(int $limit = 10): array
    {
        return Cache::get('popular_searches', []);
    }

    /**
     * Get search suggestions based on popular searches
     */
    public static function getSearchSuggestions(string $query, int $limit = 5): array
    {
        $popularSearches = self::getPopularSearches(50);
        $query = strtolower(trim($query));

        if (empty($query)) {
            return array_slice($popularSearches, 0, $limit);
        }

        $suggestions = [];
        foreach ($popularSearches as $search => $count) {
            if (stripos($search, $query) !== false) {
                $suggestions[$search] = $count;
            }
        }

        // Sort by count descending
        arsort($suggestions);

        return array_slice(array_keys($suggestions), 0, $limit);
    }

    /**
     * Get zero results searches
     */
    public static function getZeroResultsSearches(int $limit = 20): array
    {
        return Cache::get('zero_results_searches', []);
    }

    /**
     * Get search analytics summary
     */
    public static function getAnalyticsSummary(): array
    {
        return [
            'popular_searches' => self::getPopularSearches(10),
            'zero_results_searches' => self::getZeroResultsSearches(10),
            'total_searches_today' => self::getTodaySearchCount(),
            'average_results_per_search' => self::getAverageResultsPerSearch(),
        ];
    }

    /**
     * Update popular searches cache
     */
    protected static function updatePopularSearches(string $query): void
    {
        $query = strtolower(trim($query));

        if (empty($query) || strlen($query) < 2) {
            return;
        }

        $popularSearches = Cache::get('popular_searches', []);
        $popularSearches[$query] = ($popularSearches[$query] ?? 0) + 1;

        // Keep only top 100 searches
        arsort($popularSearches);
        $popularSearches = array_slice($popularSearches, 0, 100, true);

        Cache::put('popular_searches', $popularSearches, now()->addDays(30));
    }

    /**
     * Track searches with zero results
     */
    protected static function trackZeroResultsSearch(string $query): void
    {
        $query = strtolower(trim($query));

        if (empty($query)) {
            return;
        }

        $zeroResultsSearches = Cache::get('zero_results_searches', []);
        $zeroResultsSearches[$query] = ($zeroResultsSearches[$query] ?? 0) + 1;

        // Keep only top 50 zero-result searches
        arsort($zeroResultsSearches);
        $zeroResultsSearches = array_slice($zeroResultsSearches, 0, 50, true);

        Cache::put('zero_results_searches', $zeroResultsSearches, now()->addDays(30));
    }

    /**
     * Get today's search count
     */
    protected static function getTodaySearchCount(): int
    {
        $cacheKey = 'search_count_' . now()->format('Y-m-d');
        return Cache::get($cacheKey, 0);
    }

    /**
     * Increment today's search count
     */
    public static function incrementTodaySearchCount(): void
    {
        $cacheKey = 'search_count_' . now()->format('Y-m-d');
        $count = Cache::get($cacheKey, 0);
        Cache::put($cacheKey, $count + 1, now()->endOfDay());
    }

    /**
     * Get average results per search
     */
    protected static function getAverageResultsPerSearch(): float
    {
        // This would typically be calculated from stored analytics data
        // For now, return a placeholder value
        return Cache::get('avg_results_per_search', 0.0);
    }

    /**
     * Update average results per search
     */
    public static function updateAverageResults(int $resultsCount): void
    {
        $currentAvg = Cache::get('avg_results_per_search', 0.0);
        $currentCount = Cache::get('avg_results_count', 0);

        $newCount = $currentCount + 1;
        $newAvg = (($currentAvg * $currentCount) + $resultsCount) / $newCount;

        Cache::put('avg_results_per_search', round($newAvg, 2), now()->addDays(30));
        Cache::put('avg_results_count', $newCount, now()->addDays(30));
    }

    /**
     * Clear analytics cache
     */
    public static function clearCache(): void
    {
        $keys = [
            'popular_searches',
            'zero_results_searches',
            'avg_results_per_search',
            'avg_results_count'
        ];

        foreach ($keys as $key) {
            Cache::forget($key);
        }

        // Clear daily search counts
        for ($i = 0; $i < 30; $i++) {
            $date = now()->subDays($i)->format('Y-m-d');
            Cache::forget('search_count_' . $date);
        }
    }

    /**
     * Export analytics data
     */
    public static function exportAnalytics(): array
    {
        return [
            'popular_searches' => Cache::get('popular_searches', []),
            'zero_results_searches' => Cache::get('zero_results_searches', []),
            'average_results_per_search' => Cache::get('avg_results_per_search', 0.0),
            'total_searches_tracked' => Cache::get('avg_results_count', 0),
            'exported_at' => now()->toISOString(),
        ];
    }
}
