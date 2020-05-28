<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Booking;
use App\User;
use App\Treatment;
use App\Customer;
use App\Stylist;

class BookingViewController extends Controller
{
    private $timeSlotTemplate = [
        '09:00:00' => null,
        '09:30:00' => null,
        '10:00:00' => null,
        '10:30:00' => null,
        '11:00:00' => null,
        '11:30:00' => null,
        '12:00:00' => null,
        '12:30:00' => null,
        '13:00:00' => null,
        '13:30:00' => null,
        '14:00:00' => null,
        '14:30:00' => null,
        '15:00:00' => null,
        '15:30:00' => null,
        '16:00:00' => null,
        '16:30:00' => null,
    ];

    private function getLoggedinStylistId()
    {
        $user_id  = auth()->id();
        $stylist = User::with('stylist')
                        ->findOrFail($user_id);
        $stylist_id = $stylist->stylist->id;

        return $stylist_id;
    }
    
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */  
    public function index($year = 0, $month = 0, $day = 0)
    {
        // get stylist_id
        $stylist_id = $this->getLoggedinStylistId();

        // get schedule of the currently logged-in stylist
        $today = date('Y-m-d H-i-s', mktime(0,0,0, $month, $day, $year));
        $tomorrow = date('Y-m-d H-i-s', mktime(0,0,0, $month, $day + 1, $year));
        $bookings = Booking::where('stylist_id', $stylist_id)
                            ->where('start_at' , '>', $today)
                            ->where('start_at' , '<', $tomorrow)
                            ->orderBy('start_at' , 'asc')
                            ->with('treatment')
                            ->get();
        // formatting the fetched data
        $formatted_all_schedule = [];
        $message = '';
        $dates = [];

        if ( isset($bookings[0]) ) { // if at least one booking exists on the day
            $schedule = [];
            $test = [];
            foreach($bookings as $booking) {
                $stylist_id = $booking->stylist_id;
                $booking_id = $booking->id;
                [$date, $time] = explode(" ", $booking['start_at']);
                $contents = ['booking_id' => $booking_id, 
                            'availability' => $booking->availability,
                            'duration' => isset($booking->treatment) ? $booking->treatment->duration : null,
                            ];
                
                if (array_key_exists($stylist_id, $schedule)) { // if a stylist has any bookings:
                    if (array_key_exists($date, $schedule[$stylist_id])) { // if the stylist has a certain day in his/her bookings:
                        $schedule[$stylist_id][$date][$time] = $contents;
                    } else { 
                        $schedule[$stylist_id][$date] = [$time => $contents]; 
                    }
                } else {
                    $schedule[$stylist_id] = [$date => [$time => $contents] ];
                }
            }
            
            // combine fetched data and the template
            foreach ($schedule as $stylist => $dates) {
                foreach ($dates as $date => $timeSlots) {
                    $full_day_schedule = array_merge($this->timeSlotTemplate, $timeSlots);
                    $formatted_all_schedule[$stylist][$date] = $full_day_schedule;
                }; 
            };

            // Reflecting treatment duration 
            $isContinuing = false;
            $prevBooking = [];
            $full_schedule[$stylist][$date] = [];
            foreach ( $formatted_all_schedule[$stylist][$date] as $timeslot => $info ) {

                if ( isset($info) ) {
                    if ( $info['availability'] === 1 ) { // the timeslot is booked
                        //  calculate the number of timeslots one booking takes
                        [$hour, $minute, $s] = explode(":", $info['duration']);
                        $slot = $minute === '30' ? 1 : 0; // if $minute='30', +1 slot. else 0 slot.
                        $slot += (int)$hour * 2; // if $hour='1', +2 slots 
                        $isContinuing = $slot > 1;
                        $prevBooking = $info;
                    } 
                } else { // the timeslot is free
                    if( $isContinuing ) { // the timeslot should be booked as continuation of the previous booking 
                        $info = $prevBooking; // copy previous booking details
                        $slot -= 1; // one slot (30 min) consumed
                        $isContinuing = $slot > 1; // check whether the slot should still be continuing
                    }
                }
                $full_schedule[$stylist][$date][$timeslot] = $info;
            }
            // just sending the schedule for the currently logged-in stylist
            $full_schedule = $full_schedule[$stylist_id];
            $date = array_keys($full_schedule)[0];
        } else {
            $date = date('Y-m-d', mktime(0,0,0, $month, $day, $year));
            $full_schedule[$date] = $this->timeSlotTemplate;
            $message = 'There is no booking';
        };
        // return $full_schedule;
        return view('stylist.show_daily', compact('full_schedule', 'date', 'message','day','month', 'year'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $timeslot = '09:00:00')
    {   
        // get stylist_id
        $stylist_id = $this->getLoggedinStylistId();

        // list of treatments
        $stylist = Stylist::with('treatments')
                            ->findOrFail($stylist_id);
        $treatments = $stylist->treatments;

        // current date for the date picker
        $date = date('m/d/Y', mktime(0,0,0, date('m'), date('d'), date('Y')));

        // session to pass variables across pages
        $inputs = $request->session()->get('inputs');

        return view('stylist.add_booking')->with([
            'timeslot' => $timeslot,
            'treatments' => $treatments,
            'date' => $date,
            'inputs' => $inputs,
        ]);
    }

    public function postCreate(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required',
            'treatment' => 'required',
        ]);

        // get stylist_id
        $stylist_id = $this->getLoggedinStylistId();

        // store the inputs to the session
        $inputs = $request->session()->get('inputs');
        if( isset($inputs['booking']) ) {
            $booking = $inputs['booking'];
            
        } else {
            $booking = new Booking;
        }
        $booking->stylist_id = $stylist_id;
        $booking->availability = 1;
        $treatment = Treatment::findOrFail($validated['treatment']);
        $booking->treatment_id = $treatment->id;
        $inputs = [ 'booking' => $booking, 
                    'treatment' => $treatment,
                    'date' => $validated['date'],
                    'stylist_id' => $stylist_id,
                    'timeslot' => $request->input('timeslot'),
                    ];
        $request->session()->put('inputs', $inputs);
        
        return redirect()->action('BookingViewController@createTime');
    }


