<?php

namespace App\Http\Controllers\Admin\CompanyAbout;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CompanyAbout\WhyChooseUsRequest;
use App\Models\WhyChooseUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

class WhyChooseUsController extends Controller
{
    /**
     * Trang index + DataTables
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = WhyChooseUs::query()->orderBy('id');

            return DataTables::of($query)
                ->addColumn('action', function ($row) {
                    $editUrl = route('admin.company_about.why_choose_us.edit', $row->id);
                    return sprintf(
                        '<a href="%s" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Sửa</a>',
                        e($editUrl)
                    );
                })
                ->editColumn('title', fn($row) => e($row->title))
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.company_about.why_choose_us.index');
    }

    /**
     * Trang edit
     */
    public function edit(int $id)
    {
        try {
            $item = WhyChooseUs::findOrFail($id);
            return view('admin.company_about.why_choose_us.edit', compact('item'));
        } catch (Throwable $e) {
            Log::error('WhyChooseUs edit error', [
                'id' => $id,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return redirect()
                ->route('admin.company_about.why_choose_us.index')
                ->with('error', 'Không tìm thấy dữ liệu hoặc có lỗi xảy ra.');
        }
    }

    /**
     * Cập nhật thông tin WhyChooseUs
     */
    public function update(WhyChooseUsRequest $request, int $id)
    {
        try {
            $item = WhyChooseUs::findOrFail($id);

            DB::transaction(function () use ($item, $request) {
                $item->update($request->validated());
            });

            return redirect()
                ->route('admin.company_about.why_choose_us.index')
                ->with('success', 'Cập nhật thông tin thành công.');
        } catch (Throwable $e) {
            Log::error('WhyChooseUs update error', [
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra, vui lòng thử lại.');
        }
    }
}
