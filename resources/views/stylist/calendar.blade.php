@extends('layouts.app')

@section('head')
<style>
  body {
    padding: 20px 0px 200px;
  }
  h3 {
    margin-top: 1rem;
    margin-left: 1rem;
  }
  .year {
    font-family: 'Roboto', sans-serif;
    font-size: 0.9rem;
    margin-left: 1rem;
  }
  .links {
    margin: 0;
  }
  .link-left {
    text-align: left;
  }
  .link-right {
    text-align: right;
  }
  .calendar {
    margin: 2rem;
  }
  .date_number {
    text-decoration: none;
    color:rgb(50, 50, 50);
  }
  .date_number--no-current-month {
    color: rgb(200, 200, 200);
  }
  [data-toggle="calendar"] > .row > .calendar-day {
    font-family: 'Roboto', sans-serif;
    width: 14.28571428571429%;
    border: 1px solid rgb(235, 235, 235);
    border-right-width: 0px;
    border-bottom-width: 0px;
    min-height: 120px;
	}
  [data-toggle="calendar"] > .row > .calendar-week {
    font-family: 'Roboto', sans-serif;
    line-height: 3rem;
    text-align: center;
  }
  [data-toggle="calendar"] > .row > .calendar-day:last-child {
    border-right-width: 1px;
  }

  [data-toggle="calendar"] > .row:last-child > .calendar-day {
    border-bottom-width: 1px;
  }
  .event > .event {
    display: flex;
    flex-flow: column nowrap;
    overflow: hidden;
  }
  .events > .event > a {
    font-size: 12px;
    font-weight: 700;
    white-space: nowrap;
    margin-bottom: 3px;
  }

</style>
@endsection


@section('content')
<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Monthly Calendar</div>
                
                <div class="card-body">
                  {{-- LINKS --}}
                  <div class='row links'>
                    <span class='link-left col'><a href={{  route('calendar', ['month' => $month - 1]) }}>back</a></span>

                    <span class='link-right col'><a href={{  route('calendar', ['month' => $month + 1]) }}>next</a></span>
                  </div>

                  {{-- CALENDAR --}}
                  <h3>{{ date('F', mktime(0,0,0, date('m')+$month, 1, date('Y')) ) }}</h3>
                  <p class='year'>{{ date('Y', mktime(0,0,0, date('m')+$month, 1, date('Y')) ) }}</p>
                      <div class="calendar" data-toggle="calendar">
                        <div class="row">
                          <div class="col calendar-week">
                            <div>Mon</div>
                          </div>
                          <div class="col calendar-week">
                            <div>Tue</div>
                          </div>
                          <div class="col calendar-week">
                            <div>Wed</div>
                          </div>
                          <div class="col calendar-week">
                            <div>Thu</div>
                          </div>
                          <div class="col calendar-week">
                            <div>Fri</div>
                          </div>
                          <div class="col calendar-week">
                            <div>Sat</div>
                          </div>
                          <div class="col calendar-week">
                            <div>Sun</div>
                          </div>
                        </div>
                        
                        @foreach($date_list as $index => $day)

                          {{-- Open a new week(row) if Monday  --}}
                          @if( $day['weekday'] === '1' ) {{-- Monday --}}
                            <div class="row">
                          @endif
                            <div class='col calendar-day'>

                            @if( $day['month'] !== date('m') )
                                <a class='date_number--no-current-month' href={{ action('BookingViewController@index', [
                                  'day' => $day['day'],
                                  'month' => $day['month'],
                                  'year' => $day['year'],
                                  ])}} >
                            @else
                                <a class='date_number' href={{ action('BookingViewController@index', [
                                  'day' => $day['day'],
                                  'month' => $day['month'],
                                  'year' => $day['year'],
                                  ])}} >
                            @endif
                                <time datetime="{{ $day['full'] }}">{{ $day['day'] }}</time>
                              </a>
                                  {{-- add bookings if they exist --}}
                                  @foreach( $bookings as $booking )
                                    @if ( $booking['date'] === $day['formatted'] && $booking['availability']=== 1) 
                                      <div class="events">
                                        <div class="event">
                                          <a href={{ route('booking.details', ['id' => $booking->id ])}}>{{ $booking['time'] }}</a>
                                        </div>
                                      </div>
                                    @endif
                                  @endforeach
                            </div>
                            

                          {{-- Close the week(row) if Sunday --}}
                          @if( $day['weekday'] === '0' )
                            </div>
                          @endif
                        @endforeach
                        
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
