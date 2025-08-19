<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('editProfile', ['user' => Auth::user()]);
    }

    function uploadToSupabase($file, $bucket = 'Rakk') 
    {
        $fileName = uniqid() . '.' . $file->getClientOriginalExtension();

        $client = new \GuzzleHttp\Client([
            'base_uri' => env('SUPABASE_URL') . '/storage/v1/',
            'headers' => [
                'Authorization' => 'Bearer ' . env('SUPABASE_ANON_KEY'),
                'apikey'        => env('SUPABASE_ANON_KEY'),
            ]
        ]);

        $response = $client->post("object/$bucket/profile/$fileName", [
            'headers' => [
                'x-upsert' => 'true',
                'Content-Type' => $file->getMimeType(),
            ],
            'body' => file_get_contents($file->getRealPath())
        ]);

        if ($response->getStatusCode() !== 200) {
            throw new \Exception("Upload failed: " . $response->getBody());
        }

        return env('SUPABASE_URL') . "/storage/v1/object/public/$bucket/profile/$fileName";
    }


    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }


        if ($request->hasFile('profile_pic')) {
            $imagePath = $this->uploadToSupabase($request->file('profile_pic'));
        } else {
            $imagePath = null;
        }
        $user->profile_pic = $imagePath;
        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully!');
    }
}
