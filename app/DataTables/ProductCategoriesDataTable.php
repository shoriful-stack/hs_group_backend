<?php

namespace App\DataTables;

use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ProductCategoriesDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('action', fn($row) => view('productCategory.action', compact('row')))
            ->editColumn('status', fn($query) => $query->status?->badge())
            ->rawColumns(['action', 'status'])
            ->setRowId('id');
    }

    public function query(ProductCategory $model): QueryBuilder
    {
        return $model
            ->newQuery();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('productCategories-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload'),
            ]);
    }

    public function getColumns(): array
    {
        return [
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
            Column::make('name'),
            Column::make('slug'),
            Column::make('status')->searchable(false),
        ];
    }

    protected function filename(): string
    {
        return 'ProductCategories_' . date('YmdHis');
    }
}
