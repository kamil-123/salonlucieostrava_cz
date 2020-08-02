<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Booking;
use App\User;
use App\Stylist;


class CalendarViewController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private function getMonth($diff = 0) 
    {
        // Generating an empty calendar of the given month (default = current month)
        $first_day_of_the_month = date('w Y m d', mktime(0,0,0, date("m") + $diff, 1, date("Y")));
        $first_day_of_the_next_month = date('w Y m d', mktime(0,0,0, date("m") + $diff + 1, 1, date("Y")));
        $date = $first_day_of_the_month;
        $current_month_dates = [];
        $i = 1;
        while ($date !== $first_day_of_the_next_month) {
            $current_month_dates[] = $date;
            $date = date('w Y m d', mktime(0,0,0, date("m") + $diff, 1 + $i, date("Y")));
            $i += 1;
        }

        return $current_month_dates;
    }

    public function index() 
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($month = 0)
    {
        $current_month_dates = $this->getMonth($month);
        [, $last_y, $last_m,] = explode(' ', end($current_month_dates));
        [, $first_y, $first_m,] = explode(' ', $current_month_dates[0]);

        // Generating the final week of the previous month & the first week of the next month
        $i = 1;
        $last_index = count($current_month_dates) - 1;
        while ( $i < 7 ) {
            if ( preg_match('#^0\s.*$#', end($current_month_dates)) ) { // if the last day of the array is Sunday 
                break;
            } else {   // if the last day in the array is not Sunday
                array_push($current_month_dates, date('w Y m d', mktime(0,0,0, $last_m + 1, $i, $last_y)));
                $i += 1;
            }
        }
        $i = 1;
        while ($i < 7) {
            if ( preg_match('#^1\s.*$#', $current_month_dates[0]) ) { // if the first day in the array is Monday
                break;
            } else {   // if the first day in the array is not Monday
                array_unshift($current_month_dates, date('w Y m d', mktime(0,0,0, $first_m, 1 - $i, $first_y)));
                
                $i += 1;
            }
        }

        // formatting
        $date_list =[];
        foreach($current_month_dates as $day) {
            [$w, $y, $m, $d] = explode(' ', $day);
            $date_list[] = ['weekday' => $w, 
                            'year' => $y,
                            'month' => $m,
                            'day' => $d,
                            'full' => $day,
                            'formatted' => $y . '-' . $m . '-' . $d,
                            ];
        }

        // get stylist id
        $user_id  = auth()->id();
        $user = User::findOrFail($user_id);
        if($user->stylist != null ) {
            $stylist_id = Stylist::where('user_id',$user_id)->first()->id;
        }

        // get bookings of the given month 
        $first_monday = $date_list[0]['year'].'-'. $date_list[0]['month'].'-'.$date_list[0]['day']." 00:00:00";
        $last_sunday = end($date_list)['year'].'-'.end($date_list)['month'].'-'.end($date_list)['day'] ." 00:00:00";
        $bookings = Booking::where('start_at', '>', $first_monday)
                            ->where('start_at' , '<', $last_sunday)
                            ->where('stylist_id', $stylist_id)
                            ->orderBy('start_at', 'asc')
                            ->with('customer')
                            ->get();
        foreach($bookings as $booking) {
            [$date, $time] = explode(' ', $booking->start_at);
            [$h, $m, $s] = explode(':', $time);
            $booking['date'] = $date;
            $booking['time'] = $h.':'.$m;
        }

        // return $bookings;

        return view('stylist.calendar', compact('date_list', 'month', 'bookings'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
