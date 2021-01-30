@extends('layouts.mainapp')

@section('content')
  <div class="mainPage">
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
      <a class="mainbutton mainbutton--order" href="{{ route('saloon') }}#services">OBJEDNAT</a>
      <a class="mainbutton mainbutton--enter" href="{{ route('saloon') }}">VSTOUPIT</a>
    </div>
  </div>


@endsection