    public function createTime(Request $request)
    {  
        $inputs = $request->session()->get('inputs');
        [$month, $day, $year] = explode('/', $inputs['date']);
        $date_start = date('Y-m-d H-i-s', mktime(0,0,0, $month, $day, $year));
        $date_end = date('Y-m-d H-i-s', mktime(0,0,0, $month, $day+1, $year));

        ///////////// FOR WEEKEND DEBUGGING ////////////
        // $today = date('Y-m-d H-i-s', mktime(0,0,0, date('m'), date('d') -2, date('Y')));
        // $tomorrow = date('Y-m-d H-i-s', mktime(0,0,0, date('m'), date('d') -1, date('Y')));
        ////////////////////////////////////////////////

        $bookings = Booking::where('stylist_id', $inputs['stylist_id'])
                            ->where('start_at' , '>', $date_start)
                            ->where('start_at' , '<', $date_end)
                            ->orderBy('start_at' , 'asc')
                            ->get();
        
        // formatting the fetched data
        $formatted_all_schedule = [];
        $dates = [];
        if( isset($bookings[0]) ) { // if at least one booking exists on the day
            $schedule = [];
            $test = [];
            foreach($bookings as $booking) {
                $stylist_id = $booking->stylist_id;
                $booking_id = $booking->id;
                [$date, $time] = explode(" ", $booking['start_at']);
                
                if (array_key_exists($stylist_id, $schedule)) { // if a stylist has any bookings:
                    if (array_key_exists($date, $schedule[$stylist_id])) { // if the stylist has a certain day in his/her bookings:
                        $schedule[$stylist_id][$date][$time] = ['booking_id' => $booking_id, 
                                                                'availability' => $booking->availability,
                                                                'duration' => isset($booking->treatment) ? $booking->treatment->duration : null,
                                                                ];
                    } else { 
                        $schedule[$stylist_id][$date] = [$time => ['booking_id' => $booking_id, 
                                                                    'availability' => $booking->availability,
                                                                    'duration' => isset($booking->treatment) ? $booking->treatment->duration : null,
                                                                    ]]; 
                    }
                } else {
                    $schedule[$stylist_id] = [$date => [$time => ['booking_id' => $booking_id, 
                                                                'availability' => $booking->availability,
                                                                'duration' => isset($booking->treatment) ? $booking->treatment->duration : null,
                                                                ]]];
                }
            }
            
            // combine fetched data and the template
            foreach ($schedule as $stylist => $dates) {
                foreach ($dates as $date => $timeSlots) {
                    $full_day_schedule = array_merge($this->timeSlotTemplate, $timeSlots);
                    $formatted_all_schedule[$stylist][$date] = $full_day_schedule;
                }; 
            };


            // Reflecting treatment duration 
            $isContinuing = false;
            $prevBooking = [];
            $full_schedule[$stylist][$date] = [];
            foreach ( $formatted_all_schedule[$stylist][$date] as $timeslot => $info ) {

                if ( isset($info) ) {
                    if ( $info['availability'] === 1 ) { // the timeslot is booked

                        //  calculate the number of timeslots one booking takes
                        [$hour, $minute, $s] = explode(":", $info['duration']);
                        $slot = $minute === '30' ? 1 : 0; // if $minute='30', +1 slot. else 0 slot.
                        $slot += (int)$hour * 2; // if $hour='1', +2 slots 
                        $isContinuing = $slot > 1 ? true : false;
                        $prevBooking = $info;
                    } 
                } else { // the timeslot is free
                    if( $isContinuing ) { // the timeslot should be booked as continuation of the previous booking 
                        $info = $prevBooking; // copy previous booking details
                        $slot -= 1; // one slot (30 min) consumed
                        $isContinuing = $slot > 1 ? true : false; // check whether the slot should still be continuing
                    }
                }
                $full_schedule[$stylist][$date][$timeslot] = $info;
            }

            // just sending the schedule for the currently logged-in stylist
            $full_schedule = $full_schedule[$stylist_id];
            $date = array_keys($full_schedule)[0];

        } else {
            // return the array of empty slots with the selected date
            [$month, $day, $year] = explode('/', $inputs['date']);
            $date = date('Y-m-d', mktime(0,0,0, $month, $day, $year));
            $full_schedule[$date] = $this->timeSlotTemplate;
        }

        // calculate the number of slots the selected treatment takes
        [$d_hour, $d_min,] = explode(':', $inputs['treatment']['duration']); 
        $d_slot = $d_min === '30' ? 1 : 0;
        $d_slot += (int)$d_hour * 2;

        // get the slots that the treatment can fit in
        $free_slots = [];
        $consective_slots = [];
        foreach ($full_schedule[$date] as $timeslot => $booking_info) {
            if($booking_info['availability'] === null) {
                array_push($consective_slots, $timeslot);       // count the number of consective free slots
                if (count($consective_slots) ===  $d_slot) {    // the free stots are long enough for the treatment
                    $start_time = $consective_slots[0];
                    $free_slots[$date][$start_time] = $booking_info;   
                    array_shift($consective_slots);
                }
            } else {   // the free slots are not consective
                $consective_slots = [];
            }
        }
        $timeslot = $inputs['timeslot'];
        $request->session()->put('inputs', $inputs);
        return view('stylist.add_booking2', compact('date', 'free_slots', 'timeslot'));
    }
    

