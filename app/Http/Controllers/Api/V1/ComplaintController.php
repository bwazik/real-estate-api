<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\ComplaintStatus;
use App\Http\Requests\Api\V1\StoreComplaintRequest;
use App\Models\Complaint;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ComplaintController extends BaseApiController
{
    /**
     * Store a newly created complaint.
     */
    public function store(StoreComplaintRequest $request): JsonResponse
    {
        return DB::transaction(function () use ($request) {
            $complaint = Complaint::create(array_merge($request->validated(), [
                'uuid' => Str::uuid(),
                'status' => ComplaintStatus::Pending,
            ]));

            return $this->successResponse($complaint, 'تم إرسال الشكوى بنجاح.', 201);
        });
    }

    /**
     * List all complaints.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Complaint::query()->orderBy('created_at', 'desc');

        if ($request->has('status')) {
            $query->where('status', (int) $request->status);
        }

        $complaints = $query->paginate($request->integer('per_page', 15));

        return $this->successResponse($complaints, 'Complaints retrieved successfully.');
    }

    /**
     * Display a single complaint.
     */
    public function show(Complaint $complaint): JsonResponse
    {
        return $this->successResponse($complaint, 'Complaint retrieved successfully.');
    }

    /**
     * Update status.
     */
    public function updateStatus(Request $request, Complaint $complaint): JsonResponse
    {
        $request->validate(['status' => 'required|integer|in:0,1,2']);
        $complaint->update(['status' => ComplaintStatus::from((int) $request->status)]);

        return $this->successResponse($complaint, 'Status updated successfully.');
    }

    /**
     * Mark as read.
     */
    public function markAsRead(Complaint $complaint): JsonResponse
    {
        $complaint->update(['read_at' => now()]);

        return $this->successResponse($complaint, 'Complaint marked as read.');
    }
}
