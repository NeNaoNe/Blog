<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

use App\Models\User;

class UserController extends Controller
{
    const LOCAL_STORAGE_FOLDER = 'public/avatars/';
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function show($id)
    {
        // Get the details of the Auth user.
        // $user = $this->user->findOrFail(Auth::user()->id);
        $user = $this->user->findOrFail($id);
        return view('users.show')->with('user', $user);
    }

    public function edit()
    {
        $user = $this->user->findOrFail(Auth::user()->id);
        return view('users.edit')->with('user', $user);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name'     => 'required|min:1|max:50',
            'email'    => 'required|email|max:50|' . Rule::unique('users')->ignore(Auth::user()->id),
            'avatar'   => 'mimes:jpg,png,jpeg,gif|max:1048'
        ]);

        $user         = $this->user->findOrFail(Auth::user()->id);
        $user->name   = $request->name;
        $user->email  = $request->email;

        # If the user uploaded an avatar...
        if ($request->avatar){
            # If the user currently has an avatar, delete it from local storage
            if ($user->avatar){
                $this->deleteAvatar($user->avatar);
            }

            # Move the new image to local storage
            $user->avatar = $this->saveAvatar($request);
            // $user->avatar = '16823621234.jpeg';
        }

        $user->save();
        return redirect()->route('profile.show', Auth::user()->id);
    }

    private function saveAvatar($request)
    {
        # Rename the image to the CURRENT TIME to avoid overwriting
        $avatar_name = time() . "." . $request->avatar->extension();
        // $avatar_name = '16823621234.jpeg';

        # Save the image inside storage/app/public/avatars
        $request->avatar->storeAs(self::LOCAL_STORAGE_FOLDER, $avatar_name);

        return $avatar_name;
    }

    private function deleteAvatar($avatar_name)
    {
        $avatar_path = self::LOCAL_STORAGE_FOLDER . $avatar_name;
         // $avatar_path = '/public/avatars/16823621234.jpeg';

         if (Storage::disk('local')->exists($avatar_path)){
             Storage::disk('local')->delete($avatar_path);
         }
    }
}
