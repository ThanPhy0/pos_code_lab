<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use function PHPUnit\Framework\fileExists;

class ProfileController extends Controller
{
    // Change Password Page
    public function changePasswordPage(){
        return view('admin.profile.changPassword');
    }

    // Change Password
    public function changPassword(Request $request){
        $this->checkPasswordValidation($request);
        $currentLoginPassword = Auth::user()->password;
        if(Hash::check($request->currentPassword, $currentLoginPassword)){
            User::where('id', Auth::user()->id)->update([
                'password' => Hash::make($request->newPassword)
            ]);
            toast('Change Password Successful!', 'success');

            // After change password, auto logout
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/');
        }else{
            toast('Change Password Unsuccessful!', 'error');
            return back();
        }
    }

    // Check status for password validation
    private function checkPasswordValidation(Request $request){
        $request->validate([
            'currentPassword' => 'required|min:4|max:15',
            'newPassword' => 'required|min:4|max:15',
            'confirmPassword' => 'required|same:newPassword|min:4|max:15'
        ]);
    }

    // Account Profile Page
    public function profile(){
        return view('admin.profile.accountProfile');
    }

    // Edit Account Profile Page
    public function editProfile(){
        return view('admin.profile.editAccountProfile');
    }

    // Update Account Profile Data
    public function updateProfile(Request $request){
        $this->checkValidationEdit($request);
        $data = $this->requestProfileData($request);

        if($request->hasFile('image')){
            // It will be delete, if doesn't match that photo name in database
            if(Auth::user()->profile != null){
                if(fileExists(public_path() . '/profile/' . Auth::user()->profile)){
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
        }else{
            $data['profile'] = null;
        }

        User::where('id', Auth::user()->id)->update($data);

        toast('Update Successful', 'success');

        return to_route('profile#accountProfile');
    }

    private function requestProfileData(Request $request){
        return [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address
        ];
    }

    private function checkValidationEdit($request){
        $request->validate([
            'name' => 'required|min:4|max:30',
            'email' => 'required',
            'phone' => 'required|min:8'
        ]);
    }

    // Create New Admin Account
    public function createNewAdminAccount(){
        return view('admin.adminAccount.create');
    }

    public function createAdminAccount(Request $request){
        $this->checkAdminAccountValidation($request);
        $data = $this->requestAdminAccountData($request);
        User::create($data);
        toast('Create Admin Account Successful', 'success');
        return to_route('profile#accountProfile');
    }

    private function requestAdminAccountData($request){
        return [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->newPassword),
            'role' => 'admin'
        ];
    }

    private function checkAdminAccountValidation($request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'newPassword' => 'required',
            'confirmPassword' => 'required|same:newPassword'
        ]);
    }

    // Admin List Page
    public function adminList(Request $request){
        $admin = User::select('id', 'name', 'email', 'address', 'phone', 'created_at', 'role', 'provider')
                    ->orWhere('role', 'superadmin')
                    ->orWhere('role', 'admin')
                    ->when($request->searchKey, function($query){
                        $query->whereAny(['name', 'email', 'address', 'phone', 'role'], 'like', '%' . request('searchKey') . '%');
                    })->paginate(6);
        return view('admin.adminAccount.list', compact('admin'));
    }

    // User List Page
    public function userList(Request $request){
        $user = User::select('id', 'name', 'email', 'address', 'phone', 'created_at', 'role', 'provider')
                    ->orWhere('role', 'user')
                    ->when($request->searchKey, function($query){
                        $query->whereAny(['name', 'email', 'address', 'phone', 'role'], 'like', '%' . request('searchKey') . '%');
                    })->paginate(6);
        return view('admin.adminAccount.list', compact('user'));
    }

    // Delete admin account
    public function delete($id){
        User::where('id', $id)->delete();
        toast('Delete successful!', 'success');
        return back();
    }
}