    public function postCreateTime(Request $request)
    {
        $validated = $request->validate([
            'time' => 'required',
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'phone' => 'required|max:255',
            'email' => 'email|required',
        ]);
        $inputs = $request->session()->get('inputs');

        // formatting the dateTime data
        [$month, $day, $year] = explode('/', $inputs['date']);
        [$hour, $minute, $second] = explode(':', $validated['time']);
        $start_at = date('Y-m-d H:i:s', mktime($hour, $minute, $second, $month, $day, $year));
        $inputs['booking']->start_at = $start_at;

        $customer = Customer::where('email', $validated['email'])->first();
        
        if( isset($customer) ) {
            $customer->first_name = $validated['first_name'];
            $customer->last_name = $validated['last_name'];
            $customer->phone = $validated['phone'];
        } else {
            $customer = new Customer;
            $customer->first_name = $validated['first_name'];
            $customer->last_name = $validated['last_name'];
            $customer->phone = $validated['phone'];
            $customer->email = $validated['email'];
        }
        $inputs['customer'] = $customer;
        $request->session()->put('inputs', $inputs);
        return redirect()->action('BookingViewController@createBooking');
    }


    public function createBooking(Request $request) {
        $inputs = $request->session()->get('inputs');
        return view('stylist.add_booking3', compact('inputs'));
    } 


