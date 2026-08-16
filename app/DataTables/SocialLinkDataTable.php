<?php

namespace App\DataTables;

use App\Models\SocialLink;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class SocialLinkDataTable extends DataTable {
    /**
     * Build the DataTable class.
     */
    public function dataTable( QueryBuilder $query ): EloquentDataTable {
        return ( new EloquentDataTable( $query ) )
            ->editColumn( 'icon', fn( $row ) => '<span class="'. $row->icon .'" title="'. $row->icon .'"></span>' )
            ->editColumn( 'status', fn( $row ) => $row->status?->badge() )
            ->editColumn( 'action', fn( $row ) => view( 'socialLink.action', compact( 'row' ) ) )
            ->rawColumns( ['status', 'action','icon'] )
            ->setRowId( 'id' );
    }

    /**
     * Get the query source of dataTable.
     */
    public function query( SocialLink $model ): QueryBuilder {
        return $model->newQuery();
    }

    /**
     * Optional method for HTML builder.
     */
    public function html(): HtmlBuilder {
        return $this->builder()
            ->setTableId( 'socialLinks-table' )
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
     * Get columns definition.
     */
    public function getColumns(): array {
        return [
            Column::computed( 'action' )
                ->exportable( false )
                ->printable( false )
                ->width( 80 )
                ->addClass( 'text-center' ),
            Column::make( 'icon' )->searchable( false ),
            Column::make( 'link' ),
            Column::make( 'serial_no' )->searchable( false ),
            Column::make( 'status' )->searchable( false ),
        ];
    }

    /**
     * Filename for export.
     */
    protected function filename(): string {
        return 'SocialLinks_' . date( 'YmdHis' );
    }
}
