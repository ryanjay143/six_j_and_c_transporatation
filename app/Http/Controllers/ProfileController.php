<?php

namespace App\Http\Controllers;
use App\Models\Employee;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function updateProfile(Request $request, Employee $employee, $id)
    {

        $employee = Employee::findOrFail($id);

        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            // Add validation rules for other fields
        ]);


        $employee->update([
            'position' => $request->position,
            'address' => $request->address,
            'dob' => $request->dob,
            // Update other fields
        ]);


        $employee->user->update([
            'name' => $request->firstname,
            'lname' => $request->lastname,
            'phone_num' => $request->phone_num,
            'email' => $request->email,
            // Update other user fields
        ]);
        Alert::success('Updated Profile Success');
        return redirect()->route('employee.account');
    }

    public function admin_profile()
    {
        $adminUser = auth()->user();
        return view('admin.profile', compact('adminUser'));
    }

    public function admin_profile_update(Request $request)
    {
        // Validate the form data
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . auth()->id(),
            'phone' => 'required',
            // Add other fields as needed
        ]);

        // Update the admin user's profile
        $adminUser = auth()->user();
        $adminUser->name = $request->input('name');
        $adminUser->lname = $request->input('lname');
        $adminUser->email = $request->input('email');
        $adminUser->phone_num = $request->input('phone');
        // Add other fields as needed
        $adminUser->save();

        // Redirect back with a success message
        return redirect()->route('admin.profile')->with('success', 'Profile updated successfully.');
    }
    public function updatePhoto(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust mime types and max size as needed
        ]);

        // Delete previous photo if needed
        // ...

        $photoPath = $request->file('photo')->store('profile-photos', 'public');

        $employee->photo = $photoPath; // Update the employee's photo field
        $employee->save();

        return response()->json(['message' => 'Profile photo updated successfully']);
    }

}
