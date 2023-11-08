<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Truck;
use App\Models\Booking;
use App\Models\Billing;
use App\Models\BillingDetails;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\TransportationDetails;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();
        $today = Carbon::today();
        $booking = Booking::where('user_id', $user->id)->pluck('id');
        $bookings = Booking::where('user_id', $user->id)
            ->whereDate('date', $today) 
            ->get();

        $countPendingBookings = Booking::where('user_id',$user->id)
        ->where('status',0)
        ->count();


        $deliveredTranspo = TransportationDetails::with('booking', 'employee.user','truck')
        ->whereIn('booking_id', $booking)
        ->where('status', 5)
        ->count();
      

        // Define an empty collection for $transpo
        $transpo = collect();
        $todaysTranspo = 0; 

        // Check if any bookings were found before proceeding with transportation details
        if ($bookings->isNotEmpty()) {
            $bookingIds = $bookings->pluck('id')->toArray();

            $transpo = TransportationDetails::whereIn('status', [1, 2, 3, 4, 5, 6, 7])
                ->with('booking.user', 'employee.user', 'truck','updatedTime')
                ->whereIn('booking_id', $bookingIds)
                ->get();

                $todaysTranspo = TransportationDetails::whereIn('status', [1, 2, 3, 4, 5, 6, 7])
                ->with('booking.user', 'employee.user', 'truck')
                ->whereIn('booking_id', $bookingIds)
                ->count();
        }

        // Pass $transpo and $bookings to the view
        return view('user.homepage', compact('transpo', 'deliveredTranspo', 'bookings', 'todaysTranspo', 'countPendingBookings'));
    }
    
    public function client_booking(Request $request)
    {
       $request->validate([
        'origin' => 'required',
        'destination' => 'required',
        'pickUpTime' => 'required',
        'transportationTime' => 'required',
       ]);

       $booking = Booking::create([
            'user_id' => Auth::user()->id,
            'date' => $request->date,
            'origin' => $request->origin,
            'pick_up_time' => $request->pickUpTime,
            'transportation_time' => $request->transportationTime,
            'destination' => $request->destination,
       ]);

       return response()->json($booking);

    }

    public function about()
    {
        $trucks = Truck::all();
        return view('user.about',compact('trucks'));
    }
    public function contact()
    {
        $trucks = Truck::all();
        return view('user.contact',compact('trucks'));
    }
    public function service()
    {
        $trucks = Truck::all();
        return view('user.service',compact('trucks'));
    }

    public function get_transportation()
    {
        $user = auth()->user();

        // Retrieve the bookings with 'user' relationship where 'status' is in [0]
        $bookings = Booking::with('user')
            ->where('user_id', $user->id)
            ->whereIn('status', [0])
            ->get();

        // Extract the 'id' values from the bookings collection
        $bookingIds = $bookings->pluck('id');

        $transportation = array();

        // Use the extracted booking IDs to retrieve transportation details
        $transportations = TransportationDetails::with('booking')->whereIn('booking_id', $bookingIds)->get();

        foreach ($transportations as $t) {
            $transportation[] = [
                'id' => $t->id,
                'title' => $t->booking->status == 0 ? 'Approved' : 'Booked',
                'delivered' => $t->status == 5 || $t->status == 6 ? 'Delivered' : '', 
                'origin' => $t->booking->origin,
                'pickUpTime' => $t->booking->pick_up_time,
                'transportationTime' => $t->booking->transportation_time,
                'destination' => $t->booking->destination,
                'date' => $t->booking->date,
            ];
        }
       
        return view('user.booking', ['transportation' => $transportation]);
    }

    public function user_booking()
    {
        $user = auth()->user();
        $bookings = array();
        $booking = Booking::with('user')->where('user_id', $user->id)->whereIn('status', [0])->get();
        // $transportation = TransportationDetails::with('booking')
        // ->whereIn('booking_id', $bookingIds)->get();
        foreach ($booking as $b) {
            $bookings[] = [
                'id' => $b->id,
                'title' => $b->status == 0 ? 'Pre-booking' : 'Booked' ,
                'origin' => $b->origin,
                'pickUpTime' => $b->pick_up_time,
                'transportationTime' => $b->transportation_time,
                'destination' => $b->destination,
                'date' => $b->date,
                'status' => $b->status,
            ];
        }
        return view('user.booking', ['bookings' => $bookings]);  
    }

    public function user_profile()
    {
        $client = auth()->user();
        return view('user.profile',compact('client'));
    }

    public function user_profile_update(Request $request)
    {
        // Get the current user's data
        $clientUser = auth()->user();

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . auth()->id(),
            'phone' => 'required',
        ]);

        // Check if the submitted data is different from the current data
        if (
            $request->input('name') === $clientUser->name &&
            $request->input('email') === $clientUser->email &&
            $request->input('phone') === $clientUser->phone_num
        ) {
            // No changes were made, display an alert and redirect back
            Alert::warning('No changes were made to your profile.');
            return redirect()->back();
        }

        // Update the admin user's profile
        $clientUser->name = $request->input('name');
        $clientUser->email = $request->input('email');
        $clientUser->phone_num = $request->input('phone');
        $clientUser->save();

        // Display a success alert
        return redirect()->route('user.home')->with('success', 'Profile updated successfully.');
    }


    public function getTransportationDetailsForClient()
    {
        $user = auth()->user();

        $bookings = Booking::where('user_id', $user->id)->pluck('id');

        $transportations = TransportationDetails::with(['booking.user','employee.user','helper.user','truck',])
       
        ->whereIn('booking_id', $bookings)
        ->select('id', 'booking_id','driver_id','helper_id','truck_id','status')
        ->get();

        $response = [
            'success' => true,
            'transportations' => $transportations,
        ];

        return response()->json($response);
    }

    public function checkFullyBooked(Request $request)
    {
        // Get the date from the request
        $date = $request->input('date');

        // Count the total number of trucks
        $totalTrucks = Truck::count();

        // Retrieve the list of bookings for the given date
        $bookings = Booking::where('date', $date)->get();

        // Calculate the number of assigned trucks for the given date
        $assignedTrucks = TransportationDetails::whereIn('booking_id', $bookings->pluck('id'))
            ->distinct('truck_id')
            ->count('truck_id');

        // Check if all trucks are assigned
        $fullyBooked = $totalTrucks === $assignedTrucks;

        // Return a JSON response indicating if all trucks are assigned
        return response()->json(['fullyBooked' => $fullyBooked]);
    }

    public function getTransportationDetails($id)
    {
        $details = TransportationDetails::find($id);
        return response()->json($details);
    }

    public function user_dashboard()
    {
        return view('user.dashboard');
    }

    public function user_transportation()
    {
        $user = auth()->user();
        $bookingIds = Booking::where('user_id', $user->id)->pluck('id');
        $approvedTranspo = TransportationDetails::with('booking', 'employee.user','truck')
            ->whereIn('booking_id', $bookingIds)
            ->where('status', 1)
            ->get();

        $deliveredTranspo = TransportationDetails::with('booking', 'employee.user','truck')
        ->whereIn('booking_id', $bookingIds)
        ->whereIn('status', [5, 6, 7])
        ->get();

        $countDeliveredTranspo = TransportationDetails::with('booking', 'employee.user','truck')
        ->whereIn('booking_id', $bookingIds)
        ->whereIn('status', [5, 6, 7])
        ->count();

        $countApprovedTranspo = TransportationDetails::with('booking', 'employee.user','truck')
        ->whereIn('booking_id', $bookingIds)
        ->where('status', 1)
        ->count();

        return view('user.transportation', compact('approvedTranspo','countApprovedTranspo','deliveredTranspo','countDeliveredTranspo'));
    }

    public function billing_payment()
    {
        $user = auth()->user();
        $billing = Billing::where('client_id', $user->id)->get();
        $billingIds = $billing->pluck('id')->toArray(); // Convert the plucked values to an array

        $payment = Payment::with('billing')->whereIn('billing_id', $billingIds)->get();

        return view('user.reports', compact('payment'));
    }

    public function view_payment($id)
    {
        $currentDate = Carbon::now()->format('F j, Y');
        $payment = Payment::find($id);
        $billingDetails = BillingDetails::with('transpo')->where('billing_id',$payment->billing->id)->get();
        return view('user.paymentReports',compact('billingDetails','payment','currentDate'));
    }
    
    public function getBillingsForClient()
    {
        $user = auth()->user();
        $billing = Billing::where('client_id',$user->id)
        ->where('status', 0)
        ->get();
        return view('user.billings', compact('billing'));
    }

    public function getTodayBookings(Request $request)
    {
       
        $today = now()->toDateString();

        $todayBookings = Booking::whereDate('created_at', $today)->get();

        return response()->json(['bookings' => $todayBookings]);
    }


    public function view_billings($id)
    {
        $billing = Billing::find($id);
        $billingDetails = BillingDetails::with('transpo')->where('billing_id',$billing->id)->get();
        return view('user.viewBilling',compact('billing','billingDetails'));
    }

   
    
}