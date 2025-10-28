<?php

namespace App\Http\Controllers\Admin\JobManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\JobManagement\CityRequest;
use App\Services\CityService;
use App\Models\State;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Throwable;

class CityController extends Controller
{
    protected $cityService;

    public function __construct(CityService $cityService)
    {
        $this->cityService = $cityService;
    }

    /**
     * Danh sách thành phố (hiển thị & DataTable AJAX)
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $cities = $this->cityService->getAllCities();

            return DataTables::of($cities)
                ->addColumn('state_name', fn($row) => $row->state->name ?? '—')
                ->addColumn('country_name', fn($row) => $row->country->name ?? '—')
                ->addColumn('actions', fn($row) => view('admin.job_management.cities.partials.action', compact('row'))->render())
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('admin.job_management.cities.index');
    }

    /**
     * Form tạo mới
     */
    public function create()
    {
        $countries = Country::orderBy('name')->get(['id', 'name']);
        return view('admin.job_management.cities.create', compact('countries'));
    }

    /**
     * Lưu thành phố mới
     */
    public function store(CityRequest $request)
    {
        return $this->tryCatchResponse(function () use ($request) {
            $this->cityService->createCity($request->validated());
            return redirect()
                ->route('admin.cities.index')
                ->with('success', 'Thêm thành phố thành công.');
        }, 'Lỗi khi tạo thành phố', $request->all());
    }

    /**
     * Form chỉnh sửa
     */
    public function edit(int $id)
    {
        return $this->tryCatchResponse(function () use ($id) {
            $cityData = $this->cityService->getCityById($id);

            if (!$cityData['status']) {
                return redirect()
                    ->route('admin.cities.index')
                    ->with('error', $cityData['message']);
            }

            $city = $cityData['data'];
            $countries = Country::orderBy('name')->get(['id', 'name']);

            return view('admin.job_management.cities.edit', compact('city', 'countries'));
        }, 'Lỗi khi load form chỉnh sửa', ['id' => $id]);
    }

    /**
     * Cập nhật thành phố
     */
    public function update(CityRequest $request, int $id)
    {
        return $this->tryCatchResponse(function () use ($request, $id) {
            $this->cityService->updateCity($id, $request->validated());
            return redirect()
                ->route('admin.cities.index')
                ->with('success', 'Cập nhật thành phố thành công.');
        }, 'Lỗi khi cập nhật thành phố', ['id' => $id]);
    }

    /**
     * Xóa thành phố
     */
    public function destroy(int $id)
    {
        try {
            $this->cityService->deleteCity($id);

            return response()->json([
                'success' => true,
                'message' => 'Xóa thành phố thành công.'
            ]);
        } catch (Throwable $e) {
            Log::error('Lỗi khi xóa thành phố: ' . $e->getMessage(), ['id' => $id]);
            return response()->json([
                'success' => false,
                'message' => 'Không thể xóa thành phố.'
            ]);
        }
    }

    /**
     * Lấy danh sách state theo country (AJAX)
     */
    public function getStatesByCountry(int $countryId)
    {
        try {
            $states = State::where('country_id', $countryId)
                ->orderBy('name')
                ->get(['id', 'name']);
            return response()->json($states);
        } catch (Throwable $e) {
            Log::error('Lỗi khi lấy state theo country: ' . $e->getMessage(), ['country_id' => $countryId]);
            return response()->json([], 500);
        }
    }

    /**
     * Helper xử lý try-catch gọn gàng
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
