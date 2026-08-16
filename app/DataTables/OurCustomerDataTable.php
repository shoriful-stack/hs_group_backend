<?php

namespace App\DataTables;

use App\Models\OurCustomer;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class OurCustomerDataTable extends DataTable {
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable( QueryBuilder $query ): EloquentDataTable {
        return ( new EloquentDataTable( $query ) )
            ->editColumn( 'image', fn( $row ) => $row->image ? view( 'ourCustomer.thumb', compact( 'row' ) ) : '' )
            ->editColumn( 'action', fn( $row ) => view( 'ourCustomer.action', compact( 'row' ) ) )
            ->rawColumns( ['action'] )
            ->setRowId( 'id' );
    }

    /**
     * Get the query source of dataTable.
     */
    public function query( OurCustomer $model ): QueryBuilder {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder {
        return $this->builder()
            ->setTableId( 'ourCustomer-table' )
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
            Column::make( 'title' ),
            Column::make( 'content' ),
            Column::make( 'image' ),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string {
        return 'OurCustomer_' . date( 'YmdHis' );
    }
}
