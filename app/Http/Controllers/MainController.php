<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Customer;
use App\Stylist;
use App\Treatment;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

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
        static $nazvy = [
            1 => 'Led',
            2 => 'Úno',
            3 => 'Bře',
            4 => 'Dub',
            5 => 'Kvě',
            6 => 'Čvn',
            7 => 'Čvc',
            8 => 'Srp',
            9 => 'Zář',
            10 => 'Říj',
            11 => 'Lis',
            12 => 'Pro'
        ];
        return $nazvy[$mesic];
    }

    /**
     * @param $den
     *
     * @return string
     */
    private function cesky_den($den): string
    {
        static $nazvy = [
            1 => 'Po',
            2 => 'Út',
            3 => 'St',
            4 => 'Čt',
            5 => 'Pá',
            6 => 'So',
            7 => 'Ne'];
        return $nazvy[$den];
    }

    /**
     * @return Application|Factory|View
     */
    public function mainPage()
    {
        return view('main/main');
    }


    /**
     * @param Request $request
     * @return Application|Factory|Response|View
     */
    public function saloon(Request $request)
    {
        $newBooking = $request->session()->get('newBooking');

        $stylists = Stylist::orderBy('id', 'asc')
                        ->with('user')
                        ->with('treatments')
                        ->get();

        return view('main/saloon', compact(['stylists', 'newBooking']));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function postSaloon(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'stylist_id' => 'required|integer',
            'treatment_id' => 'required|integer',
        ]);

        if (empty($request->session()->get('newBooking'))) {
           $newBooking = new Booking();
           $newBooking->fill($validatedData);
           $request->session()->put('newBooking', $newBooking);
        } else {
            $newBooking = $request->session()->get('newBooking');
            $newBooking->fill($validatedData);
            $request->session()->put('newBooking', $newBooking);
        }

        return redirect()->route('showSchedule');
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function showSchedule(Request $request)
    {
        /** @var Booking $newBooking */
        $newBooking = $request->session()->get('newBooking');
        $stylistId = $newBooking->stylist_id;
        $treatmentId = $newBooking->treatment_id;

        $today = date("Y-m-d H:i:s");
        $tenDaysLater = date('Y-m-d H:i:s', strtotime($today . ' + 14 days'));


        $stylist = Stylist::findOrFail($stylistId);
        $bookings = Booking::orderBy('start_at', 'asc')->with('treatment')
            ->where('start_at', '>=', $today) // fetch only future schedule
            ->where('start_at', '<=', $tenDaysLater) // fetch schedule only within 14 days in future
            ->where('stylist_id', $stylistId) //only the requested stylist_id
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
        $treatment = Treatment::findOrFail($treatmentId);
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

        return view('main/schedule', compact([
                    'resultScheduleTemplate',
                    'newBooking',
                    'treatment',
                    'stylist',
            ])
        );
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function orderCreate(Request $request)
    {
        $this->validate($request, [
            'start_at' => 'required|date_format:Y-m-d H:i:s',
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email',
            'phone' => 'required|'
        ]);

        $customer = Customer::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
        ]);

        /** @var Booking $newBooking */
        $newBooking = $request->session()->get('newBooking');
        $newBooking->start_at = $request->input('start_at');
        $newBooking->availability = 1;
        $newBooking->save();

        $request->session()->forget('newBooking');

        return redirect()->route('saloon');
    }
}
