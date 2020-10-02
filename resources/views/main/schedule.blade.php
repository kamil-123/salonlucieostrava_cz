@extends('layouts.app')

@section('content')
    <div class="saloonPage">
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
    <div class="services" id="services">
        <h1>Služby a ceník</h1>
        <div class="schedule-wrap">

            @foreach($resultScheduleTemplate as $k => $v)
                <div>
                    {{ $v['name'] }}
                    @foreach ($v['time'] as $key => $value)
                        {{ $key . ' => ' . $value }}

                    @endforeach
                </div>
            @endforeach
        </div>

    </div>





@endsection
