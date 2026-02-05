<?php

namespace App\Http\Controllers;

use App\Data\LinkData;
use App\Models\Link;
use App\Repositories\LinkRepositoryInterface;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LinkController extends Controller
{
    use AuthorizesRequests;

    public function __construct(
        protected LinkRepositoryInterface $linkRepository
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $links = $this->linkRepository->getAllForUser(Auth::user()->id);
        return view('links.index', compact('links'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LinkData $data)
    {
        $this->linkRepository->create(Auth::user()->id, $data);
        return back()->with('success', 'URL raccourcie !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Link $link)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Link $link)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Link $link)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LinkData $data)
    {
        $this->authorize('delete', $data);

        $this->linkRepository->delete($data);
        return back()->with('success', 'Lien supprimé.');
    }
}
