<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use function PHPUnit\Framework\fileExists;

class ProfileController extends Controller
{
    // Change Password Page
    public function changePasswordPage()
    {
        return view('user.profile.passwordChange');
    }

    // Change Password
    public function changPassword(Request $request)
    {
        $this->checkPasswordValidation($request);
        $currentLoginPassword = Auth::user()->password;
        if (Hash::check($request->currentPassword, $currentLoginPassword)) {
            User::where('id', Auth::user()->id)->update([
                'password' => Hash::make($request->newPassword)
            ]);
            toast('Change Password Successful!', 'success');

            // After change password, auto logout
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/');
        } else {
            toast('Change Password Unsuccessful!', 'error');
            return back();
        }
    }

    // Account Profile Page
    public function profile()
    {
        return view('user.profile.profile');
    }

    // Edit Account Profile Page
    public function editProfile()
    {
        return view('user.profile.editProfile');
    }

    // Update Account Profile Data
    public function updateProfile(Request $request)
    {
        $this->checkValidationEdit($request);
        $data = $this->requestProfileData($request);

        if ($request->hasFile('image')) {
            // It will be delete, if doesn't match that photo name in database
            if (Auth::user()->profile != null) {
                if (fileExists(public_path() . '/profile/' . Auth::user()->profile)) {
                    unlink(public_path() . '/profile/' . Auth::user()->profile);
                }
                // if(fileExists(public_path('profile/' . Auth::user()->profile))){
                //     unlink(public_path('profile/' . Auth::user()->profile));
                // }
            }
            // Store image in profile folder
            $fileName = uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path() . '/profile/', $fileName);
            $data['profile'] = $fileName;
        } else {
            $data['profile'] = null;
        }

        User::where('id', Auth::user()->id)->update($data);

        toast('Update Successful', 'success');

        return to_route('userHome');
    }

    // Check status for password validation
    private function checkPasswordValidation(Request $request)
    {
        $request->validate([
            'currentPassword' => 'required|min:4|max:15',
            'newPassword' => 'required|min:4|max:15',
            'confirmPassword' => 'required|same:newPassword|min:4|max:15'
        ]);
    }

    private function checkValidationEdit($request)
    {
        $request->validate([
            'name' => 'required|min:4|max:30',
            'email' => 'required',
            'phone' => 'required|min:8'
        ]);
    }

    private function requestProfileData(Request $request)
    {
        return [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address
        ];
    }
}
