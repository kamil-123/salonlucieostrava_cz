<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Stylist;
use App\Treatment;
use Illuminate\Http\Request;

class MainController extends Controller
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
     * @param $mesic
     *
     * @return string
     */
    private function cesky_mesic($mesic): string
    {
        static $nazvy = array(1 => 'Led', 'Úno', 'Bře', 'Dub', 'Kvě', 'Čvn', 'Čvc', 'Srp', 'Zář', 'Říj', 'Lis', 'Pro');
        return $nazvy[$mesic];
    }

    /**
     * @param $den
     *
     * @return string
     */
    private function cesky_den($den): string
    {
        static $nazvy = array(1 => 'Po', 'Út', 'St', 'Čt', 'Pá', 'So','Ne');
        return $nazvy[$den];
    }

    public function mainPage()
    {
        return view('main/main');
    }


   public function saloon()
    {
        $stylists = Stylist::orderBy('id', 'asc')
                        ->with('user')
                        ->with('treatments')
                        ->get();
        return view('main/saloon', compact('stylists'));
    }

    public function showSchedule(Request $request)
    {
        $this->validate($request, [
            'stylist_id' => 'required|integer',
            'treatment_id' => 'required|integer'
        ]);

        $today = date("Y-m-d H:i:s");
        $tenDaysLater = date('Y-m-d H:i:s', strtotime($today . ' + 14 days'));

        $stylist_id = $request->input('stylist_id');
        $stylist = Stylist::findOrFail($stylist_id);
        $bookings = Booking::orderBy('start_at', 'asc')->with('treatment')
            ->where('start_at', '>=', $today) // fetch only future schedule
            ->where('start_at', '<=', $tenDaysLater) // fetch schedule only within 14 days in future
            ->where('stylist_id', $stylist_id) //only the requested stylist_id
            ->get();

        $scheduleTemplate = [];
        for ($i = 1; $i <= 14; $i++) {
            $day = date("Y-m-d", strtotime($today . ' + ' . $i . ' days'));
            $dayNr = date('N', strtotime($day));
            $monthNr = date('n', strtotime($day));
            $dayname = $this->cesky_den($dayNr) . ', ' . $this->cesky_mesic($monthNr) . ' ' . date('d', strtotime($day));
            if ($dayNr == 6 || $dayNr == 7) {
                continue;
            } else {
                $scheduleTemplate[$day] = ['name' => $dayname, 'time' => $this->timeSlotTemplate];
            }
        }

        foreach ($bookings as $booking) {
            $date_time = explode(" ", $booking['start_at']);
            $date = $date_time[0];
            $time = $date_time[1];

            if ($booking->treatment !== null) {
                $duration = $booking->treatment->duration;
                $slots = ((strtotime($booking['start_at'] . ' + ' . substr($duration, 0, 2) . 'hours ' . substr($duration, 3, 2) . ' minutes')) - strtotime($booking['start_at'])) / (60 * 30);
                for ($i = 1; $i <= $slots; $i++) {
                    if (array_key_exists($date, $scheduleTemplate)) {
                        if (array_key_exists($time, $scheduleTemplate[$date]['time'])) {
                            $scheduleTemplate[$date]['time'][$time] = $booking->availability;
                            $time = date("H:i:s", strtotime($time . '+ 30 minutes'));
                        }
                    }
                }
            } else {
                if (array_key_exists($date, $scheduleTemplate)) {
                    if (array_key_exists($time, $scheduleTemplate[$date]['time'])) {
                        $scheduleTemplate[$date]['time'][$time] = $booking->availability;
                    }
                }
            }
        }
        $treatment = Treatment::findOrFail($request->input('treatment_id'));
        $duration = $treatment->duration;
        $slots = (int)(substr($duration,0,2)) * 2 + (int)(substr($duration,3,2)) / 30;
        $resultScheduleTemplate = [];
        foreach ($scheduleTemplate as $key => $template) {
            $keys = array_keys($template['time']);
            for ($i = 0, $iMax = count($keys); $i < $iMax; $i++) {
                for ($j = 0; $j < $slots; $j++) {
                    if ($i+$j<count($keys)) {
                        if ($template['time'][$keys[$i + $j]] === null) {
                            continue;
                        } else {
                            $template['time'][$keys[$i]] = 1;
                        }
                    } else {
                        $template['time'][$keys[$i]] = 1;
                    }
                }
            }
            $resultScheduleTemplate[$key] = $template;
        }

        return view('main/schedule', compact('resultScheduleTemplate', 'treatment', 'stylist'));
    }
}
