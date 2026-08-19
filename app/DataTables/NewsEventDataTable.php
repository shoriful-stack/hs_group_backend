<?php

namespace App\DataTables;

use App\Models\NewsEvent;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class NewsEventDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('image', fn($row) => $row->image ? view('newsEvent.thumb', compact('row')) : '')
            ->editColumn('event_date', fn($row) => optional($row->event_date)->format('M j, Y'))
            ->editColumn('timing', function ($row) {
                return $row->isUpcoming()
                    ? '<span class="badge bg-info">Upcoming</span>'
                    : '<span class="badge bg-secondary">Past</span>';
            })
            ->editColumn('action', fn($row) => view('newsEvent.action', compact('row')))
            ->editColumn('status', fn($query) => $query->status?->badge())
            ->rawColumns(['action', 'status', 'image', 'timing'])
            ->setRowId('id');
    }

    public function query(NewsEvent $model): QueryBuilder
    {
        return $model->newQuery();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('news-events-table')
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
            Column::make('image'),
            Column::make('title'),
            Column::make('event_date')->title('Date'),
            Column::make('location'),
            Column::computed('timing')->title('Timing')->searchable(false)->orderable(false),
            Column::make('serial_no')->searchable(false),
            Column::make('status')->searchable(false),
        ];
    }

    protected function filename(): string
    {
        return 'NewsEvent_' . date('YmdHis');
    }
}
