<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Employee;
use App\Models\CaDetails;
use App\Models\Truck;
use App\Models\Damage;
use App\Models\DamageDetails;
use App\Models\TruckInformation;
use App\Models\Payroll;
use App\Models\Biiling;
use App\Models\CashAdvance;
use App\Models\Booking;
use App\Models\Billing;
use App\Models\Payment;
use App\Models\PayrollDetails;
use App\Models\UpdatedTime;
use App\Models\BillingDetails;
use App\Models\TransportationDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Contracts\Validation\Rule;
use Carbon\Carbon;
use DateTime;
use App\Notifications\BookingApprovedNotification;
use Twilio\Rest\Client;
use App\Channels\TwilioSmsChannel;
use Illuminate\Support\Facades\Notification;
use DateTimeZone;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Services\EmailVerificationService;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function admin_dashboard()
    {
        $today = Carbon::today()->toDateString();
        $pendingBookings = Booking::where('status',0)->count();
        $bookings = Booking::where('status',0)->count();
        $delivered = TransportationDetails::where('status',5)->count();
        $employee = Employee::count();
        $clients = User::where('type',0)->count();

        $transpo = TransportationDetails::with('booking.user', 'truck')
            ->whereHas('booking', function ($query) use ($today) {
                $query->whereDate('pickUp_date', $today);
            })->get();

        $countTranspo = TransportationDetails::with('booking.user', 'truck')
        ->whereHas('booking', function ($query) use ($today) {
            $query->whereDate('pickUp_date', $today);
        })->count();

        $countEmployeesTodayBirthday = Employee::with('user')
        ->whereRaw("DATE_FORMAT(dob, '%m-%d') = ?", 
        [Carbon::today()->format('m-d')])->count();
        
        return view('admin.admin', compact('countEmployeesTodayBirthday','transpo','pendingBookings','delivered','employee','clients','countTranspo'));
    }

    public function employee_birthday()
    {
        $today = Carbon::today()->toDateString();
        $pendingBookings = Booking::where('status',0)->count();
        $approvedBookings = TransportationDetails::where('status',1)->count();
        $delivered = TransportationDetails::where('status',5)->count();
        $employee = Employee::count();
        $clients = User::where('type',0)->count();
       
        // Get employees with today's birthday
        $employeesTodayBirthday = Employee::with('user')->whereRaw("DATE_FORMAT(dob, '%m-%d') = ?", [Carbon::today()->format('m-d')])->get();
        $countEmployeesTodayBirthday = Employee::with('user')->whereRaw("DATE_FORMAT(dob, '%m-%d') = ?", [Carbon::today()->format('m-d')])->count();

        // Get employees with upcoming birthdays
        $employeesUpcomingBirthday = Employee::with('user')
        ->whereRaw("DATE_FORMAT(dob, '%m-%d') > ?", [Carbon::today()->format('m-d')])
        ->orderByRaw("DATE_FORMAT(dob, '%m-%d') ASC")
        ->get();

        $countEmployeesUpcomingBirthday = Employee::with('user')
        ->whereRaw("DATE_FORMAT(dob, '%m-%d') > ?", [Carbon::today()->format('m-d')])
        ->orderByRaw("DATE_FORMAT(dob, '%m-%d') ASC")
        ->count();
        return view('admin.employeeBirthday', compact('countEmployeesUpcomingBirthday','employeesUpcomingBirthday','countEmployeesTodayBirthday','employeesTodayBirthday','pendingBookings','approvedBookings','delivered','employee','clients'));
    }

    public function clientAccount()
    {
        $users = User::where('type', 0)->get();
        return view('admin.client',compact('users'));
    }

    public function decline_booking($id)
    {
        $decline = Booking::find($id);
        $decline->status = 2;
        $decline->save();
        return redirect()->back();
    }

    public function update_user(Request $request, $id)
    {
        // Validate the input data
        $request->validate([
            'status' => 'required|in:0,1', // Only allow 0 (Active) or 1 (Inactive)
        ]);
    
        // Find the user by ID
        $user = User::findOrFail($id);
    
        // Check the current status before updating
        $isCurrentlyActive = $user->is_disabled == 0;
    
        // Update the user status
        $user->update([
            'is_disabled' => $request->input('status'),
        ]);
    
        // Set the appropriate success message based on the selected status
        if ($request->input('status') == 0 && !$isCurrentlyActive) {
            // User updated to active
            Alert::success('User has been set to active.', 'User Status Updated');
        } elseif ($request->input('status') == 1 && $isCurrentlyActive) {
            // User updated to inactive
            Alert::warning('User has been Inactive.', 'User Status Updated');
        } else {
            // No change in status
            Alert::info('User status remains unchanged.', 'No Update Needed');
        }
    
        return redirect()->back();
    }
    
    
    public function register(Request $request,  EmailVerificationService $emailVerifier)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required',
            'phone_num' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
        ]);

        // Create a new user instance
        $user = new User([
            'name' => $request->input('name'),
            'lname' => $request->input('lname'),
            'email' => $request->input('email'),
            'phone_num' => $request->input('phone_num'),
            'password' => Hash::make($request->password),
        ]);

    //     $email = $request->input('email');

    //      // Verify if the email address exists
    //     if (!$emailVerifier->verifyEmail($email)) {
    //         Alert::error('The provided email address does not exist.');
    //     return back()->withInput()->withErrors(['email' => 'The provided email address does not exist.']);
    // }

        // Save the user to the database
        $user->save();

        // Send a confirmation email
        // Mail::to($user->email)->send(new UserRegistrationConfirmation($user));

        // Redirect or return a response
        Alert::success('Account created successfully');
        return redirect()->route('client.account');
    }

    public function employeeAccount()
    {
        $driver = Employee::with('user')
        ->where('position',0)
        ->get();

        $driverCount = Employee::whereHas('user', function ($query) {
            $query->where('is_disabled', 0);
        })
        ->where('position', 0)
        ->count();
        
        $helperCount = Employee::whereHas('user', function ($query) {
            $query->where('is_disabled', 0);
        })
        ->where('position', 1)
        ->count();

        $helper = Employee::with('user')
        ->where('position',1)
        ->get();
        return view('admin.employee',compact('driver','helper','driverCount','helperCount'));
    }

    public function update_transportation_status(Request $request, $id)
    {
        $transportation = TransportationDetails::findOrFail($id);
        $transportation->status = $request->input('status');
        $transportation->save();

        Alert::success('Status Updated Successfully');
        return redirect()->back();
    
    }


    public function disable_driver($id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            // Handle error: Employee not found
            return response()->json(['success' => false, 'message' => 'Employee not found']);
        }

        $employee->user->is_disabled = 1;
        $employee->user->save();

        // You can perform additional actions here as needed

        return response()->json(['success' => true, 'message' => 'Employee disabled successfully']);
    }

    public function enable_driver($id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            // Handle error: Employee not found
            return response()->json(['success' => false, 'message' => 'Employee not found']);
        }

        $employee->user->is_disabled = 0;
        $employee->user->save();

        // You can perform additional actions here as needed

        return response()->json(['success' => true, 'message' => 'Employee enabled successfully']);
    }

    public function employeeDetails($id)
    {
        $employees = Employee::with('user')->find($id);
        return view('admin.employeeDetails',compact('employees'));
    }

    public function employee_account(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'lname' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Create a new user
        $user = new User([
            'name' => $request->name,
            'lname' => $request->lname,
            'email' => $request->email,
            'phone_num' => $request->phone,
            'type' => $request->type,
            'password' => Hash::make($request->password),
        ]);
        $user->save();

        // Create a new employee
        $employee = new Employee([
            'dob' => $request->date,
            'address' => $request->address,
            'position' => $request->position,
        ]);

        // Save the uploaded truck photo to the storage
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('profile_photos');
            $employee->photo = $photoPath;
        }

        // Associate the employee with the user
        $user->employees()->save($employee);

        // Display a success message and redirect
        Alert::success('Add Employee Account Successfully');
        return redirect()->back();
    }


    public function helper_account(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'lname' => 'required',
            'email' => 'required|unique:users',
        ]);

        $user = new User([
            'name' => $request->name,
            'lname' => $request->lname,
            'email' => $request->email,
            'phone_num' => $request->phone_num,
            'type' => 2,
        ]);
        $user->save();


        $employee = new Employee;
        $employee->user_id = $user->id;
        $employee->dob = $request->dob;
        $employee->address = $request->home;
        $employee->position = 1;
        $employee->save();
        Alert::success('Add Helper Successfully');
        return redirect()->back();
    }

    public function add_truck(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'plate_number' => 'required|string|max:255|unique:trucks', // Adding the unique rule
            'truck_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
    
        if ($validator->fails()) {
            // Alert::error('All fields are required for adding a truck');
            return redirect()->back()->withErrors($validator)->withInput();
        }
    

         // Process the form data and save it to the database
         $truck = new Truck();
         $truck->truck_type = 'isuzu forward'; // Assuming truck_type is the name of the input field for the truck type
         $truck->plate_number = $request->input('plate_number');

         // Save the uploaded truck photo to the storage
        if ($request->hasFile('truck_photo')) {
            $imagePath = $request->file('truck_photo')->store('truck_photos'); 
            $truck->truck_image = $imagePath;
        }

        // Save the truck data to the database
        $truck->save();
        Alert::success('Added Truck Successfully');
        return redirect()->back();
    }

    public function update_truck(Request $request, $id)
    {
       
        // Find the truck by its ID
        $truck = Truck::find($id);

        // Check if the truck exists
        if (!$truck) {
            return redirect()->back()->with('error', 'Truck not found');
        }

        // Update the truck data
        $truck->plate_number = $request->input('plate_number');
        $truck->status = $request->input('status');

        // Update the truck photo if a new photo is provided
        if ($request->hasFile('truck_photo')) {
            $imagePath = $request->file('truck_photo')->store('truck_photos'); // Using the 's3' disk
            $truck->truck_image = $imagePath;
        }

        // Save the updated truck data to the database
        $truck->save();

        Alert::success('Truck Updated Successfully');
        return redirect()->back();
    }

    public function transportation()
    {
        $trucks = Truck::all();

        // Filter transportation details for today's date
        $todayDate = Carbon::today()->format('Y-m-d');
        $transportations = TransportationDetails::whereIn('status', [1, 2, 3, 4, 5, 6, 7])
            ->whereHas('booking', function ($query) use ($todayDate) {
                $query->where('pickUp_date', $todayDate);
            })
            ->with('booking')
            ->get();

        $todaysTranspoCount = TransportationDetails::whereIn('status', [1, 2, 3, 4, 5, 6, 7])
        ->whereHas('booking', function ($query) use ($todayDate) {
            $query->where('pickUp_date', $todayDate);
        })
        ->with('booking')
        ->count();

        $upcoming = TransportationDetails::whereHas('booking', function ($query) use ($todayDate) {
            $query->where('pickUp_date', '>', $todayDate)
                  ->where('status', 1);
        })
        ->with('booking')
        ->get();
        

        $countUpcoming = TransportationDetails::whereHas('booking', function ($query) use ($todayDate) {
            $query->where('pickUp_date', '>', $todayDate)
                  ->where('status', 1);
        })
        ->with('booking')
        ->count();

        return view('admin.transportation', compact('trucks', 'transportations', 'upcoming','todaysTranspoCount','countUpcoming'));
    }


    public function admin_billing(Request $request)
    {
        $users = User::where('type', 0)->get();
        $userIds = $users->pluck('id'); // Get an array of user IDs

        $bookings = Booking::whereIn('user_id', $userIds)->get(); // Get bookings for the user IDs

        $bookingIds = $bookings->pluck('id'); // Get an array of booking IDs

        $transpo = TransportationDetails::with('booking', 'truck')
            ->whereIn('b_status', [0])
            ->whereIn('booking_id', $bookingIds)
            ->get();

        // Retrieve the start_date and end_date from the request object
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        

        return view('admin.billing', compact('users', 'transpo', 'start_date', 'end_date'));
    }

    public function billing_info()
    {
        $billing = Billing::with('user')->where('status',0)->get();
        return view('admin.billingInfo',compact('billing'));
    }

    public function search_invoice(Request $request) 
    {
        if($request->ajax()) {
            
            $query = $request->get('query');
            
            if ($query != '') {
                $data = Billing::with('user')->where('id', 'like', '%' . $query . '%')
                    ->orWhere('client_id', 'like', '%' . $query . '%')
                    ->orWhere('invoice_num', 'like', '%' . $query . '%')
                    ->orWhere('billing_start_date', 'like', '%' . $query . '%')
                    ->orWhere('billing_end_date', 'like', '%' . $query . '%')
                    ->orWhere('total_amount', 'like', '%' . $query . '%')
                    ->orWhere('status', 'like', '%' . $query . '%')
                    ->orderBy('id', 'asc')
                    ->get();
            } else {
                $data = Billing::with('user')->orderBy('id', 'asc')->get();
            }
            
            $total_row = $data->count();
            
            $output = '';
            $counter = 1;
            if ($total_row > 0) {
                foreach ($data as $row) {
                    $output .= '<tr>';
                    $output .= '<td>' . $counter . '</td>'; // Display the iteration number
                    $output .= '<td>' . $row->user->name . '</td>';
                    $output .= '<td>' . $row->invoice_num . '</td>';
                    $output .= '<td>' . date('M d', strtotime($row->billing_start_date)) . ' - ' . date('d, Y', strtotime($row->billing_end_date)) . '</td>';
                    $output .= '<td>&#8369;' . $row->total_amount . '</td>';
                    $output .= '<td>';

                    if ($row->status == 0) {
                        $output .= '<span class="badge text-bg-dark">Pending for payment</span>';
                    } elseif ($row->status == 1) {
                        $output .= '<span class="badge text-bg-success">Paid</span>';
                    }
                    
                    $output .= '</td>';
                    $output .= '<td>';
                    $output .= '<a href="' . route('view.billing.details', $row->id) . '" type="button" class="btn btn-outline-primary btn-sm me-1">';
                    $output .= '<i class="fas fa-eye"></i>';
                    $output .= '</a>';

                    // Button with conditional attributes
                    $output .= '<button type="button" class="btn btn-outline-success btn-sm text-capitalize"';
                    $output .= 'data-bs-toggle="modal" data-bs-target="#paidModal' . $row->id . '" ';
                    if ($row->status == 1) {
                        $output .= 'disabled ';
                    }
                    $output .= '>Paid</button>';

                    // Modal section (consider breaking this into Blade views for readability)
                    $output .= '<div class="modal fade" id="paidModal' . $row->id . '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">';
                    $output .= '<div class="payment-row">';
                    $output .= '<form action="' . route('billing.payment') . '" method="post">';
                    $output .= csrf_field(); // Equivalent to @csrf in Blade
                        
                    $output .= '<button type="submit" class="btn btn-success btn-sm float-end" disabled>Submit</button>';
                    $output .= '</form>';
                    $output .= '</div>';
                    $output .= '</div>';
                    

                    // Closing the <td> tag
                    $output .= '</td>';

                    
                    $output .= '</tr>';
            
                    $counter++; // Increment the counter for the next iteration
                }
            } else {
                $output = '<tr><td colspan="7" align="center">No Invoice number Found</td></tr>';
            }
            
            $data = [
                'table_data' => $output,
                'total_data' => $total_row
            ];
            
            return response()->json($data);
            
            
        }
    }


    public function billing_paid($id)
    {
        $billing = Billing::find($id);
        $billing->status = 1;
        Alert::success('Paid Successfully');
        $billing->save();
        return redirect()->route('admin.billingReports');
    }

    public function billing_details($id)
    {
        $currentDate = Carbon::now()->format('F j, Y');
        $billing = Billing::find($id);
        $billingDetails = BillingDetails::with('transpo')->where('billing_id',$billing->id)->get();
        return view('admin.billingDetails',compact('billing','billingDetails','currentDate'));
    }

    public function billing_details_report($id)
    {
        $currentDate = Carbon::now()->format('F j, Y');
        $payment = Payment::with('billing')->find($id);
        $billingDetails = BillingDetails::with('transpo')->where('billing_id', $payment->billing->id)->get();
        
        return view('admin.viewBillingReports', compact('payment', 'billingDetails', 'currentDate'));
    }


    public function save_billing(Request $request)
    {
        // Validate the form data
        $validator = Validator::make($request->all(), [
        'client_id' => 'required|exists:users,id', 
        ]);
        
        if ($validator->fails()) {
            Alert::error('Please choose the company');
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        // Get the data from the request
        $client_id = $request->input('client_id');
        $billing_start_date = $request->input('start_date');
        $billing_end_date = $request->input('end_date');
        $total_amount = $request->input('totalAmount');
        $transportation_ids = $request->input('transportation_id'); // Retrieve the transportation_ids from the request

        // Generate a unique invoice number
        $invoiceNumber = 'INV-' . $client_id . '-' . date('YmdHis');

        // Create a new Billing instance and set its attributes
        $billing = new Billing;
        $billing->client_id = $client_id;
        $billing->invoice_num = $invoiceNumber;
        $billing->billing_start_date = $billing_start_date;
        $billing->billing_end_date = $billing_end_date;
        $billing->total_amount = $total_amount;

        // Save the Billing instance to the database
        $billing->save();



        // Loop through the hidden input values and save them as BillingDetails
        foreach ($transportation_ids as $index => $transportation_id) {
            $billingDetails = new BillingDetails;
            $billingDetails->billing_id = $billing->id;
            $billingDetails->transportation_id = $transportation_id;

            // Assuming you have the corresponding hidden inputs for price and tons as well
            $billingDetails->price = $request->input('price')[$index];
            $billingDetails->tons = $request->input('tons')[$index];
            $billingDetails->save();

            // Update b_status in transportation_details table
            $bStatus = $request->input('bStatus')[$index]; // Fetching bStatus value
            $transportationDetail = TransportationDetails::where('id', $transportation_id)->first();
            if ($transportationDetail) {
                $transportationDetail->b_status = $bStatus;
                $transportationDetail->save();
            }
        }

        Alert::success('Saved Billing Successfully');

        // Redirect to a success page or wherever you need
        return redirect()->route('admin.billing');
    }

    public function getTodayBookings(Request $request)
    {
       
        $today = now()->toDateString();

        $todayBookings = Booking::whereDate('pickUp_date', $today)->get();

        return response()->json(['bookings' => $todayBookings]);
    }

    public function client_filter_billing(Request $request)
    {
        $client_id = $request->input('client_id');

        // Build the query for filtering
        $query = Billing::query(); // Use the query method to start a new query

        // Filter based on the client's ID
        if ($client_id) {
            $query->whereHas('user', function ($query) use ($client_id) {
                $query->where('id', $client_id);
            });
        }

        $billing = $query->get();
        $users = User::where('type', 0)->get();
        return view('admin.billingReports', compact('billing','users'));
    }

    public function client_filter(Request $request)
    {
        // Get the selected client's ID from the form submission
        $client_id = $request->input('client_id');

        // Get the start date and end date from the form submission
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        // Build the query for filtering
        $query = TransportationDetails::whereIn('b_status', [0]);

        // Filter based on the client's ID
        if ($client_id) {
            $query->whereHas('booking', function ($query) use ($client_id) {
                $query->where('user_id', $client_id);
            });
        }

        // Filter based on the date range and sort in ascending order (oldest date first)
        if ($start_date && $end_date) {
            $query->whereHas('booking', function ($query) use ($start_date, $end_date) {
                $query->whereBetween('pickUp_date', [$start_date, $end_date])->orderBy('pickUp_date', 'asc');
            });
        }

        // Retrieve the filtered data
        $transpo = $query->get();

        // Retrieve the users for the filter dropdown
        $users = User::where('type', 0)->get();

        // Pass the filtered data and users to the view, along with the start_date and end_date
        return view('admin.billing', compact('users', 'transpo', 'start_date', 'end_date'));
    }

    public function client_filter_payment(Request $request)
    {
        $client_id = $request->input('client_id');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        // Start with an Eloquent query builder for the Payment model
        $query = Payment::query();

        // Filter based on the client's ID
        if ($client_id) {
            $query->whereHas('billing.user', function ($query) use ($client_id) {
                $query->where('id', $client_id);
            });
        }

        // Filter based on the date range and sort in ascending order
        if ($start_date && $end_date) {
            $start_date = Carbon::parse($start_date)->startOfDay();
            $end_date = Carbon::parse($end_date)->endOfDay();

            $query->whereBetween('created_at', [$start_date, $end_date])
                ->orderBy('created_at', 'asc');
        }

        // Execute the query and retrieve the results
        $payments = $query->get();

        // Fetch the list of clients (assuming 'User' is the model for clients)
        $client = User::where('type', 0)->get();

        return view('admin.paymentReports', compact('payments', 'client', 'start_date', 'end_date', 'client_id'));
    }


    public function admin_payroll()
    {
        $employees = Employee::with('user', 'cashAdvances')->get(); // Load the 'cashAdvance' relationship
        $employeeIds = $employees->pluck('id'); // Pluck the 'id' values of employees

        $cashAdvances = CashAdvance::whereIn('employee_id', $employeeIds)->get();
        $cashAdvanceIds = $cashAdvances->pluck('id'); // Pluck the 'id' values of cash advances

        $caDetails = CaDetails::whereIn('ca_id', $cashAdvanceIds)->get();
        $damage = Damage::with('damageDetails')
            ->whereIn('employee_id', $employeeIds)->get();

        // Calculate total cash advance for each employee
        $totalCashAdvances = [];
        foreach ($employees as $employee) {
            $totalCashAdvance = $cashAdvances->where('employee_id', $employee->id)->sum('amount');
            $totalCashAdvances[$employee->id] = $totalCashAdvance;
        }

        $totalDamages = [];
        foreach ($employees as $employee) {
            $totalDamage =  $damage->where('employee_id', $employee->id)->sum('deduction');
            $totalDamages[$employee->id] = $totalDamage;
        }
       
        return view('admin.payroll', compact('employees', 'caDetails','damage','totalCashAdvances','totalDamages'));
    }  
 
    public function cash_advance(Request $request, $id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            abort(404); // Handle the case when the employee is not found
        }

        $cashAdvance = new CashAdvance;
        $cashAdvance->employee_id = $request->employee_id;
        $cashAdvance->amount = $request->amount;
        $cashAdvance->c_amount = $request->amount;
        $cashAdvance->purpose = $request->purpose;
        $cashAdvance->pay_seq = $request->payment_sequence;
        $cashAdvance->c_pay_sequence = $request->payment_sequence;
        $cashAdvance->save();

        Alert::success('Add Cash Advance Success');

        // Redirect back to the admin_payroll page with the updated cash advances
        return redirect()->route('admin.payroll');
    }

    public function billing_payment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'payment' => 'required|in:Cash,Bank Transfer,Cheque',
            // Add other validation rules for other fields if needed
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();

            // Display SweetAlert pop-up with error message
            alert()->error('Error', implode('<br>', $errors))->persistent(true, false);

            return redirect()->back()->withErrors($validator)->withInput();
        }

        $orNumber = date('YmdHis') . mt_rand(1000, 9999);

        $payment = new Payment;
        $payment->billing_id = $request->billing;
        $payment->payment_method = $request->payment;
        
        if ($request->payment == 'Cash') {
            // Generate a reference number for Cash payment
            $payment->ref_num = 'CASHREF' . mt_rand(1000, 9999);
        } else {
            // For other payment methods, use the provided reference number
            $payment->ref_num = $request->refNum;
        }

        $payment->chique_num = $request->chique;
        $payment->or_num = $orNumber;
        $payment->amount = $request->amount;
        $payment->save();

        // Update the billing status
        $billing = Billing::find($request->billing);
        $billing->status = 1;
        $billing->save();

        Alert::success('Billing Payment success');
        return redirect()->back();
    }


    public function delete_billing($id)
    {
        // Find the billing record by ID
        $billing = Billing::findOrFail($id);
    
        // Delete related billing_details records
        $billing->billingDetails()->delete();
    
        // Now, you can safely delete the billing record
        $billing->delete();
    
        return response()->json(['success' => true]);
    }
    
    public function addDamage(Request $request, $id)
    {
        // Validate the input data
        $validator = Validator::make($request->all(), [
            'incidence' => 'required',
            'deduction' => 'required',
            'description' => 'required|string',
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Example validation for photo (change it according to your requirements)
            'damage_sequence' => 'required|numeric',
        ]);

        // Check if the validation fails
        if ($validator->fails()) {
            // If validation fails, redirect back with errors and input data
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Create a new Damage instance and set its properties
        $damage = new Damage();
        $damage->employee_id = $request->employee_id;
        $damage->date_of_incidence = $request->incidence;
        $damage->deduction = $request->deduction;
        $damage->c_deduction = $request->deduction;
        $damage->description = $request->description;
        $damage->damage_sequence = $request->damage_sequence;
        $damage->c_term = $request->damage_sequence;

        // Handle photo upload (if provided)
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('damage_photos', 'public');
            $damage->photo = $photoPath;
        }
        Alert::success('Damage record saved successfully!');

        // Save the damage record to the database
        $damage->save();

        // Redirect back to the original page or wherever you want
        return redirect()->route('admin.payroll');
    }
    
    public function booking_pending()
    {
        $drivers = Employee::where('position',0)->get();
        $helpers = Employee::where('position',1)->get();
        $trucks = Truck::all();
        $pendingBookings = Booking::with('user')->whereIn('status',[0, 2])->get();
        return view('admin.bookingPending',compact('pendingBookings','drivers','helpers','trucks'));
    }

    public function view_payroll(Request $request, $id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            abort(404); // Handle the case when the employee is not found
        }

        // Get driver data for the employee
        $driver = TransportationDetails::with('booking.user')
            ->whereIn('p_status', [0])
            ->where('driver_id', $employee->id)
            ->get();

        // Get helper data for the employee
        $helper = TransportationDetails::with('booking.user')
            ->whereIn('h_status', [0])
            ->where('helper_id', $employee->id)
            ->get();

        $employeePayroll = Payroll::with('employee','payrollDetails')->where('employee_id',$employee->id)->where('status',0)->get();
        $employeePayrollCount = Payroll::with('employee')->where('employee_id',$employee->id)->where('status',0)->count();

        $damages = Damage::where('employee_id', $employee->id)->where('status', 0)->first();
        $cashAdvance = CashAdvance::where('employee_id', $employee->id)->where('status', 0)->first();

        // Separate the helper cash advance and damages data
        $cashAdvanceHelper = CashAdvance::where('employee_id', $employee->id)->where('status', 0)->first();
        $damagesHelper = Damage::where('employee_id', $employee->id)->where('status', 0)->first();

        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        return view('admin.viewPayroll', compact('helper','employee','driver','cashAdvance','damages','start_date','end_date','cashAdvanceHelper','damagesHelper','employeePayroll','employeePayrollCount'));
    }

    public function updateStatusforpayroll($id)
    {
        $item = Payroll::find($id);

        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }
        // Update the status attribute or any other attribute as needed
        $item->status = 1;
        $item->save();

        return response()->json(['message' => 'Status updated successfully']);
    }

    public function save_payroll(Request $request)
    {
     // Save the main payroll information
$payroll = new Payroll();
$payroll->employee_id = $request->employee_id;
$payroll->total_rate = $request->total_rate;
$payroll->total_deduction = $request->totalDeduction;
$payroll->ca_deduction = $request->ca_deduction;
$payroll->df_deduction = $request->df_deduction;
$payroll->total_net_salary = $request->total_net_salary;
$payroll->payroll_start_date = $request->start_date;
$payroll->payroll_end_date = $request->end_date;
$payroll->save();

// Save rates for each driver
if (is_array($request->transportation_id) && is_array($request->rate)) {
    // Set pStatusHelper to 1 outside the loop
    $pStatusHelper = $request->input('pStatusHelper');

    foreach ($request->transportation_id as $index => $transportationId) {
        $rate = (int)$request->rate[$index];

        if (!empty($rate)) {
            $payrollDetails = new PayrollDetails();
            $payrollDetails->payroll_id = $payroll->id;
            $payrollDetails->transportation_id = $transportationId;
            $payrollDetails->rate = $rate;
            $payrollDetails->save();

            // Update p_status in transportation_details table
            $pStatus = $request->input('pStatus');
            $transportationDetail = TransportationDetails::where('id', $transportationId)->first(); 
            if ($transportationDetail) {
                $transportationDetail->p_status = $pStatus;
                $transportationDetail->save();
            }

            // Check if the current transportation is a helper and update h_status
            $helperDetail = TransportationDetails::where('id', $transportationId)->first();

            if ($helperDetail) {
                $helperDetail->h_status = $pStatusHelper;
                $helperDetail->save();
            }
        }
    }
}




        $caDetails = new CaDetails();

        $caDetails->ca_id = $request->caId;
        $caDetails->paid_amount = $request->ca_deduction;
        $caDetails->balance = $request->balance;
        $caDetails->save();

        $damageDetails = new DamageDetails();

        $damageDetails->d_id = $request->damage_id;
        $damageDetails->paid_amount = $request->damage_amount;
        $damageDetails->balance = $request->balance_deduction;
        $damageDetails->save();

        // Get the employee ID from the request
        $employeeId = $request->input('employee_id');

        // Retrieve the first damage for the given employee with status = 0 and damage_sequence > 0
        $damage = Damage::where('employee_id', $employeeId)
            ->where('status', 0)
            ->orderBy('created_at', 'asc')
            ->first();

         // Retrieve the first cash advance for the given employee with status = 0 and advance_sequence > 0
        $cashAdvance = CashAdvance::where('employee_id', $employeeId)
        ->where('status', 0)
        ->orderBy('created_at', 'asc')
        ->first();

        // Update the damage for the employee
        if ($damage) {
            // Calculate the new deduction based on the existing deduction and damage_sequence
            $newDeduction = $damage->deduction - ($damage->deduction / $damage->damage_sequence);

            // Decrease the damage_sequence by 1
            $newDamageSequence = $damage->damage_sequence - 1;

            // Update the damage_sequence and deduction in the damages table
            $damage->damage_sequence = $newDamageSequence;
            $damage->deduction = $newDeduction;

            // Check if both damage_sequence and deduction are 0, then update the status
            if ($newDamageSequence === 0 && $newDeduction === 0) {
                // Set the status to the desired value (e.g., 1)
                $damage->status = 1;
            }

            // Save the changes to the database
            $damage->save();
        }

        // Update the cash advance for the employee
        if ($cashAdvance) {
            // Calculate the new deduction based on the existing deduction and pay_seq
            $newDeduction = $cashAdvance->amount - ($cashAdvance->amount / $cashAdvance->pay_seq);

            // Decrease the pay_seq by 1
            $newPaySequence = $cashAdvance->pay_seq - 1;

            // Update the pay_seq and amount in the cash_advances table
            $cashAdvance->pay_seq = $newPaySequence;
            $cashAdvance->amount = $newDeduction;

            // Check if both pay_seq and amount are 0, then update the status
            if ($newPaySequence == 0 && $newDeduction == 0) {
                $cashAdvance->status = 1;
            }

            // Save the changes to the database
            $cashAdvance->save();
        }

        // Calculate the new total deduction for the employee
        $newTotalDeduction = $request->total_deduction;

        // Retrieve all damages for the given employee with damage_sequence > 0 and status = 0
        $damagesPerEmployee = Damage::where('employee_id', $employeeId)
            ->where('status', 0)
            ->orderBy('created_at', 'asc')
            ->get();

       // Retrieve all cash advances for the given employee with pay_seq > 0 and status = 0
        $cashAdvancesPerEmployee = CashAdvance::where('employee_id', $employeeId)
            ->where('status', 0)
            ->orderBy('created_at', 'asc')
            ->get();

        $payroll->save();

        Alert::success('Payroll saved successfully');
        // Redirect the user with a success message
        return redirect()->route('admin.payroll');
    }

    public function payroll_info()
    {
        $payroll = Payroll::with('employee.user')->where('status',0)->get();
        return view('admin.payrollInfo', compact('payroll'));
    }

    public function view_payrollDetails(Request $request, $id)
    {
        $employee = Employee::with('user')->find($id);

        $payroll = Payroll::with('payrollDetails')
            ->where('employee_id', $employee->id)
            ->where('status', 1)
            ->get();

        $payroll_start_date = $request->input('payroll_start_date');
        $payroll_end_date = $request->input('payroll_end_date');
       
        return view('admin.payrollDetails', compact('employee', 'payroll','payroll_start_date','payroll_end_date'));
    }

    public function filter_reports(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'payroll_start_date' => 'nullable|date',
                'payroll_end_date' => 'nullable|date|after_or_equal:payroll_start_date',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Alert::error('Date cannot found');
            return redirect()->back()->withErrors($e->errors())->withInput();
        }

        $employee = Employee::where('position', 0)->first();

        $employee_id = $request->input('employee_id');
        $payroll_start_date = $request->input('payroll_start_date');
        $payroll_end_date = $request->input('payroll_end_date');

        $query = Payroll::whereIn('status', [1]);

        if ($employee_id) {
            $query->where('employee_id', $employee_id);
        }

        if ($payroll_start_date && $payroll_end_date) {
            $query->whereBetween('payroll_end_date', [$payroll_start_date, $payroll_end_date]);
        }

        $payroll = $query->orderBy('payroll_start_date', 'asc')->get();

        return view('admin.payrollDetails', compact('payroll', 'employee', 'payroll_start_date', 'payroll_end_date'));
    }


    public function view_payrollDetails_reports($id)
    {
        $payroll = Payroll::with('employee.user')->find($id);

        // Assuming the $payroll has an associated employee, you can access it using the employee relationship method.
        $employee = $payroll->employee;

        $payrollDetails = PayrollDetails::with('transportation')->where('payroll_id', $payroll->id)->get();

        // Calculate the total cash advances for the employee
        $totalCashAdvances = CashAdvance::where('employee_id', $employee->id)->sum('amount');

        // Calculate the total damages for the employee
        $totalDamages = Damage::where('employee_id', $employee->id)->sum('deduction');

        // Calculate the total balance for the employee
        $totalBalance = $totalCashAdvances + $totalDamages;

        return view('admin.payrollDetailsReports', compact('payroll', 'employee', 'payrollDetails', 'totalBalance'));
    }

    public function payroll_paid($id)
    {
        $payroll = Payroll::find($id);
        $payroll->status = 1;
        $payroll->save();
        Alert::success('Payroll Paid Success');
        return redirect()->route('admin.billingReports');
    }

    public function salary_filter(Request $request)
    {
        $employeeId = $request->input('employee_id');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
    
        if (empty($start_date) || empty($end_date)) {
            return redirect()->back()->with('error', 'Please select both start and end dates.');
        }
    
        // Ensure that the driverId is valid (not empty) and exists in the database
        if (empty($employeeId)) {
            return redirect()->back()->with('error', 'Invalid driver ID.');
        }
    
        // Retrieve the employee information with related user data
        $employee = Employee::with('user')->find($employeeId);
    
        // Check if the employee exists
        if (!$employee) {
            return redirect()->back()->with('error', 'Employee not found.');
        }
    
        // Query the transportation details based on the booking date attribute and driver ID
        $driver = TransportationDetails::where('driver_id', $employeeId)
            ->whereIn('p_status', [0])
            ->whereHas('booking', function ($query) use ($start_date, $end_date) {
                $query->whereBetween('date', [$start_date, $end_date]);
            })
            ->get();

        $helper = TransportationDetails::where('helper_id', $employeeId)
        ->whereIn('p_status', [0])
        ->whereHas('booking', function ($query) use ($start_date, $end_date) {
            $query->whereBetween('date', [$start_date, $end_date]);
        })
        ->get();
    
        // Retrieve cash advance and damages data for the employee
        $cashAdvance = CashAdvance::where('employee_id', $employeeId)->where('status',0)->first();
        $damages = Damage::where('employee_id', $employeeId)->where('status',0)->first();

        // Separate the helper cash advance and damages data
        $cashAdvanceHelper = CashAdvance::where('employee_id', $employee->id)->where('status', 0)->first();
        $damagesHelper = Damage::where('employee_id', $employee->id)->where('status', 0)->first();

        $employeePayroll = Payroll::with('employee','payrollDetails')->where('employee_id',$employee->id)->where('status',0)->get();
        $employeePayrollCount = Payroll::with('employee')->where('employee_id',$employee->id)->where('status',0)->count();
    
        // Pass the filtered data to the view
        return view('admin.viewpayroll', compact('damagesHelper','cashAdvanceHelper','helper','driver', 'employee', 'cashAdvance', 'damages','start_date','end_date','employeePayrollCount','employeePayroll'));
    }
    

    public function update_status(Request $request, $id)
    {
        $transport = TransportationDetails::find($id);
        $transport->status = $request->status;
        $transport->save();
        Alert::success('Updated Status Success');
        return redirect()->back();
    }

    public function payment_reports(Request $request)
    {
        $client = User::where('type',0)->get();
        $payments = Payment::with('billing')->get();
       
        return view('admin.paymentReports', compact('payments','client'));
    }

    public function billing_reports()
    {
        $users = User::where('type',0)->get();
        $billing = Billing::with('user')->get();
        return view('admin.billingReports',compact('billing','users'));
    }

    public function transportation_reports()
    {
        $transportations = TransportationDetails::with('booking', 'employee', 'helper', 'truck','updatedTimes')
            ->whereIn('status', [5, 6])
            ->whereHas('updatedTimes', function ($query) {
                $query->where('status', 5);
            })
            ->get();

        $countTransportations = TransportationDetails::with('booking', 'employee', 'helper', 'truck','updatedTimes')
        ->whereIn('status', [5, 6])
        ->whereHas('updatedTimes', function ($query) {
            $query->where('status', 5);
        })
        ->count();

       $driver = Employee::with('user')->whereHas('user', function ($query) {
            $query->where('is_disabled', 0);
        })->where('position', 0)->get();
            
        $helper = Employee::with('user')->whereHas('user', function ($query) {
            $query->where('is_disabled', 0);
        })->where('position', 1)->get();

        $truck = Truck::where('status', 0)->get();

        return view('admin.transportationReports', compact('transportations','driver','helper','truck','countTransportations'));
    }

    public function filter_transportation_driverHelper(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'driver_id' => 'required',
            'helper_id' => 'required',
        ], [
            'driver_id.required' => 'Please select a driver.',
            'helper_id.required' => 'Please select a helper.',
        ]);

        if ($validator->fails()) {
            // Redirect back with validation errors
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $driverId = $request->input('driver_id');
        $helperId = $request->input('helper_id');

        $transportations = UpdatedTime::filterByDriverAndHelper($driverId, $helperId)->get();

        $driver = Employee::with('user')->whereHas('user', function ($query) {
            $query->where('is_disabled', 0);
        })->where('position', 0)->get();

        $helper = Employee::with('user')->whereHas('user', function ($query) {
            $query->where('is_disabled', 0);
        })->where('position', 1)->get();

        $transportations = TransportationDetails::with('booking', 'employee', 'helper', 'truck','updatedTimes')
        ->whereIn('status', [5, 6])
        ->whereHas('updatedTimes', function ($query) {
            $query->where('status', 5);
        })
        ->get();

        return view('admin.transportationReports', compact('transportations', 'driver', 'helper'));
    }

    
    
    


    public function filterData(Request $request)
    {
        $selectedDate = $request->input('selectedDate');

        // Filter the UpdatedTime data based on status and date
        $filteredData = UpdatedTime::with('transportationDetails')->where('status', 5)
            ->whereDate('updated_at', $selectedDate)
            ->get();

        return response()->json($filteredData);
    }

    public function truck_list()
    {
        $trucks = Truck::with('truckInformation')->get();
        return view('admin.trucks',compact('trucks'));
    }
   
    public function booking(Request $request)
    {
        $clients = User::where('type', 0)->get();
        $drivers = Employee::with('user')
        ->where('position', 0)
        ->whereHas('user', function ($query) {
            $query->where('is_disabled', 0);
        })
        ->get();

        $helpers = Employee::with('user')->where('position', 1)->get();
        $trucks = Truck::with('truckInformation')->get();
        $events = [];

        $transportations = TransportationDetails::whereIn('status', [1, 2, 3, 4, 5, 6, 7])
        ->with('booking.user', 'truck', 'employee.user', 'helper.user')
        ->get();


        foreach ($transportations as $transportation) {
            
            $color = null;
            switch ($transportation->status) {
                case '1':
                    $color = 'green'; // To be pick-up
                    break;
                case '2':
                    $color = 'red'; // To be picked-up
                    break;
                case '3':
                    $color = 'gray'; // departure
                    break;
                case '4':
                    $color = 'skyblue';
                    break;
                case '5':
                    $color = 'lightgreen'; // Delivered
                    break;
                case '6':
                    $color = 'lightgreen'; // Delivered
                    break;
                case '7':
                    $color = 'lightgreen'; // Delivered
                    break;
                default:
                    $color = 'blue'; // Not Assign
                    break;
            }
            
            $driverName = $transportation->employee->user->name . ' ' . $transportation->employee->user->lname;
            $helperName = $transportation->helper->user->name . ' ' . $transportation->helper->user->lname;

            $events[] = [
                'id' => $transportation->id,
                'title' => $transportation->booking->user->name,
                'start' => $transportation->booking->pickUp_date,
                'end' => $transportation->status == 1 ? 'Approved' : 'Pending',
                'status' => $transportation->status,
                'color' => $color,
                'origin' => $transportation->booking->origin,
                'destination' => $transportation->booking->destination,
                'transportationTime' => $transportation->booking->transportation_date,
                'driver' => $driverName,
                'helper' => $helperName,
                'truck' => $transportation->truck->truck_type . ' ' . $transportation->truck->plate_number,
            ];
            
        }

        $pendingBookings = Booking::where('status', 0)->get();
        foreach ($pendingBookings as $booking) {
            $events[] = [
                'id' => $booking->id,
                'title' => $booking->user->name . ' (' . ($booking->status == 1 ? 'Approved' : 'Pre-booking') . ')',
                'start' => $booking->pickUp_date,
                'transportationDate' => $booking->transportation_date,
                'status' => 0 ,
                'color' => 'blue',
                'origin' => $booking->origin,
                'destination' => $booking->destination,
                'driver' => null, 
                'helper' => null,
                'truck' => null,
            ];
        }
             
        // Pass the assigned driver and helper IDs to the view
        return view('admin.calendar', [
            'events' => $events,
            'clients' => $clients,
            'drivers' => $drivers,
            'helpers' => $helpers,
            'trucks' => $trucks,
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        // Validate the request data if needed
        $request->validate([
            'status' => 'required|in:5,6,7', // Validate that status is one of 5, 6, or 7
        ]);

        // Find the record by ID
        $record = TransportationDetails::findOrFail($id); // Replace with your actual model name

        // Update the status
        $record->status = $request->input('status');
        $record->save();

        $status = new UpdatedTime;
        $status->t_id = $record->id;
        $status->status = $request->status;
        $status->save();

        $truckInfo = new TruckInformation();
        $truckInfo->truck_id = $record->truck_id;
        $truckInfo->status = $request->status;
        $truckInfo->save();

        // Redirect back or to a different page as needed
        return redirect()->back()->with('success', 'Status updated successfully.');
    }

    public function payroll_reports()
    {
        $employee = Employee::with('user')->get();
        return view('admin.payrollReports',compact('employee'));
    }

    public function get_booking()
    {
        $bookings = Booking::where('status', 0)->get();

        return response()->json([
            'bookings' => $bookings,
        ]);
    }

    public function checkFullyBooked(Request $request)
    {
        // Get the date from the request
        $date = $request->input('date');

        // Count the total number of trucks
        $totalTrucks = Truck::count();

        // Retrieve the list of bookings for the given date
        $bookings = Booking::where('pickUp_date', $date)->get();

        // Calculate the number of assigned trucks for the given date
        $assignedTrucks = TransportationDetails::whereIn('booking_id', $bookings->pluck('id'))
            ->distinct('truck_id')
            ->count('truck_id');

        // Check if all trucks are assigned
        $fullyBooked = $totalTrucks === $assignedTrucks;

        // Return a JSON response indicating if all trucks are assigned
        return response()->json(['fullyBooked' => $fullyBooked]);
    }


    public function assignedCompanies(Request $request)
    {
        $date = $request->input('date');

        // Retrieve the list of company IDs assigned for the given date
        $assignedCompanyIds = Booking::where('pickUp_date', $date)->pluck('user_id')->toArray();

        // Retrieve the details of assigned companies
        $assignedCompanies = User::whereIn('id', $assignedCompanyIds)->get();

        return response()->json([
            'assignedCompanies' => $assignedCompanies,
        ]);
    }

    public function assignedTruck(Request $request)
    {
        $date = $request->input('date');
       
        // Retrieve the list of truck IDs assigned for the given date from bookings
        $assignedTruckDate = TransportationDetails::whereHas('booking', function ($query) use ($date) {
            $query->whereDate('transportation_date', '>=', $date);
        })->pluck('truck_id')->toArray();


        
        
        // Retrieve the details of assigned companies
        $assignedTruck1 = Truck::whereIn('id', $assignedTruckDate)->get();
       

        return response()->json([
            'assignedTruck1' => $assignedTruck1,
          
        ]);
    }

    public function assignedTruckURL(Request $request)
    {
        $date = $request->input('date');
       
        // Retrieve the list of truck IDs assigned for the given date from bookings
        $assignedTruckDate = TransportationDetails::whereHas('booking', function ($query) use ($date) {
            $query->whereDate('pickUp_date', $date);
        })->pluck('truck_id')->toArray();


        $assignedTruckdateandtime = TransportationDetails::whereHas('booking', function ($query) use ($date) {
            $query->where('transportation_date', '>=', $date);
        })->pluck('truck_id')->toArray();
        
        // Retrieve the details of assigned companies
        $assignedTruck1 = Truck::whereIn('id', $assignedTruckDate)->get();
        $assignedTruck2 = Truck::with('truckInformation')->whereIn('id', $assignedTruckdateandtime)->get();

        return response()->json([
            'assignedTruck1' => $assignedTruck1,
            'assignedTruck2' => $assignedTruck2,
        ]);
    }

    public function assignedDriver(Request $request)
    {
        $date = $request->input('date');

        // Retrieve the list of truck IDs assigned for the given date from bookings
        $assignedDriverIds = TransportationDetails::whereHas('booking', function ($query) use ($date) {
            $query->whereDate('pickUp_date', $date);
        })->pluck('driver_id')->toArray();

        $assignedDriverIds2 = TransportationDetails::whereHas('booking', function ($query) use ($date) {
            $query->where('transportation_date', '>=', $date);
        })->pluck('driver_id')->toArray();

        // Retrieve the details of assigned companies
        $assignedDriver = Employee::whereIn('id', $assignedDriverIds)->get();
        $assignedDriver2 = Employee::whereIn('id', $assignedDriverIds2)->get();

        return response()->json([
            'assignedDriver' => $assignedDriver,
            'assignedDriver2' => $assignedDriver2,
        ]);
    }

    public function assignedHelper(Request $request)
    {
        $date = $request->input('date');

        // Retrieve the list of truck IDs assigned for the given date from bookings
        $assignedHelperIds = TransportationDetails::whereHas('booking', function ($query) use ($date) {
            $query->whereDate('pickUp_date', $date);
        })->pluck('helper_id')->toArray();

        $assignedHelpers = TransportationDetails::whereHas('booking', function ($query) use ($date) {
            $query->where('transportation_date', '>=', $date);
        })->pluck('helper_id')->toArray();
        

        // Retrieve the details of assigned companies
        $assignedHelper = Employee::whereIn('id', $assignedHelperIds)->get();
        $assignedHelper1 = Employee::whereIn('id', $assignedHelpers)->get();

        return response()->json([
            'assignedHelper' => $assignedHelper,
            'assignedHelper1' => $assignedHelper1,
        ]);
    }

    public function assignedDriverForClient(Request $request)
    {
        $date = $request->input('date');

        // Retrieve the list of truck IDs assigned for the given date from bookings
        $assignedDriverForClientIds = TransportationDetails::whereHas('booking', function ($query) use ($date) {
            $query->whereDate('pickUp_date', $date);
        })->pluck('driver_id')->toArray();

        // Retrieve the details of assigned companies
        $assignedDriverForClients = Employee::whereIn('id', $assignedDriverForClientIds)->get();

        return response()->json([
            'assignedDriverForClients' => $assignedDriverForClients,
        ]);
    }

    public function admin_booking(Request $request)
    {
        $request->validate([
            'company_name' => 'required',
            'origin' => 'required',
            'destination' => 'required',
            'driver' => 'required',
            'helper' => 'required',
            'truck' => 'required',
            'transportationDate' => 'required',
        ]);

        $booking = Booking::create([
            'user_id' => $request->company_name,
            'pickUp_date' => $request->date,
            'origin' => $request->origin,
            'destination' => $request->destination,
            'transportation_date' => $request->transportationDate,
            'status' => 1
        ]);

        $transportation = TransportationDetails::create([
            'booking_id' => $booking->id,
            'driver_id' => $request->driver,
            'helper_id' => $request->helper,
            'truck_id' => $request->truck,
            'status' => 1
        ]);

        // Get the user associated with the booking
        $user = $booking->user;

        // Determine the event color based on the user's name (company name in this case).
        // You can modify this logic based on your requirements to set different colors for different companies.
        $color = null;
        if ($user->name == 'Alpha Food') {
            $color = 'green';
        } elseif ($user->name == 'Judphiland') {
            $color = 'blue';
        } else {
            // Default color if no specific condition matches
            $color = 'red';
        }

        // Query all unique company names along with their bookings
        $companies = Booking::select('user_id')
            ->distinct('user_id')
            ->get();

        $events = [];

        foreach ($companies as $company) {
            // Query bookings for each company
            $companyBookings = Booking::where('user_id', $company->user_id)
                ->get();

            $event = [
                'title' => $company->user->name,
                'color' => $color,
                'bookings' => []
            ];

            foreach ($companyBookings as $booking) {
                $event['bookings'][] = [
                    'id' => $booking->id,
                    'title' =>$booking->user->name,
                    'pickUp_date' => $booking->date,
                    'origin' => $booking->origin,
                    'destination' => $booking->destination,
                ];
            }

            $events[] = $event;
        }

        // Return the events as a JSON response
        return response()->json($events);
    }

    public function admin_booking_from_client(Request $request)
    {
        $request->validate([
            'driver' => 'required',
            'helper' => 'required',
            'truck' => 'required',
        ]);

        // Update the Booking record based on its ID
        $bookingId = $request->input('booking_id');
        $booking = Booking::find($bookingId);

        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        $booking->status = 1;
        $booking->save();

        // Create a new record in the TransportationDetails table
        $transportation = new TransportationDetails();
        $transportation->booking_id = $bookingId;
        $transportation->driver_id = $request->input('driver');
        $transportation->helper_id = $request->input('helper');
        $transportation->truck_id = $request->input('truck');
        $transportation->status = 1; // Adjust the status as needed
        $transportation->save();

       // Create a new record in the TruckInformation table
        $truckInfo = new TruckInformation();
        $truckInfo->truck_id = $request->input('truck');
        $truckInfo->save();

        // Return a response (e.g., JSON response with the saved data)
        return response()->json(['message' => 'Data saved successfully', 'data' => $transportation]);
    }



    public function calendar_update(Request $request, $id)
    {
       
        // Find the transportation details by id
        $transpo = TransportationDetails::find($id);

        // Check if the transportation details exist
        if (!$transpo) {
            return response()->json([
                'error' => 'Unable to locate transportation details'
            ], 404);
        }

        // Find the booking related to this transportation
        $booking = Booking::find($transpo->booking_id);

        // Check if the booking exists
        if (!$booking) {
            return response()->json([
                'error' => 'Unable to locate booking details'
            ], 404);
        }

        // Update the transportation_date field in the transportation_details table
        $booking->update([
            'pickUp_date' => $request->input('transportation_date'),
        ]);

        return response()->json('Event Updated');
    }




    public function transportation_details(Request $request, $id)
    {
        $booking = Booking::find($id);
        $booking->status = 1;
        $booking->save();

        $transpo = new TransportationDetails;

        $transpo->booking_id = $request->booking_id;
        $transpo->driver_id = $request->driver_id;
        $transpo->helper_id = $request->helper_id;
        $transpo->truck_id = $request->truck_id;
        $transpo->save();

        // foreach ($transpo as $transportation) {
        //             $booking = $transportation->booking;
        //             $user = $booking->user;
        //             $clientPhoneNumber = $user->phone_num;
        // // Create a new Twilio client
        //  $twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));

        //  try {
        //     // Send the SMS notification
        //     $message = $twilio->messages->create(
        //          $clientPhoneNumber,
        //          [
        //              'from' => env('TWILIO_PHONE_NUMBER'),
        //              'body' => 'From Six J and C transportation Your booking has been approved. Thank you!'
        //          ]
        //      );

            Alert::success('Booking Success');

            return redirect()->back();
        //  } catch (TwilioException $e) {
        //      // Handle Twilio exception, such as invalid phone number error
        //      return response()->json(['error' => $e->getMessage()], 400);
        // }
    // }
    }
    
    public function truck_update(Request $request, $id)
    {
      
       // Retrieve the existing image information from the database
        $truck = Truck::find($id);
        $truck->truck_type = $request->truck_type;
        $truck->plate_number = $request->plate_number;
        
        $fileName = time().$request->file('truck_image')->getClientOriginalName();
        $path = $request->file('truck_image')->storeAs('images', $fileName, 'public');
        $requestData["truck_image"] = '/storage/'.$path;
        $truck->update($requestData);
        Alert::success('Update Truck Successfully');
        return redirect()->back();
      
    }
        
   
}
