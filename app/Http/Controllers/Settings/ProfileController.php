<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Config;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Update the user's profile information.
     */
    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
        ]);

        $user->update($request->only('name', 'email'));

        return response()->json($user);
    }

    public function updateConfig(Request $request)
    {
        $user = $request->user();
        
        $config = Config::where('user_id', Auth::id())->first();
        $config->number_of_questions = $request->number_of_questions;
        $config->save();
        dd($config);


        return response()->json($config);
    }

    public function getConfig()
    {        
        $config = Config::where('user_id',Auth::id())->pluck('number_of_questions'); 
        return $config;
    }
}
