<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\CounterRequest;
use App\Services\CounterService;
use Exception;
use Log;

class CounterController extends Controller
{
    protected $counterService;

    public function __construct(CounterService $counterService)
    {
        $this->counterService = $counterService;
    }

    public function index()
    {
        $counters = $this->counterService->getAllCounters();
        return view('admin.content.counter.index', compact('counters'));
    }

    public function store(CounterRequest $request)
    {
        try {
            $this->counterService->createCounter($request->validated());
            return redirect()->route('admin.content.counter.index')->with('success', 'Counter created successfully.');
        } catch (Exception $e) {
            Log::error('Error creating counter: '.$e->getMessage());
            return back()->withErrors(['error' => 'Failed to create counter.']);
        }
    }

    public function update(CounterRequest $request, $id)
    {
        try {
            $this->counterService->updateCounter($id, $request->validated());
            return redirect()->route('admin.content.counter.index')->with('success', 'Counter updated successfully.');
        } catch (Exception $e) {
            Log::error('Error updating counter: '.$e->getMessage());
            return back()->withErrors(['error' => 'Failed to update counter.']);
        }
    }

    public function destroy($id)
    {
        try {
            $this->counterService->deleteCounter($id);
            return redirect()->route('admin.content.counter.index')->with('success', 'Counter deleted successfully.');
        } catch (Exception $e) {
            Log::error('Error deleting counter: '.$e->getMessage());
            return back()->withErrors(['error' => 'Failed to delete counter.']);
        }
    }
}






