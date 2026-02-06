<?php

namespace App\Http\Controllers;

use App\Services\LinkService;

class RedirectController extends Controller
{
    public function __construct(
        public LinkService $linkService,
    ) {}


    public function handle(string $shortCode)
    {
        $linkData = $this->linkService->findByCode($shortCode);

        if (!$linkData || $linkData->deleted_at !== null) {
            return view('links.invalid');
        }

        // Update click counts and last_used
        $this->linkService->trackClick($linkData->id);

        return redirect()->away($linkData->original_url);
    }
}
