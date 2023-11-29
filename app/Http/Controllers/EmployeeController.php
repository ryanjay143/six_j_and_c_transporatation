<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Booking;
use App\Models\Payroll;
use App\Models\CashAdvance;
use App\Models\Damage;
use App\Models\CaDetails;
use App\Models\TransportationDetails;
use App\Models\TruckInformation;
use App\Models\UpdatedTime;
use App\Models\PayrollDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use Twilio\Rest\Client;
use Twilio\Exceptions\TwilioException;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function employee_index()
    {
        $driver = Auth::user();
        $employee = Employee::where('user_id', $driver->id)->where('position', '0')->first();

        if ($employee) {
            // Get today's date in the 'Y-m-d' format
            $today = Carbon::today()->toDateString();

            // Fetch transportation details for the driver where the booking date is today
            $transpo = $employee->transportationDetails()
                ->whereHas('booking', function ($query) use ($today) {
                    $query->whereDate('pickUp_date', $today);
                })
                ->with('booking.user', 'helper.user','updatedTime')
                ->get();

                 // Fetch transportation details for the driver where the booking date is today
            $transportationDate = $employee->transportationDetails()
            ->whereHas('booking', function ($query) use ($today) {
                $query->whereDate('transportation_date', $today);
            })
            ->with('booking.user', 'helper.user','updatedTime')
            ->get();

            $countDeliveredTranspo = $employee->transportationDetails()->where('status', '5')
                ->with('booking.user', 'helper.user')
                ->count();

            $upcomingTranspo = $employee->transportationDetails()->where('status', '1')
                ->whereHas('booking', function ($query) use ($today) {
                    $query->whereDate('pickUp_date', '>', $today);
                })
                ->with('booking.user', 'helper.user')
                ->count();

            $approvedTranspo = $employee->transportationDetails()
                ->whereHas('booking', function ($query) use ($today) {
                    // Filter by booking_date for today
                    $query->whereDate('pickUp_date', $today);
                })
                ->with('booking.user', 'helper.user')
                ->count();

        //           foreach ($transpo as $transportation) {
        //         $booking = $transportation->booking;
        //          $user = $booking->user;
        //          $clientPhoneNumber = $user->phone_num;
               

        //         try {
                   
        //              $twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));
        //              switch ($transportation->status) {
                       
        //                  case 2:
        //                      $message = $twilio->messages->create($clientPhoneNumber, [
        //                          'from' => env('TWILIO_PHONE_NUMBER'),
        //                          'body' => 'From Six J and C transportation, Your Transportation has been Picked-up. Thank you!'
        //                      ]);
        //                      break;

        //                  case 3:
        //                      $message = $twilio->messages->create($clientPhoneNumber, [
        //                          'from' => env('TWILIO_PHONE_NUMBER'),
        //                          'body' => 'From Six J and C transportation Your Transportation is Departed. Thank you!'
        //                      ]);
        //                      break;

        //                  case 4:
        //                      $message = $twilio->messages->create($clientPhoneNumber, [
        //                          'from' => env('TWILIO_PHONE_NUMBER'),
        //                         'body' => 'From Six J and C transportation Your Transportation is in Transit.. Thank you!'
        //                      ]);
        //                      break;

        //                  case 5:
        //                      $message = $twilio->messages->create($clientPhoneNumber, [
        //                          'from' => env('TWILIO_PHONE_NUMBER'),
        //                          'body' => 'From Six J and C transportation Your Transportation is Delivered. Thank you!'
        //                      ]);
        //                      break;
        //                  default:
        //                      break;
        //              }
        //          } catch (TwilioException $e) {
                 
        //          }
        //      }
        //  } else {
        //      $transpo = null;
        }

        return view('employee.index', compact('transportationDate','employee', 'transpo', 'approvedTranspo','upcomingTranspo','countDeliveredTranspo'));
    }



    public function employee_transportation()
    {
        $driver = Auth::user();
        $employee = Employee::where('user_id', $driver->id)->where('position', '0')->first();

        if ($employee) {
            // Get today's date
            $today = Carbon::today()->toDateString();

            // Fetch transportation details for the driver where status = 1 (approved) and booking date is greater than today
            $transpo = $employee->transportationDetails()->where('status', '1')
                ->whereHas('booking', function ($query) use ($today) {
                    $query->whereDate('pickUp_date', '>', $today);
                })
                ->with('booking.user', 'helper.user')
                ->get();

            // Fetch transportation details for the driver where status = 5 (delivered) and booking date is greater than today
            $deliveredTranspo = $employee->transportationDetails()->whereIn('status', [5,6,7])
                ->with('booking.user', 'helper.user')
                ->get();

            $countDeliveredTranspo = $employee->transportationDetails()->whereIn('status', [5,6,7])
                ->with('booking.user', 'helper.user')
                ->count();

            // Count the number of approved transportation
            $approvedTranspo = $employee->transportationDetails()->where('status', '1')
                ->whereHas('booking', function ($query) use ($today) {
                    $query->whereDate('pickUp_date', '>', $today);
                })
                ->count();
        } else {
            $transpo = null;
            $approvedTranspo = 0;
            $deliveredTranspo = null;
        }

        return view('employee.transportation', compact('employee','transpo', 'approvedTranspo', 'deliveredTranspo','countDeliveredTranspo'));
    }

    public function employee_profile()
    {
        $driver = Auth::user();
        $employee = Employee::where('user_id', $driver->id)->where('position', '0')->first();
        return view('employee.profile',compact('employee'));
    }

    public function employee_profile_update(Request $request)
    {
        // Retrieve form input data from the User table
        $firstName = $request->input('first_name');
        $lastName = $request->input('last_name');
        $email = $request->input('email');
        $phoneNumber = $request->input('phone_number');

        // Retrieve form input data from the Employee table
        $dateOfBirth = $request->input('date_of_birth');
        $address = $request->input('address');

        // Save the uploaded truck photo to the storage
        if ($request->hasFile('profile_photo')) {
            $profilePhotoPath = $request->file('profile_photo')->store('profile_photos');
        }

        // Update User table
        $user = auth()->user();
        $user->name = $firstName;
        $user->lname = $lastName;
        $user->email = $email;
        $user->phone_num = $phoneNumber;
        $user->save();

        // Update or create Employee table
        $employees = $user->employees; // Access the employees associated with the User

        if ($employees->isNotEmpty()) {
            // If Employee records exist for the user, update each one
            foreach ($employees as $employee) {
                $employee->dob = $dateOfBirth;
                $employee->address = $address;
                if (isset($profilePhotoPath)) {
                    $employee->photo = $profilePhotoPath;
                }
                $employee->save();
            }
        } else {
            // If no Employee records exist, create a new one
            $newEmployee = new Employee([
                'dob' => $dateOfBirth,
                'address' => $address,
                'photo' => isset($profilePhotoPath) ? $profilePhotoPath : null,
            ]);
            $user->employees()->save($newEmployee); // Save the new Employee associated with the User
        }

        // Redirect or return a response
        Alert::success('Profile updated successfully');
        return redirect()->route('driver.profile')->with('success', 'Profile updated successfully');
    }


    public function update_transportation(Request $request, $id)
    {

        // Validate 'tons' based on the selected status
        $request->validate([
            'tons' => ($request->status == 5) ? ['required', 'numeric'] : [],
        ]);

        // Check if 'tons' is null or zero only when the status is '5'
        if ($request->status == 5 && ($request->tons === null || $request->tons == 0)) {
            Alert::error('Tons cannot be zero. Please enter a valid value.');
            return redirect()->back();
        }


        // Find the transportation record by ID
        $transportation = TransportationDetails::find($id);


        if (!$transportation) {
            return redirect()->back()->with('error', 'Transportation not found.');
        }

        // Update the transportation status with the selected value
        $transportation->status = $request->status;
        $transportation->save();

        // Update the associated booking's exp_tons value
        $booking = $transportation->booking;
        if ($booking) {
            $booking->tons = $request->tons; 
            $booking->save();
        }

        $status = new UpdatedTime;
        $status->t_id = $transportation->id;
        $status->status = $request->status;
        $status->save();

         // Create a new record in the TruckInformation table

         $truckInfo = new TruckInformation();
         $truckInfo->truck_id = $transportation->truck_id;
         $truckInfo->status = $request->status;
         $truckInfo->save();

        Alert::success('Transportation status and Booking updated successfully.');
        return redirect()->back();
    }
    
    public function reset_password()
    {
        $driver = Auth::user();
        $employee = Employee::where('user_id', $driver->id)->where('position', '0')->first();
        return view('employee.resetPassword',compact('employee'));
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required',
            'new_password_confirmation' => 'required|same:new_password'
        ], [
            'new_password_confirmation.same' => 'The confirm password and new password must match.'
        ]);

        $user = Auth::user();

        if (!Hash::check($request->old_password, $user->password)) {
            return redirect()->back()->with('error', 'The old password is incorrect.');
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        Alert::success('Reset Password Success');

        return redirect()->back();
    }

    public function payroll(Request $request)
    {
        $driver = Auth::user();
        $employee = Employee::where('user_id', $driver->id)->where('position', 0)->first();
        $unpaidPayroll = Payroll::where('employee_id', $employee->id)->where('status', 0)->get();
        $cashAdvance = CashAdvance::where('employee_id', $employee->id)->with('caDetails')->get();
        $damage = Damage::where('employee_id', $employee->id)->with('damageDetails')->get();
        $payroll = Payroll::with('employee')->where('employee_id', $employee->id)->where('status', 1)->get();

        // Get the start date and end date from the form submission
        $payroll_start_date = $request->input('payroll_start_date');
        $payroll_end_date = $request->input('payroll_end_date');

        return view('employee.payroll', compact('employee', 'unpaidPayroll', 'cashAdvance','damage','payroll','payroll_start_date','payroll_end_date'));
    }

    public function payroll_reports()
    {
        $driver = Auth::user();
        $employee = Employee::where('user_id', $driver->id)->where('position', 0)->first();
        $payroll = Payroll::where('employee_id', $employee->id)->where('status', 1)->get();
        return view('employee.payrollReports', compact('employee', 'payroll'));
    }

    public function view_payroll($id)
    {
        $driver = Auth::user();
        $employee = Employee::where('user_id', $driver->id)->where('position', 0)->first();
        $payroll = Payroll::find($id);
        $payrollDetails = PayrollDetails::with('transportation')->where('payroll_id',$payroll->id)->get();

        // // Calculate the total cash advances for the employee
        // $totalCashAdvances = CashAdvance::where('employee_id', $employee->id)->sum('amount');

        // // Calculate the total damages for the employee
        // $totalDamages = Damage::where('employee_id', $employee->id)->sum('deduction');

        // // Calculate the total balance for the employee
        // $totalBalance = $totalCashAdvances + $totalDamages;

        return view('employee.payrollDetails',compact('employee','payroll','payrollDetails'));
    }

    public function view_payroll_reports($id)
    {
        $driver = Auth::user();
        $employee = Employee::where('user_id', $driver->id)->where('position', 0)->first();
        $payroll = Payroll::find($id);
        $payrollDetails = PayrollDetails::with('transportation')->where('payroll_id',$payroll->id)->get();

        // // Calculate the total cash advances for the employee
        // $totalCashAdvances = CashAdvance::where('employee_id', $employee->id)->sum('amount');

        // // Calculate the total damages for the employee
        // $totalDamages = Damage::where('employee_id', $employee->id)->sum('deduction');

        // // Calculate the total balance for the employee
        // $totalBalance = $totalCashAdvances + $totalDamages;

        return view('employee.payrollReportsDetails',compact('employee','payroll','payrollDetails'));
    }

    public function filter_payroll_reports(Request $request)
    {
        $driver = Auth::user();
        $employee = Employee::where('user_id', $driver->id)->where('position', 0)->first();
        // Get the selected client's ID from the form submission
        $employee_id = $request->input('employee_id');

        // Get the start date and end date from the form submission
        $payroll_start_date = $request->input('payroll_start_date');
        $payroll_end_date = $request->input('payroll_end_date');

        $query = Payroll::whereIn('status', [1]);

        // Filter based on the client's ID
        if ($employee_id) {
            $query->where('employee_id', $employee_id);
        }

        // Filter based on the date range
        if ($payroll_start_date && $payroll_end_date) {
            $query->whereBetween('payroll_end_date', [$payroll_start_date, $payroll_end_date]);
        }

        // Retrieve the filtered data
        $payroll = $query->orderBy('payroll_start_date', 'asc')->get();

        $unpaidPayroll = Payroll::where('employee_id', $employee->id)->where('status', 0)->get();
        $cashAdvance = CashAdvance::where('employee_id', $employee->id)->with('caDetails')->get();
        $damage = Damage::where('employee_id', $employee->id)->with('damageDetails')->get();
        return view('employee.payroll', compact('unpaidPayroll','cashAdvance', 'employee', 'payroll', 'damage', 'payroll_start_date', 'payroll_end_date'));
    }


}


