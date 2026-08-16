<?php

namespace App\Http\Controllers;

use App\CustomClass\ReturnMessage;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function editPassword() {
        return view( 'profile.change-password' );
    }

    public function updatePassword(Request $request ) {
        try {
            $request->validate( [
                'current_password' => 'required',
                'password' => ['nullable', 'string', 'confirmed', Password::min(5)->letters()],
            ] );

            $user = Auth::user();

            if ( !Hash::check( $request->current_password, $user->password ) ) {
                return back()->withErrors( ['current_password' => 'Current password is incorrect.'] );
            }

            $user->password = Hash::make( $request->password );
            $user->save();

            return redirect()->route( 'password.edit' )->with( 'success', 'Password changed successfully!' );
        } catch ( QueryException $e ) {
            return ReturnMessage::customMessage('error', $e->getMessage());
        }
    }
}
