<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\BaseController;
use App\Http\Resources\CareerJobResource;
use App\Models\CareerJob;
use Illuminate\Support\Facades\Cache;

class CareerController extends BaseController
{
    public function index()
    {
        $payload = Cache::remember('career_jobs', 86400, function () {
            $jobs = CareerJob::published()->get();

            return [
                'jobs'         => CareerJobResource::collection($jobs)->resolve(),
                'departments'  => $jobs->pluck('department')->filter()->unique()->values()->all(),
            ];
        });

        return $this->sendResponse($payload, 'Career jobs retrieved successfully.');
    }

    public function show($slug)
    {
        $job = CareerJob::active()->where('slug', $slug)->first();

        if (!$job) {
            return $this->sendError('Career job not found');
        }

        $postedAt = $job->posted_at;

        $prev = CareerJob::active()
            ->where(function ($q) use ($postedAt, $job) {
                $q->where('posted_at', '>', $postedAt)
                    ->orWhere(function ($inner) use ($postedAt, $job) {
                        $inner->where('posted_at', $postedAt)->where('id', '>', $job->id);
                    });
            })
            ->orderBy('posted_at')
            ->orderBy('id')
            ->first(['id', 'title', 'slug', 'department', 'location', 'type', 'experience', 'posted_at', 'summary', 'featured']);

        $next = CareerJob::active()
            ->where(function ($q) use ($postedAt, $job) {
                $q->where('posted_at', '<', $postedAt)
                    ->orWhere(function ($inner) use ($postedAt, $job) {
                        $inner->where('posted_at', $postedAt)->where('id', '<', $job->id);
                    });
            })
            ->orderByDesc('posted_at')
            ->orderByDesc('id')
            ->first(['id', 'title', 'slug', 'department', 'location', 'type', 'experience', 'posted_at', 'summary', 'featured']);

        $related = CareerJob::active()
            ->where('id', '!=', $job->id)
            ->when($job->department, fn ($q) => $q->orderByRaw('CASE WHEN department = ? THEN 0 ELSE 1 END', [$job->department]))
            ->orderByDesc('posted_at')
            ->limit(3)
            ->get(['id', 'title', 'slug', 'department', 'location', 'type', 'experience', 'posted_at', 'summary', 'featured']);

        return $this->sendResponse([
            'job'     => (new CareerJobResource($job))->resolve(),
            'related' => CareerJobResource::collection($related)->resolve(),
            'prev'    => $prev ? (new CareerJobResource($prev))->resolve() : null,
            'next'    => $next ? (new CareerJobResource($next))->resolve() : null,
        ], 'Career job retrieved successfully.');
    }
}
