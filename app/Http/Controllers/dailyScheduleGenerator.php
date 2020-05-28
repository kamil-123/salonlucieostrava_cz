<?php


function getDaySchedule($user_id, $date_as_string_Y_m_d_with_hyphen) {
  $timeSlotTemplate = [
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

  // // get user id of the current logged-in user
  // $user_id  = auth()->id();

  // get stylist information 
  $user = User::with('stylist.bookings')
                  ->findOrFail($user_id);
  $stylist_id = $user->stylist->id;

  // get schedule of the currently logged-in stylist
  $date = $date_as_string_Y_m_d_with_hyphen . '00:00:00';
  $bookings = Booking::where('stylist_id', $stylist_id)
                      ->where('start_at' , '>', $date) // fetch only future schedule
                      ->orderBy('start_at' , 'asc')
                      ->get();

  // formatting the fetched data
  $schedule = [];
  foreach($bookings as $booking) {
      $stylist_id = $booking->stylist_id;
      $booking_id = $booking->id;
      [$date, $time] = explode(" ", $booking['start_at']);
      
      if (array_key_exists($stylist_id, $schedule)) { // if a stylist has any bookings:
          if (array_key_exists($date, $schedule[$stylist_id])) { // if the stylist has a certain day in his/her bookings:
              $schedule[$stylist_id][$date][$time] = ['booking_id' => $booking_id, 'availability' => $booking->availability];
          } else { 
              $schedule[$stylist_id][$date] = [$time => ['booking_id' => $booking_id, 'availability' => $booking->availability]]; 
          }
      } else {
          $schedule[$stylist_id] = [$date => [$time => ['booking_id' => $booking_id, 'availability' => $booking->availability]]];
      }
  }

  // combine fetched data and the template
  $full_schedule = [];
  foreach ($schedule as $stylist => $dates) {
      foreach ($dates as $date => $timeSlots) {
          $full_day_schedule = array_merge($this->timeSlotTemplate, $timeSlots);
          $full_schedule[$stylist][$date] = $full_day_schedule;
      }; 
  };
  // just sending the schedule for the currently logged-in stylist
  $full_schedule = $full_schedule[$stylist_id];
  $dates = array_keys($full_schedule);

  return $dates;
}

