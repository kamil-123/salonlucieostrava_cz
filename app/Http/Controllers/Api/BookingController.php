<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Booking;
use App\Stylist;
use App\Customer;
  
  
class BookingController extends Controller
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
      private $timeSlotTemplateWeekEnd = [
        '09:00:00' => 0,
        '09:30:00' => 0,
        '10:00:00' => 0,
        '10:30:00' => 0,
        '11:00:00' => 0,
        '11:30:00' => 0,
        '12:00:00' => 0,
        '12:30:00' => 0,
        '13:00:00' => 0,
        '13:30:00' => 0,
        '14:00:00' => 0,
        '14:30:00' => 0,
        '15:00:00' => 0,
        '15:30:00' => 0,
        '16:00:00' => 0,
        '16:30:00' => 0,
        
      ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $today = date("Y-m-d H:i:s");
        $tenDaysLater = date('Y-m-d H:i:s', strtotime($today. ' + 14 days'));
        
        if ($request->input('stylist_id')!==null){
            $stylist_id = $request->input('stylist_id');
            $stylist = Stylist::findOrFail($stylist_id);
            $bookings = Booking::orderBy('start_at', 'asc')->with('treatment')
            ->where('start_at' , '>=', $today) // fetch only future schedule
            ->where('start_at' , '<=', $tenDaysLater) // fetch schedule only within 14 days in future
            ->where('stylist_id', $stylist_id) //only the requested stylist_id
            ->get();   
            
            $scheduleTemplate = [];
            for($i = 1; $i <= 14 ; $i++){
                $day = date("Y-m-d", strtotime($today . ' + ' . $i . ' days'));
                $dayNr = date('N',strtotime($day));
                if($dayNr == 6 || $dayNr == 7){
                    $scheduleTemplate[$day] = $this->timeSlotTemplateWeekEnd;
                } else {
                    $scheduleTemplate[$day] = $this->timeSlotTemplate;
                }
            }
            
            foreach($bookings as $booking){
                $date_time = explode(" ",$booking['start_at']);
                $date = $date_time[0];
                $time = $date_time[1];
                
                if($booking->treatment !== null){
                    $duration = $booking->treatment->duration;
                    $slots = ((strtotime($booking['start_at'].' + '.substr($duration,0,2).'hours '.substr($duration,3,2).' minutes' ))-strtotime($booking['start_at']))/(60*30);
                    for($i = 1; $i<=$slots; $i++){
                        if (array_key_exists($date, $scheduleTemplate)){
                            if (array_key_exists($time,$scheduleTemplate[$date])){
                                $scheduleTemplate[$date][$time] = $booking->availability;
                                $time = date("H:i:s",strtotime($time . '+ 30 minutes'));
                            }
                        }    
                    }


                } else{
                    if (array_key_exists($date, $scheduleTemplate)){
                        if (array_key_exists($time,$scheduleTemplate[$date])){
                            $scheduleTemplate[$date][$time] = $booking->availability;
                        }
                    }
                }
            }


            return $scheduleTemplate;

        } else {
        $bookings = Booking::orderBy('start_at', 'asc')
                        ->where('start_at' , '>=', $today) // fetch only future schedule
                        ->where('start_at' , '<=', $tenDaysLater) // fetch schedule only within 14 days in future
                        ->get();     

        // formatting the fetched data
        $schedule = [];
        foreach($bookings as $booking) {
            $stylist_id = $booking->stylist_id;
            $date_time = explode(" ", $booking['start_at']);
            $date = $date_time[0];
            $time = $date_time[1];
            
            if (array_key_exists($stylist_id, $schedule)) {
                if (array_key_exists($date, $schedule[$stylist_id])) {
                    $schedule[$stylist_id][$date][$time] = $booking->availability;
                } else {
                    $schedule[$stylist_id][$date] = [$time => $booking->availability]; 
                }
            } else {
                $schedule[$stylist_id] = [$date => [$time => $booking->availability]];
            }
        }
        
        // REFERENCE - $schedule looks like:
        //  [ stylist_id_1 => [date_1 => [time_1 => availability, time_2 => availability], 
        //                     date_2 => [time_3..]],
        //    stylist_id_2 => [date_1 => [time_4 => availability],
        //                     date_2 => [...]], 
        //  ]

        // combine fetched data and the template
        $full_schedule = [];
        foreach ($schedule as $stylist => $dates) {
            foreach ($dates as $date => $timeSlots) {
                $full_day_schedule = array_merge($this->timeSlotTemplate, $timeSlots);
                $full_schedule[$stylist][$date] = $full_day_schedule;
            }; 
        };

        return $full_schedule;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // we do not need the create() method in api.
        // page viewing will be handled by React route
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        //store customer information from request
        $customer = Customer::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'phone' => $request->input('phone_number'),
            'email' => $request->input('email'),
        ]);       
        
        //transform start_at
        $start_at = $request->input('start_at');
        $date = substr($start_at,0,10);
        $time = substr($start_at,11,8);
        $start_at_transformed = $date . ' ' . $time;
        
        //store booking information from request
        $booking = Booking::create([
            'customer_id' => $customer->id,
            'stylist_id' => $request->input('stylist_id'),
            'treatment_id' => $request->input('treatment_id'),
            'start_at' => $start_at_transformed,
            'availability' => '1',
        ]);

        // $validated  = $request->validate([
        //     'stylist_id' => 'required',
        //     'customer_id' => 'required',
        //     'treatment_id' => 'required',
        //     'start_at' => 'required',
        //     // 'availability' => 'required',
        // ]);

        //$booking = Booking::create($validated);

        // return new booking information
        return response()->json($booking, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $booking = Booking::findOrFail($id);
        return response()->json($booking, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // we do not need the edit() method in api.
        // page viewing will be handled by React route.
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
        $validated  = $request->validate([
            'stylist_id' => 'required',
            'customer_id' => 'required',
            'treatment_id' => 'required',
            'start_at' => 'required',
            'availability' => 'required',
        ]);

        $booking = Booking::findOrFail($id);
        $booking->stylist_id = $validated['stylist_id'];
        $booking->customer_id = $validated['customer_id'];
        $booking->treatment_id = $validated['treatment_id'];
        $booking->start_at = $validated['start_at'];
        $booking->availability = $validated['availability'];
        $booking->save();

        // return updated booking infomation
        return response()->json($booking, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();
    }
}
