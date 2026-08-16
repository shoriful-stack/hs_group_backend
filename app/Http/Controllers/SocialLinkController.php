<?php

namespace App\Http\Controllers;

use App\CustomClass\ReturnMessage;
use App\DataTables\SocialLinkDataTable;
use App\Http\Requests\SocialLinkRequest;
use App\Models\SocialLink;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class SocialLinkController extends Controller
{
    public function index(SocialLinkDataTable $dataTable)
    {
        return $dataTable->render('socialLink.index');
    }

    public function create()
    {
        $icons = [
            'bi bi-facebook',
            'bi bi-twitter',
            'bi bi-instagram',
            'bi bi-linkedin',
            'bi bi-youtube',
        ];
        return view('socialLink.create', compact('icons'));
    }

    public function store(SocialLinkRequest $request)
    {
        try {
            DB::beginTransaction();

            SocialLink::create([
                'icon'      => $request->icon,
                'link'      => $request->link,
                'serial_no' => $request->serial_no,
            ]);
            Cache::forget('social-links');
            DB::commit();
            return ReturnMessage::insertSuccess();
        } catch (QueryException $e) {
            DB::rollBack();
            return ReturnMessage::customMessage('error', $e->getMessage());
        }
    }

    public function edit(SocialLink $socialLink)
    {
        $icons = [
            'bi bi-facebook',
            'bi bi-twitter',
            'bi bi-instagram',
            'bi bi-linkedin',
            'bi bi-youtube',
        ];
        return view('socialLink.edit', compact('socialLink', 'icons'));
    }

    public function update(SocialLinkRequest $request, SocialLink $socialLink)
    {
        try {
            DB::beginTransaction();

            $socialLink->update([
                'icon'      => $request->icon,
                'link'      => $request->link,
                'serial_no' => $request->serial_no,
                'status'    => $request->status,
            ]);
            Cache::forget('social-links');
            DB::commit();
            return ReturnMessage::updateSuccess();
        } catch (QueryException $e) {
            DB::rollBack();
            return ReturnMessage::customMessage('error', $e->getMessage());
        }
    }

    public function destroy(SocialLink $socialLink)
    {
        $socialLink->delete();
        Cache::forget('social-links');
        return ReturnMessage::deleteSuccess();
    }
}
