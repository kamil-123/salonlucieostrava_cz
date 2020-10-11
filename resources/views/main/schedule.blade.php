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
        <form class="scheduleform" action="" method="POST">
            @csrf
            <div class="schedule-wrap">
            @foreach($resultScheduleTemplate as $date => $values)
                <div class="schedule-day">
                    <div class="schedule-day__name">
                        {{ $values['name'] }}
                    </div>
                    @foreach ($values['time'] as $time => $availability)
                        <div class="schedule-day__time {{ $availability === null ? '' : 'schedule-day--disabled'}}">
                            <input type="radio" name="selected_time" id="{{ $date.'_'.$time}}" value="{{ $date .' '. $time }}" {{ $availability === null ? '' : 'disabled'}}>
                            <label for="{{ $date.'_'.$time }}" class="{{ $availability === null ? '' : 'label-disabled'}}">{{ substr($time, 0, 5) }}</label>
                        </div>
                    @endforeach
                </div>
            @endforeach
            </div>
            <label for="name">Jméno a příjmení:</label>
            <input type="text" id="name" name="name">
            <label for="email">Email:</label>
            <input type="text" id="email" name="email">
            <label for="phone">Telefon:</label>
            <input type="text" id="phone" name="phone">
            <input type="submit" value="OBJEDNAT">
        </form>

    </div>





@endsection
