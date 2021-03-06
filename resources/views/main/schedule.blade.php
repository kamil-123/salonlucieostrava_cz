@extends('layouts.app')

@section('content')
    <div class="schedulePage">
        <div class="mainbox">
            <div class="linename">
                <div class="linename__line"></div>
                <h3 class="linename__name">Lucie Baránková</h3>
                <div class="linename__line"></div>
            </div>
            <h2 class="salonname">SALÓN LUCIE</h2>
            <div class="linename">
                <div class="linename__line"></div>
                <h3 class="linename__name">Kadeřnictví v Ostravě</h3>
                <div class="linename__line"></div>
            </div>
        </div>
    </div>
    <div class="schedule" id="schedule">
        <h1>Výběr času</h1>
        <h4>{{ $treatment->name }} od {{ $stylist->user->first_name }} {{  $stylist->user->last_name }}</h4>
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form class="scheduleform" action="{{ action('MainController@orderCreate') }}" method="POST">
            @csrf
            <div class="schedule-wrap">
            @foreach($resultScheduleTemplate as $date => $values)
                <div class="schedule-day">
                    <div class="schedule-day__name">
                        {{ $values['name'] }}
                    </div>
                    @foreach ($values['time'] as $time => $availability)
                        <div class="schedule-day__time {{ $availability === null ? '' : 'schedule-day--disabled'}}">
                            <input type="radio" name="start_at" id="{{ $date.'_'.$time}}" value="{{ $date .' '. $time }}" {{ $availability === null ? '' : 'disabled'}}>
                            <label for="{{ $date.'_'.$time }}" class="{{ $availability === null ? '' : 'label-disabled'}}">{{ substr($time, 0, 5) }}</label>
                        </div>
                    @endforeach
                </div>
            @endforeach
            </div>
            <label for="first_name">Jméno:</label>
            <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}">
            <label for="last_name">Příjmení:</label>
            <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}">
            <label for="email">Email:</label>
            <input type="text" id="email" name="email" value="{{ old('email') }}">
            <label for="phone">Telefon:</label>
            <input type="text" id="phone" name="phone" value="{{ old('phone') }}">
            <input type="submit" value="OBJEDNAT">
        </form>

    </div>





@endsection
