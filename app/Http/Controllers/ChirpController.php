<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Response;

use App\Http\Requests\Chirp\StoreChirpRequest;
use App\Models\Chirp;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\RedirectResponse;

class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('chirps.index', [
            'chirps' => Chirp::with('user')->latest()->paginate(5)
        ]);
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
    public function store(StoreChirpRequest $request): RedirectResponse
    {
        // $validated = $request->validate([
        //     'message' => 'required|string|max:255',
        // ]);

        $validated = $request->validated();
        $request->user()->chirps()->create($validated);

        $message = __('New chirp posted successfully!');
        return redirect(route('chirps.index'))->with('success', $message);
    }

    /**
     * Display the specified resource.
     */
    public function show(Chirp $chirp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chirp $chirp): View
    {
        Gate::authorize('update', $chirp);

        return view('chirps.edit', [
            'chirp' => $chirp
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chirp $chirp): RedirectResponse
    {
        Gate::authorize('update', $chirp);

        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);

        $chirp->update($validated);

        $message = __('Chirp updated successfully!');
        return redirect(route('chirps.index'))->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp): RedirectResponse
    {
        Gate::authorize('delete', $chirp);

        $chirp->delete();

        $message = __('Chirp deleted successfully!');
        return redirect(route('chirps.index'))->with('success', $message);
    }
}
