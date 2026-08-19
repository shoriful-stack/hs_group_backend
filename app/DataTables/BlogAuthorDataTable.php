<?php

namespace App\DataTables;

use App\Models\BlogAuthor;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class BlogAuthorDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('photo', fn($row) => $row->photo ? view('blogAuthor.thumb', compact('row')) : '')
            ->editColumn('action', fn($row) => view('blogAuthor.action', compact('row')))
            ->editColumn('status', fn($query) => $query->status?->badge())
            ->rawColumns(['action', 'status', 'photo'])
            ->setRowId('id');
    }

    public function query(BlogAuthor $model): QueryBuilder
    {
        return $model->newQuery();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('blog-authors-table')
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
            Column::make('photo'),
            Column::make('name'),
            Column::make('designation'),
            Column::make('department'),
            Column::make('serial_no')->searchable(false),
            Column::make('status')->searchable(false),
        ];
    }

    protected function filename(): string
    {
        return 'BlogAuthor_' . date('YmdHis');
    }
}
