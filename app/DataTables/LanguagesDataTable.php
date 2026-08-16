<?php

namespace App\DataTables;

use App\Models\Language;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class LanguagesDataTable extends DataTable {
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable( QueryBuilder $query ): EloquentDataTable {
        return ( new EloquentDataTable( $query ) )
            ->editColumn( 'action', fn( $row ) => view( 'language.action', compact( 'row' ) ) )
            ->editColumn( 'status', fn( $query ) => $query->status?->badge() )
            ->editColumn( 'is_default', fn( $query ) => $query->is_default?->badge())
            ->editColumn( 'direction', fn( $query ) => strtoupper($query->direction))
            ->rawColumns( ['action', 'status', 'is_default'] )
            ->setRowId( 'id' );
    }

    /**
     * Get the query source of dataTable.
     */
    public function query( Language $model ): QueryBuilder {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder {
        return $this->builder()
            ->setTableId( 'languages-table' )
            ->columns( $this->getColumns() )
            ->minifiedAjax()
            ->orderBy( 1 )
            ->selectStyleSingle()
            ->buttons( [
                Button::make( 'excel' ),
                Button::make( 'csv' ),
                Button::make( 'pdf' ),
                Button::make( 'print' ),
                Button::make( 'reset' ),
                Button::make( 'reload' ),
            ] );
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array {
        return [
            Column::computed( 'action' )
                ->exportable( false )
                ->printable( false )
                ->width( 60 )
                ->addClass( 'text-center' ),
            Column::make( 'name' ),
            Column::make( 'code' ),
            Column::make( 'direction' ),
            Column::make( 'is_default' )->title( 'Default' ),
            Column::make( 'status' )->searchable( false ),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string {
        return 'Languages_' . date( 'YmdHis' );
    }
}
