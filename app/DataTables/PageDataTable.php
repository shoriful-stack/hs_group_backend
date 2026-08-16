<?php

namespace App\DataTables;

use App\Models\Page;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PageDataTable extends DataTable {
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable( QueryBuilder $query ): EloquentDataTable {
        return ( new EloquentDataTable( $query ) )
            ->addColumn( 'language', fn( $row ) => @$row->language->name )
            ->editColumn( 'main_image', fn( $row ) => view( 'page.image', ['row' => $row, 'type' => 'main'] ) )
            ->editColumn( 'sub_image', fn( $row ) => view( 'page.image', ['row' => $row, 'type' => 'sub'] ) )
            ->editColumn( 'action', fn( $row ) => view( 'page.action', compact( 'row' ) ) )
            ->editColumn( 'status', fn( $query ) => $query->status?->badge() )
            ->rawColumns( ['action', 'status'] )
            ->setRowId( 'id' );
    }

    /**
     * Get the query source of dataTable.
     */
    public function query( Page $model ): QueryBuilder {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder {
        return $this->builder()
            ->setTableId( 'page-table' )
            ->columns( $this->getColumns() )
            ->minifiedAjax()
        //->dom('Bfrtip')
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
            Column::make( 'language' ),
            Column::make( 'main_image' ),
            Column::make( 'sub_image' ),
            Column::make( 'title' ),
            Column::make( 'serial_no' ),
            Column::make( 'status' ),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string {
        return 'Page_' . date( 'YmdHis' );
    }
}
