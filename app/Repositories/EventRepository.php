<?php

namespace App\Repositories;

use App\Models\Event;

class EventRepository
{
    public function getUpcomingEvents(int $limit = 6)
    {
        return Event::where('date', '>=', now()->toDateString())
            ->orderBy('date', 'asc')
            ->limit($limit)
            ->get();
    }

    public function getFeaturedEvents()
    {
        return Event::where('is_featured', true)
            ->where('date', '>=', now()->toDateString())
            ->orderBy('date', 'asc')
            ->get();
    }

    public function findBySlug(string $slug)
    {
        return Event::where('slug', $slug)->firstOrFail();
    }
}
