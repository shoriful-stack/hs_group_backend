<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class SearchService
{
    public function search(string $model, Request $request, array $fields = ['id', 'name'], string $searchField = 'name', int $limit = 20)
    {
        return $model::query()
            ->when($request->q, fn(Builder $query) => $query->where($searchField, 'LIKE', '%' . $request->q . '%'))
            ->when($request->status !== null, fn(Builder $query) => $query->where('status', $request->status))
            ->select($fields)
            ->limit($limit)
            ->get();
    }
}
