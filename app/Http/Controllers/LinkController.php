<?php

namespace App\Http\Controllers;

use App\Data\LinkData;
use App\Http\Requests\LinkRequest;
use App\Models\Link;
use App\Services\LinkService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class LinkController extends Controller
{
    use AuthorizesRequests;

    public function __construct(
        protected LinkService $linkService,
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $links = $this->linkService->getAllForUser(Auth::user()->id);
        return view('links.index', compact('links'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LinkRequest $request)
    {
        $this->linkService->create(
            Auth::user()->id, 
            $request->validated('original_url')
        );
        return redirect()->intended(route('links.index', absolute: false));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LinkRequest $request, Link $link)
    {
        $this->authorize('update', $link);

        $data = LinkData::from([
            ...$request->validated(),
            'id' => $link->id,
            'user_id' => $link->user_id
        ]);

        $this->linkService->update($data);

        return redirect()->route('links.index')->with('success', 'Lien mis à jour !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Link $link)
    {
        $this->authorize('delete', $link);
        $data = LinkData::fromModel($link);
        $this->linkService->delete($data);

        return redirect()->route('links.index')->with('success', 'Lien supprimé avec succès');
    }
}
