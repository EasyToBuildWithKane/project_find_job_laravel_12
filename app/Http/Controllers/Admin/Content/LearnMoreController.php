<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\LearnMoreRequest;
use App\Services\LearnMoreService;
use Exception;
use Log;

class LearnMoreController extends Controller
{
    protected $learnMoreService;

    public function __construct(LearnMoreService $learnMoreService)
    {
        $this->learnMoreService = $learnMoreService;
    }

    public function index()
    {
        $items = $this->learnMoreService->getAllLearnMores();
        return view('admin.content.learn_more.index', compact('items'));
    }

    public function store(LearnMoreRequest $request)
    {
        try {
            $this->learnMoreService->createLearnMore($request->validated());
            return redirect()->route('admin.content.learn_more.index')->with('success', 'Learn more created successfully.');
        } catch (Exception $e) {
            Log::error('Error creating learn more: '.$e->getMessage());
            return back()->withErrors(['error' => 'Failed to create learn more.']);
        }
    }

    public function update(LearnMoreRequest $request, $id)
    {
        try {
            $this->learnMoreService->updateLearnMore($id, $request->validated());
            return redirect()->route('admin.content.learn_more.index')->with('success', 'Learn more updated successfully.');
        } catch (Exception $e) {
            Log::error('Error updating learn more: '.$e->getMessage());
            return back()->withErrors(['error' => 'Failed to update learn more.']);
        }
    }

    public function destroy($id)
    {
        try {
            $this->learnMoreService->deleteLearnMore($id);
            return redirect()->route('admin.content.learn_more.index')->with('success', 'Learn more deleted successfully.');
        } catch (Exception $e) {
            Log::error('Error deleting learn more: '.$e->getMessage());
            return back()->withErrors(['error' => 'Failed to delete learn more.']);
        }
    }
}






