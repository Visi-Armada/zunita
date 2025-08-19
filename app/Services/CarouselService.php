<?php

namespace App\Services;

use App\Models\Carousel;
use Illuminate\Support\Facades\Cache;

class CarouselService
{
    /**
     * Get active carousel items for display
     */
    public function getActiveCarousels(int $limit = 6): \Illuminate\Database\Eloquent\Collection
    {
        return Cache::remember("active_carousels_{$limit}", 300, function () use ($limit) {
            return Carousel::active()
                ->ordered()
                ->take($limit)
                ->get();
        });
    }

    /**
     * Get carousel by ID
     */
    public function getCarouselById(int $id): ?Carousel
    {
        return Carousel::find($id);
    }

    /**
     * Create a new carousel item
     */
    public function createCarousel(array $data): Carousel
    {
        $carousel = Carousel::create($data);
        $this->clearCache();
        return $carousel;
    }

    /**
     * Update carousel item
     */
    public function updateCarousel(int $id, array $data): bool
    {
        $carousel = Carousel::find($id);
        if (!$carousel) {
            return false;
        }

        $carousel->update($data);
        $this->clearCache();
        return true;
    }

    /**
     * Delete carousel item
     */
    public function deleteCarousel(int $id): bool
    {
        $carousel = Carousel::find($id);
        if (!$carousel) {
            return false;
        }

        $carousel->delete();
        $this->clearCache();
        return true;
    }

    /**
     * Toggle carousel status
     */
    public function toggleCarouselStatus(int $id): bool
    {
        $carousel = Carousel::find($id);
        if (!$carousel) {
            return false;
        }

        $carousel->update(['is_active' => !$carousel->is_active]);
        $this->clearCache();
        return true;
    }

    /**
     * Reorder carousel items
     */
    public function reorderCarousels(array $orderData): bool
    {
        foreach ($orderData as $id => $order) {
            Carousel::where('id', $id)->update(['sort_order' => $order]);
        }
        
        $this->clearCache();
        return true;
    }

    /**
     * Get carousel statistics
     */
    public function getCarouselStats(): array
    {
        return Cache::remember('carousel_stats', 300, function () {
            return [
                'total' => Carousel::count(),
                'active' => Carousel::where('is_active', true)->count(),
                'inactive' => Carousel::where('is_active', false)->count(),
                'with_images' => Carousel::whereNotNull('image')->count(),
                'with_links' => Carousel::whereNotNull('link_url')->count(),
            ];
        });
    }

    /**
     * Clear carousel cache
     */
    public function clearCache(): void
    {
        Cache::forget('active_carousels_6');
        Cache::forget('carousel_stats');
    }

    /**
     * Validate carousel data
     */
    public function validateCarouselData(array $data): array
    {
        $errors = [];

        if (empty($data['title'])) {
            $errors['title'] = 'Title is required';
        }

        if (empty($data['image'])) {
            $errors['image'] = 'Image is required';
        }

        if (!empty($data['link_url']) && !filter_var($data['link_url'], FILTER_VALIDATE_URL)) {
            $errors['link_url'] = 'Link URL must be a valid URL';
        }

        return $errors;
    }
}
