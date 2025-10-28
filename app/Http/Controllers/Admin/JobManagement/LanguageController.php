<?php

namespace App\Http\Controllers\Admin\JobManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\JobManagement\LanguageRequest;
use App\Services\LanguageService;
use Exception;
use Log;

class LanguageController extends Controller
{
    protected $languageService;

    public function __construct(LanguageService $languageService)
    {
        $this->languageService = $languageService;
    }

    public function index()
    {
        $languages = $this->languageService->getAllLanguages();
        return view('admin.job_management.languages.index', compact('languages'));
    }

    public function store(LanguageRequest $request)
    {
        try {
            $this->languageService->createLanguage($request->validated());
            return redirect()->route('admin.languages.index')->with('success', 'Language created successfully.');
        } catch (Exception $e) {
            Log::error('Lỗi tạo ngôn ngữ: '.$e->getMessage());
            return back()->withErrors(['error' => 'Không thể tạo ngôn ngữ.']);
        }
    }

    public function update(LanguageRequest $request, $id)
    {
        try {
            $this->languageService->updateLanguage($id, $request->validated());
            return redirect()->route('admin.languages.index')->with('success', 'Language updated successfully.');
        } catch (Exception $e) {
            Log::error('Lỗi cập nhật ngôn ngữ: '.$e->getMessage());
            return back()->withErrors(['error' => 'Không thể cập nhật ngôn ngữ.']);
        }
    }

    public function destroy($id)
    {
        try {
            $this->languageService->deleteLanguage($id);
            return redirect()->route('admin.languages.index')->with('success', 'Language deleted successfully.');
        } catch (Exception $e) {
            Log::error('Lỗi xóa ngôn ngữ: '.$e->getMessage());
            return back()->withErrors(['error' => 'Không thể xóa ngôn ngữ.']);
        }
    }
}


