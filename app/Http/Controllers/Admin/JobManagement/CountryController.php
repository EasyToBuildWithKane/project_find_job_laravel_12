<?php

namespace App\Http\Controllers\Admin\JobManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\JobManagement\CountryRequest;
use App\Services\CountryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Throwable;

class CountryController extends Controller
{
    protected CountryService $countryService;

    public function __construct(CountryService $countryService)
    {
        $this->countryService = $countryService;
    }

    /**
     * Display a listing of countries.
     */
    public function index()
    {
        if (request()->ajax()) {
            $countries = $this->countryService->getAllCountries();

            return DataTables::of($countries)
                ->addColumn('action', fn($row) => view('admin.job_management.countries.partials.action', compact('row'))->render())
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.job_management.countries.index');
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('admin.job_management.countries.create');
    }

    /**
     * Store new country
     */
    public function store(CountryRequest $request)
    {
        return $this->tryCatchResponse(function () use ($request) {
            $this->countryService->createCountry($request->validated());
            return redirect()
                ->route('admin.countries.index')
                ->with('success', 'Country created successfully.');
        }, 'Error creating country', $request->all());
    }

    /**
     * Show edit form
     */
public function edit(int $id)
{
    try {
        $country = $this->countryService->getCountryById($id);

        return view('admin.job_management.countries.edit', compact('country'));
    } catch (Throwable $e) {
        Log::error('Country edit failed', ['id' => $id, 'error' => $e->getMessage()]);
        return redirect()
            ->route('admin.countries.index')
            ->with('error', 'Không tìm thấy bản ghi hoặc có lỗi xảy ra.');
    }
}

    /**
     * Update existing country
     */
    public function update(CountryRequest $request, int $id)
    {
        return $this->tryCatchResponse(function () use ($request, $id) {
            $this->countryService->updateCountry($id, $request->validated());
            return redirect()
                ->route('admin.countries.index')
                ->with('success', 'Country updated successfully.');
        }, 'Error updating country', ['id' => $id]);
    }

    /**
     * Delete country
     */
    public function destroy(int $id)
    {
        return $this->tryCatchResponse(function () use ($id) {
            $this->countryService->deleteCountry($id);
            return redirect()
                ->route('admin.countries.index')
                ->with('success', 'Country deleted successfully.');
        }, 'Error deleting country', ['id' => $id]);
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