    public function postCreateBooking(Request $request) {
        $inputs = $request->session()->get('inputs');
        $inputs['customer']->save();
        $inputs['booking']->customer_id = $inputs['customer']->id;
        $inputs['booking']->save();
        $inputs['customer']->bookings()->save($inputs['booking']);
        $inputs['treatment']->bookings()->save($inputs['booking']);
        $id = $inputs['booking']->id;
        [,$timeslot] = explode(' ', $inputs['booking']->start_at);

        // clear the contents in the session
        $request->session()->forget('inputs');
        
        return redirect()->route('booking.details', ['id' => $id]);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // get stylist_id
        $stylist_id = $this->getLoggedinStylistId();

        // create a new row in bookings table 
        $booking = new Booking;
        $booking->stylist_id = $stylist_id;
        $booking->treatment_id = $request->input('treatment');
        $booking->availability = 1; // 1 = booked

        [$y, $mon, $d] = explode('-', $request->input('date'));
        [$h, $min, $s]= explode(':', $request->input('time'));
        $datetime = date('Y-m-d H:i:s', mktime($h, $min, $s, $mon, $d, $y));
        $booking->start_at =  $datetime;

        //  check whether the customer already has a record in DB
        $customer = Customer::where('email', $request->input('email'))->first();
        if($customer !== null) { // if a record exist, get the id and assign it to customer_id
            $customer->bookings()->save($booking);

        } else { // if not, create a new record in customers table
            $customer = new Customer;
            $customer->first_name = $request->input('first_name');
            $customer->last_name = $request->input('last_name');
            $customer->email = $request->input('email');
            $customer->phone = $request->input('phone');
            $customer->save();
            $booking->customer_id = $customer->id;
            $booking->push();

            return $booking->customer;  
        }

        return redirect()->action('BookingViewController@show', ['id'=> $booking->id]);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // get stylist_id
        $stylist_id = $this->getLoggedinStylistId();
        
        // get a certain booking 
        $booking = Booking::with('customer')
                        ->with('treatment')
                        ->findOrFail($id);
        [$date, $time] = explode(" ",$booking->start_at);
        // return $booking;
        return view('stylist.show_booking')->with(['id'=> $id, 'booking' => $booking, 'time' => $time, 'date' => $date]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        // get stylist_id
        $stylist_id = $this->getLoggedinStylistId();

        // get the list of treatments
        $treatments = [];
        foreach($user->stylist->treatments as $treatment) {
            array_push($treatments, $treatment);
        }

        // get the requested booking 
        $editing_booking = Booking::with('customer')
                                    ->with('treatment')
                                    ->findOrFail($id);
        
        // formatting the date for date picker
        [$date, $time] = explode(' ', $editing_booking->start_at);
        [$y_format, $m_format, $d_format] = explode('-', $date);
        $f_date = $m_format . '/' . $d_format . '/' . $y_format;

        // store variables;
        $inputs = $request->session()->get('inputs');
        return view('stylist.edit_booking', compact('treatments', 'editing_booking', 'f_date', 'inputs', 'id', 'time'));
    }


    public function postEdit(Request $request) 
    {
        $validated = $request->validate([
            'date' => 'required',
            'treatment' => 'required',
        ]);

        if(empty($request->session()->get('inputs'))) {
            $booking = Booking::findOrFail($request->input('id'));
        } else {
            $inputs = $request->session()->get('inputs');
            $booking = $inputs['booking'];
        }
        $booking->treatment_id = $validated['treatment']; 
        $inputs['booking'] = $booking;
        [$month, $day, $year] = explode('/', $validated['date']);
        if ( !isset($inputs['date']) ) {
            $inputs['date'] = [];
        }
        $inputs['date'] = array(    'month' => $month,
                                    'day' => $day,
                                    'year' => $year,
                                    'time' => $request->input('time'),
                                );
        $request->session()->put('inputs', $inputs);
        return redirect()->action('BookingViewController@editTime');
    }


    public function editTime(Request $request) 
    {
        $inputs = $request->session()->get('inputs');

        // get stylist_id
        $stylist_id = $this->getLoggedinStylistId();

        // get only the free timeslots
        $start_of_the_day = date('Y-m-d H:i:s', mktime(0,0,0, $inputs['date']['month'], $inputs['date']['day'], $inputs['date']['year']));
        $end_of_the_day = date('Y-m-d H:i:s', mktime(0,0,0, $inputs['date']['month'], $inputs['date']['day']+1, $inputs['date']['year']));

        $bookings  = Booking::where('stylist_id', $stylist_id)
                            ->where('start_at','>', $start_of_the_day)
                            ->where('start_at','<', $end_of_the_day)
                            ->orderBy('start_at' , 'asc')
                            ->get();

        // formatting the fetched data
        $formatted_all_schedule = [];
        $message = '';
        $dates = [];
        if( isset($bookings[0]) ) { // if at least one booking exists on the day
            $schedule = [];
            $test = [];
            foreach($bookings as $booking) {
                $stylist_id = $booking->stylist_id;
                $booking_id = $booking->id;
                [$date, $time] = explode(" ", $booking['start_at']);
                
                if (array_key_exists($stylist_id, $schedule)) { // if a stylist has any bookings:
                    if (array_key_exists($date, $schedule[$stylist_id])) { // if the stylist has a certain day in his/her bookings:
                        $schedule[$stylist_id][$date][$time] = ['booking_id' => $booking_id, 
                                                                'availability' => $booking->availability,
                                                                'duration' => isset($booking->treatment) ? $booking->treatment->duration : null,
                                                                ];
                    } else { 
                        $schedule[$stylist_id][$date] = [$time => ['booking_id' => $booking_id, 
                                                                    'availability' => $booking->availability,
                                                                    'duration' => isset($booking->treatment) ? $booking->treatment->duration : null,
                                                                    ]]; 
                    }
                } else {
                    $schedule[$stylist_id] = [$date => [$time => ['booking_id' => $booking_id, 
                                                                'availability' => $booking->availability,
                                                                'duration' => isset($booking->treatment) ? $booking->treatment->duration : null,
                                                                ]]];
                }
            }
            
            // combine fetched data and the template
            foreach ($schedule as $stylist => $dates) {
                foreach ($dates as $date => $timeSlots) {
                    $full_day_schedule = array_merge($this->timeSlotTemplate, $timeSlots);
                    $formatted_all_schedule[$stylist][$date] = $full_day_schedule;
                }; 
            };

            // Reflecting treatment duration 
            $isContinuing = false;
            $prevBooking = [];
            $full_schedule[$stylist][$date] = [];


            foreach ( $formatted_all_schedule[$stylist][$date] as $timeslot => $info ) {

                if ( isset($info) ) {
                    if ( $info['availability'] === 1 ) { // the timeslot is booked

                        //  calculate the number of timeslots one booking takes
                        [$hour, $minute, $s] = explode(":", $info['duration']);
                        $slot = $minute === '30' ? 1 : 0; // if $minute='30', +1 slot. else 0 slot.
                        $slot += (int)$hour * 2; // if $hour='1', +2 slots 
                        $isContinuing = $slot > 1 ? true : false;
                        $prevBooking = $info;
                    } 
                } else { // the timeslot is free
                    if( $isContinuing ) { // the timeslot should be booked as continuation of the previous booking 
                        $info = $prevBooking; // copy previous booking details
                        $slot -= 1; // one slot (30 min) consumed
                        $isContinuing = $slot > 1 ? true : false; // check whether the slot should still be continuing
                    }
                }
                $full_schedule[$stylist][$date][$timeslot] = $info;
            }

            // just sending the schedule for the currently logged-in stylist
            $full_schedule = $full_schedule[$stylist_id];
            $date = array_keys($full_schedule)[0];
        }  else {
            // return the array of empty slots with the selected date
            $date = date('Y-m-d', mktime(0,0,0, $inputs['date']['month'], $inputs['date']['day'], $inputs['date']['year']));
            $full_schedule[$date] = $this->timeSlotTemplate;
        }

        // calculate the number of slots the selected treatment takes
        $treatment = Treatment::findOrFail($inputs['booking']->treatment_id);
        [$d_hour, $d_min,] = explode(':', $treatment->duration); 
        $d_slot = $d_min === '30' ? 1 : 0;
        $d_slot += (int)$d_hour * 2;

        // get the slots that the treatment can fit in
        $free_slots = [];
        $consective_slots = [];
        foreach ($full_schedule[$date] as $timeslot => $booking_info) {
            if($booking_info['availability'] === null) {
                array_push($consective_slots, $timeslot);       // count the number of consective free slots
                if (count($consective_slots) ===  $d_slot) {    // the free stots are long enough for the treatment
                    $start_time = $consective_slots[0];
                    $free_slots[$date][$start_time] = $booking_info;   
                    array_shift($consective_slots);
                }
            } else {   // the free slots are not consective
                $consective_slots = [];
            }
        }
        // storing data
        $inputs['treatment'] = $treatment;
        $request->session()->put('inputs', $inputs);
        
        $booking = $inputs['booking'];
        [, $time] = explode(" ", $booking->start_at);
        $date = date('Y-m-d', mktime(0,0,0, $inputs['date']['month'], $inputs['date']['day'], $inputs['date']['year']));
        $customer = Customer::findOrFail($booking->customer_id);
        $free_slots = array_keys($free_slots[$date]);

        return view('stylist.edit_booking2', compact('booking', 'date', 'time', 'free_slots', 'inputs', 'customer'));
    }


    public function postEditTime(Request $request) 
    {
        $validated = $request->validate([
            'time' => 'required',
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'phone' => 'required|max:255',
            'email' => 'email|required',
        ]);
        $inputs = $request->session()->get('inputs');
        
        // formatting the dateTime data
        $month = $inputs['date']['month'];
        $day = $inputs['date']['day'];
        $year = $inputs['date']['year'];
        [$hour, $minute, $second] = explode(':', $validated['time']);
        $start_at = date('Y-m-d H:i:s', mktime($hour, $minute, $second, $month, $day, $year));
        $inputs['booking']->start_at = $start_at;

        $customer = Customer::where('email', $validated['email'])->first();
        
        if( isset($customer) ) {
            $customer->first_name = $validated['first_name'];
            $customer->last_name = $validated['last_name'];
            $customer->phone = $validated['phone'];
        } else {
            $customer = new Customer;
            $customer->first_name = $validated['first_name'];
            $customer->last_name = $validated['last_name'];
            $customer->phone = $validated['phone'];
            $customer->email = $validated['email'];
        }
        $inputs['customer'] = $customer;
        $request->session()->put('inputs', $inputs);
        // dd($inputs);
    
        return redirect()->action('BookingViewController@editBooking');
    }


    public function editBooking(Request $request) 
    {
        $inputs = $request->session()->get('inputs');
        return view('stylist.edit_booking3', compact('inputs'));
    }


    public function postEditBooking(Request $request) 
    {
        $inputs = $request->session()->get('inputs');
        $inputs['customer']->save();
        $inputs['booking']->customer_id = $inputs['customer']->id;
        $inputs['booking']->save();
        $inputs['customer']->bookings()->save($inputs['booking']);
        $inputs['treatment']->bookings()->save($inputs['booking']);
        $booking_id = $inputs['booking']->id;

        // clear the contents in the session
        $request->session()->forget('inputs');

        return redirect()->route('booking.details', ['id' => $booking_id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $booking = Booking::with('customer')
                            ->with('treatment')
                            ->findOrFail($id);

        $booking->treatment_id = $request->input('treatment');
        $booking->customer->first_name = $request->input('first_name');
        $booking->customer->last_name = $request->input('last_name');
        $booking->customer->phone = $request->input('phone');
        $booking->customer->email = $request->input('email');

        [$y, $mon, $d] = explode('-', $request->input('date'));
        [$h, $min, $s]= explode(':', $request->input('time'));
        $datetime = date('Y-m-d H:i:s', mktime($h, $min, $s, $mon, $d, $y));
        $booking->start_at =  $datetime;
        $booking->save();

        return redirect()->action('BookingViewController@show', ['id'=>$id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteConfirmation($id)
    {
        $booking = Booking::with('customer')
                            ->with('treatment')
                            ->findOrFail($id);
        [$date, $time] = explode(' ', $booking->start_at);

        return view('stylist.delete_confirmation_booking')->with([
            'id' => $id,
            'booking' => $booking,
            'time' => $time,
            'date' => $date,
            ]);
    }


    public function block(Request $request) {
        // get stylist_id
        $stylist_id = $this->getLoggedinStylistId();

        // create a new booking with availability 0 
        $booking = new Booking;
        $booking->availability = 0; // 0 = blocked
        $booking->stylist_id = $stylist_id;
        $booking->customer_id = null;
        $booking->treatment_id = null;

        [$y, $mon, $d] = explode('-', $request->input('date'));
        [$h, $min, $s]= explode(':', $request->input('timeslot'));
        $datetime = date('Y-m-d H:i:s', mktime($h, $min, $s, $mon, $d, $y));
        $booking->start_at =  $datetime;
        $booking->save();

        // return $booking;
        return redirect()->route('home')->with('success', 'the selected timeslot was blocked.');
    }

    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return redirect()->route('home')->with('success', 'the selected timeslot is free now.');
    }
}
