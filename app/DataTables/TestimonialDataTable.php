<?php

namespace App\DataTables;

use App\Models\Testimonial;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class TestimonialDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('image', fn($row) => $row->image ? view('testimonial.thumb', compact('row')) : '')
            ->editColumn('action', fn($row) => view('testimonial.action', compact('row')))
            ->editColumn('status', fn($query) => $query->status?->badge())
            ->rawColumns(['action', 'status'])
            ->setRowId('id');
    }

    public function query(Testimonial $model): QueryBuilder
    {
        return $model->newQuery();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('testimonial-table')
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
                Button::make('reload')
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
            Column::make('role'),
            Column::make('image'),
            Column::make('quote'),
            Column::make('status'),
        ];
    }

    protected function filename(): string
    {
        return 'Testimonial_' . date('YmdHis');
    }
}
