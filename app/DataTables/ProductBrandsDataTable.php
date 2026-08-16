<?php

namespace App\DataTables;

use App\Models\ProductBrand;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ProductBrandsDataTable extends DataTable {
    public function dataTable(QueryBuilder $query): EloquentDataTable {
        return (new EloquentDataTable($query))
            ->addColumn('language', fn($row) => @$row->language->name)
            ->editColumn('action', fn($row) => view('productBrand.action', compact('row')))
            ->editColumn('status', fn($query) => $query->status?->badge())
            ->rawColumns(['action', 'status'])
            ->setRowId('id');
    }

    public function query(ProductBrand $model): QueryBuilder {
        return $model->newQuery();
    }

    public function html(): HtmlBuilder {
        return $this->builder()
            ->setTableId('productBrands-table')
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

    public function getColumns(): array {
        return [
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
            Column::make('language'),
            Column::make('name'),
            Column::make('slug'),
            Column::make('status')->searchable(false),
        ];
    }

    protected function filename(): string {
        return 'ProductBrands_' . date('YmdHis');
    }
}
