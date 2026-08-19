<?php

namespace App\DataTables;

use App\Models\CareerJob;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class CareerJobDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('action', fn ($row) => view('careerJob.action', compact('row')))
            ->editColumn('posted_at', fn ($row) => optional($row->posted_at)->format('M j, Y'))
            ->editColumn('featured', fn ($row) => $row->featured
                ? '<span class="badge bg-info">Featured</span>'
                : '<span class="badge bg-secondary">No</span>')
            ->editColumn('status', fn ($query) => $query->status?->badge())
            ->rawColumns(['action', 'status', 'featured'])
            ->setRowId('id');
    }

    public function query(CareerJob $model): QueryBuilder
    {
        return $model->newQuery();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('career-jobs-table')
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
            Column::computed('action')->exportable(false)->printable(false)->width(60)->addClass('text-center'),
            Column::make('title'),
            Column::make('department'),
            Column::make('type'),
            Column::make('location'),
            Column::make('posted_at')->title('Posted'),
            Column::make('featured'),
            Column::make('serial_no')->title('Serial'),
            Column::make('status'),
        ];
    }

    protected function filename(): string
    {
        return 'CareerJob_' . date('YmdHis');
    }
}
