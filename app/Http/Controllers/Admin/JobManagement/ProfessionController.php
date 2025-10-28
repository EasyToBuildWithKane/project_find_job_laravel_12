<?php

namespace App\Http\Controllers\Admin\JobManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\JobManagement\ProfessionRequest;
use App\Services\ProfessionService;
use Exception;
use Log;

class ProfessionController extends Controller
{
    protected $professionService;

    public function __construct(ProfessionService $professionService)
    {
        $this->professionService = $professionService;
    }

    public function index()
    {
        $professions = $this->professionService->getAllProfessions();
        return view('admin.job_management.professions.index', compact('professions'));
    }

    public function store(ProfessionRequest $request)
    {
        try {
            $this->professionService->createProfession($request->validated());
            return redirect()->route('admin.professions.index')->with('success', 'Profession created successfully.');
        } catch (Exception $e) {
            Log::error('Lỗi tạo nghề nghiệp: '.$e->getMessage());
            return back()->withErrors(['error' => 'Không thể tạo nghề nghiệp.']);
        }
    }

    public function update(ProfessionRequest $request, $id)
    {
        try {
            $this->professionService->updateProfession($id, $request->validated());
            return redirect()->route('admin.professions.index')->with('success', 'Profession updated successfully.');
        } catch (Exception $e) {
            Log::error('Lỗi cập nhật nghề nghiệp: '.$e->getMessage());
            return back()->withErrors(['error' => 'Không thể cập nhật nghề nghiệp.']);
        }
    }

    public function destroy($id)
    {
        try {
            $this->professionService->deleteProfession($id);
            return redirect()->route('admin.professions.index')->with('success', 'Profession deleted successfully.');
        } catch (Exception $e) {
            Log::error('Lỗi xóa nghề nghiệp: '.$e->getMessage());
            return back()->withErrors(['error' => 'Không thể xóa nghề nghiệp.']);
        }
    }
}


