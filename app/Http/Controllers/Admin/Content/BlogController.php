<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use Exception;
use Log;

class BlogController extends Controller
{
    public function index()
    {
        return view('admin.content.blog.index');
    }

    public function store(\App\Http\Requests\Admin\Content\BlogRequest $request)
    {
        try {
            return redirect()->route('admin.content.blog.index')->with('success', 'Blog created successfully.');
        } catch (Exception $e) {
            Log::error('Error creating blog: '.$e->getMessage());
            return back()->withErrors(['error' => 'Failed to create blog.']);
        }
    }

    public function update(\App\Http\Requests\Admin\Content\BlogRequest $request, $id)
    {
        try {
            return redirect()->route('admin.content.blog.index')->with('success', 'Blog updated successfully.');
        } catch (Exception $e) {
            Log::error('Error updating blog: '.$e->getMessage());
            return back()->withErrors(['error' => 'Failed to update blog.']);
        }
    }

    public function destroy($id)
    {
        try {
            return redirect()->route('admin.content.blog.index')->with('success', 'Blog deleted successfully.');
        } catch (Exception $e) {
            Log::error('Error deleting blog: '.$e->getMessage());
            return back()->withErrors(['error' => 'Failed to delete blog.']);
        }
    }
}


