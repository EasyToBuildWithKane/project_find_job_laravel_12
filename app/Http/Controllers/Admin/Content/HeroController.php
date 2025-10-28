<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\HeroRequest;
use App\Services\HeroService;
use Exception;
use Log;

class HeroController extends Controller
{
    protected $heroService;

    public function __construct(HeroService $heroService)
    {
        $this->heroService = $heroService;
    }

    public function index()
    {
        $heroes = $this->heroService->getAllHeroes();
        return view('admin.content.hero.index', compact('heroes'));
    }

    public function store(HeroRequest $request)
    {
        try {
            $this->heroService->createHero($request->validated());
            return redirect()->route('admin.content.hero.index')->with('success', 'Hero created successfully.');
        } catch (Exception $e) {
            Log::error('Error creating hero: '.$e->getMessage());
            return back()->withErrors(['error' => 'Failed to create hero.']);
        }
    }

    public function update(HeroRequest $request, $id)
    {
        try {
            $this->heroService->updateHero($id, $request->validated());
            return redirect()->route('admin.content.hero.index')->with('success', 'Hero updated successfully.');
        } catch (Exception $e) {
            Log::error('Error updating hero: '.$e->getMessage());
            return back()->withErrors(['error' => 'Failed to update hero.']);
        }
    }

    public function destroy($id)
    {
        try {
            $this->heroService->deleteHero($id);
            return redirect()->route('admin.content.hero.index')->with('success', 'Hero deleted successfully.');
        } catch (Exception $e) {
            Log::error('Error deleting hero: '.$e->getMessage());
            return back()->withErrors(['error' => 'Failed to delete hero.']);
        }
    }
}






