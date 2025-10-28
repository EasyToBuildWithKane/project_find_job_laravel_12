<?php

namespace App\Http\Controllers\Admin\Pricing;

use App\Http\Controllers\Controller;
use App\Services\PlanService;
use Illuminate\Http\Request;
use App\Models\PricingPlan;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;
use Throwable;

class PricingPlanController extends Controller
{
    protected PlanService $planService;

    public function __construct(PlanService $planService)
    {
        $this->planService = $planService;
    }

    public function index()
    {
        if (request()->ajax()) {
            $query = $this->planService->getAllPlans();

            return DataTables::of($query)
                ->editColumn('is_public', function ($row) {
                    return $row->is_public
                        ? '<span class="badge bg-success">Hiển thị</span>'
                        : '<span class="badge bg-secondary">Ẩn</span>';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('admin.pricing.pricing_plan.edit', $row->id);
                    $deleteUrl = route('admin.pricing.pricing_plan.destroy', $row->id);

                    return '
                        <a href="' . $editUrl . '" class="btn btn-sm btn-primary me-2">
                            <i class="fas fa-edit"></i> Sửa
                        </a>
                        <form action="' . $deleteUrl . '" method="POST" style="display:inline-block"
                              onsubmit="return confirm(\'Bạn có chắc chắn muốn xóa gói này không?\')">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i> Xóa
                            </button>
                        </form>
                    ';
                })
                ->rawColumns(['is_public', 'action'])
                ->make(true);
        }

        return view('admin.pricing.pricing_plan.index');
    }

    public function create()
    {
        return view('admin.pricing.pricing_plan.create');
    }

    public function edit($id)
    {
        try {
            $plan = $this->planService->getById($id);
            if (!$plan) {
                throw new \Exception('Plan not found');
            }
            return view('admin.pricing.pricing_plan.edit', compact('plan'));
        } catch (Throwable $e) {
            Log::error('Pricing Plan edit error', [
                'id' => $id,
                'error' => $e->getMessage(),
            ]);

            return redirect()
                ->route('admin.pricing.pricing_plan.index')
                ->with('error', 'Không tìm thấy gói hoặc có lỗi xảy ra.');
        }
    }

    public function destroy($id)
    {
        try {
            $this->planService->deletePlan($id);

            return back()->with('success', 'Đã xóa gói thành công.');
        } catch (Throwable $e) {
            Log::error('Delete Pricing Plan error', [
                'id' => $id,
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', 'Không thể xóa gói này.');
        }
    }
}
