<?php

namespace App\Http\Controllers\Admin\JobManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\JobManagement\StateRequest;
use App\Services\StateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Throwable;

class StateController extends Controller
{
    protected $stateService;

    public function __construct(StateService $stateService)
    {
        $this->stateService = $stateService;
    }

    public function index(Request $request)
{
    if ($request->ajax()) {
        $states = $this->stateService->getAllStates();

        return DataTables::of($states)
            ->addColumn('country_name', function ($row) {
                // Nếu state có country -> trả tên, không thì trả '—'
                return $row->country?->name ?? '—';
            })
            ->addColumn('action', fn($row) => view('admin.job_management.states.partials.action', compact('row'))->render())
            ->rawColumns(['action'])
            ->make(true);
    }

    return view('admin.job_management.states.index');
}

    public function create()
    {
        return view('admin.job_management.states.create');
    }

    public function store(StateRequest $request)
    {
        return $this->tryCatchResponse(function () use ($request) {
            $this->stateService->createState($request->validated());
            return redirect()
                ->route('admin.states.index')
                ->with('success', 'State created successfully.');
        }, 'Error creating state', $request->all());
    }

    public function edit(int $id)
    {
        try {
            $state = $this->stateService->getStateById($id);

            return view('admin.job_management.states.edit', compact('state'));
        } catch (Throwable $e) {
            Log::error('State edit failed', ['id' => $id, 'error' => $e->getMessage()]);
            return redirect()
                ->route('admin.states.index')
                ->with('error', 'Không tìm thấy bản ghi hoặc có lỗi xảy ra.');
        }
    }

    public function update(StateRequest $request, int $id)
    {
        return $this->tryCatchResponse(function () use ($request, $id) {
            $this->stateService->updateState($id, $request->validated());
            return redirect()
                ->route('admin.states.index')
                ->with('success', 'State updated successfully.');
        }, 'Error updating state', ['id' => $id]);
    }

    public function destroy(int $id)
    {
        return $this->tryCatchResponse(function () use ($id) {
            $this->stateService->deleteState($id);
            return redirect()
                ->route('admin.states.index')
                ->with('success', 'State deleted successfully.');
        }, 'Error deleting state', ['id' => $id]);
    }

    /**
     * Common Try-Catch Handler for Clean Controller
     */
    private function tryCatchResponse(callable $callback, string $logMessage, array $context = [])
    {
        try {
            return $callback();
        } catch (Throwable $e) {
            Log::error($logMessage . ': ' . $e->getMessage(), $context);
            return back()
                ->withInput()
                ->withErrors(['error' => 'Đã xảy ra lỗi, vui lòng thử lại.']);
        }
    }
}


