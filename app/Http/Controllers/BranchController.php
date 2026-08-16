<?php

namespace App\Http\Controllers;

use App\CustomClass\Helper;
use App\CustomClass\ReturnMessage;
use App\DataTables\BranchesDataTable;
use App\Enums\Status;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Enum;

class BranchController extends Controller {
    public function switch( Request $request ) {
        $branch = Branch::findOrFail( $request->branch_id );

        session( [
            'branch_id'   => $branch->id,
            'branch_name' => $branch->name,
        ] );

        User::query()->where('id',Auth::id())->update([
            'branch_id'=>$branch->id
        ]);

        return response()->json( [
            'status'  => 'success',
            'message' => 'Branch switched to ' . $branch->name,
        ] );
    }

    public function index( BranchesDataTable $dataTable ) {
        return $dataTable->render( 'branch.index ' );
    }

    public function create() {
        return view( 'branch.create' );
    }

    public function store( Request $request ) {
        try {
            DB::beginTransaction();

            Validator::make( $request->all(), [
                'name'    => 'required|string|unique:branches,name',
                'image'   => 'required|max:1024|mimes:png,jpeg,jpg',
                'sub_image'   => 'nullable|max:1024|mimes:png,jpeg,jpg',
                'content' => 'nullable|string',
                'domain'  => 'nullable|string',
                'serial'  => 'required|string',
            ] )->validate();
            $image = '';
            $sub_image = '';
            if ( $request->hasFile( 'image' ) ) {
                $image = Helper::imageUpload(
                    $request->file( 'image' ),
                    'branch_' . uniqid(),
                    'branch',
                );
            }
            if ( $request->hasFile( 'sub_image' ) ) {
                $sub_image = Helper::imageUpload(
                    $request->file( 'sub_image' ),
                    'branch_' . uniqid(),
                    'branch',
                );
            }

            $branch = new Branch();
            $branch->name = $request->name;
            $branch->image = $image;
            $branch->sub_image = $sub_image ?? 'N/A';
            $branch->content = $request->content;
            $branch->domain = $request->domain;
            $branch->serial = $request->serial;
            $branch->is_default = $request->is_default;
            $branch->save();
            Cache::forget('branches');

            DB::commit();
            return ReturnMessage::insertSuccess();
        } catch ( QueryException $exp ) {
            DB::rollBack();
            return ReturnMessage::customMessage( 'error', $exp->getMessage() );
        }
    }

    public function edit( Branch $branch ) {
        return view( 'branch.edit', compact( 'branch' ) );
    }

    public function update( Request $request, Branch $branch ) {
        try {
            DB::beginTransaction();

            Validator::make( $request->all(), [
                'name'             => 'required|string|unique:branches,name,' . $branch->id,
                'image'            => 'nullable|max:1024|mimes:png,jpeg,jpg',
                'sub_image'        => 'nullable|max:1024|mimes:png,jpeg,jpg',
                'content'          => 'nullable|string',
                'domain'           => 'nullable|string|unique:branches,domain,' . $branch->id,
                'serial'           => 'required|string|unique:branches,serial,' . $branch->id,
                'is_land_business' => 'nullable|numeric',
                'status'           => new Enum( Status::class ),
            ] )->validate();
            $image = $branch->image;
            if ( $request->hasFile( 'image' ) ) {
                $image = Helper::imageUpload(
                    $request->file( 'image' ),
                    'branch_' . uniqid(),
                    'branch',
                    $branch->image
                );
            }
            $sub_image = $branch->sub_image;
            if ( $request->hasFile( 'sub_image' ) ) {
                $sub_image = Helper::imageUpload(
                    $request->file( 'sub_image' ),
                    'branch_' . uniqid(),
                    'branch',
                    $branch->sub_image
                );
            }

            $branch->name = $request->name;
            $branch->image = $image;
            $branch->sub_image = $sub_image ?? 'N/A';
            $branch->content = $request->content;
            $branch->domain = $request->domain;
            $branch->serial = $request->serial;
            $branch->is_default = $request->is_default;
            $branch->status = $request->status;
            $branch->save();

            Cache::forget('branches');

            DB::commit();
            return ReturnMessage::updateSuccess();
        } catch ( QueryException $exp ) {
            DB::rollBack();
            return ReturnMessage::customMessage( 'error', $exp->getMessage() );
        }
    }

    public function destroy( Branch $branch ) {
        try {
            $branch->delete();
            Cache::forget('branches');
            return ReturnMessage::deleteSuccess();
        } catch ( QueryException $e ) {
            return ReturnMessage::customMessage( 'error', $e->getMessage() );
        }
    }

    public function search( Request $request ) {
        try {
            $branch = Branch::query()
                ->when( $request->q, function ( $query ) use ( $request ) {
                    $query->where( 'name', 'LIKE', '%' . $request->q . '%' );
                } )
                ->select( 'id', 'name' )
                ->limit( 20 )
                ->get();

            return response()->json( $branch );
        } catch ( ModelNotFoundException ) {
            return response()->json( ['error' => 'Sorry! not found'], 404 );
        }
    }
}
