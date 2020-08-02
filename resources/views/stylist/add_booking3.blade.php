@extends('layouts.app')

@section('content')
<div class='container'>
  <div class='row justify-content-center'>
    <div class='col-md-8'>
      <div class='card'>
        <div class='card-header'>New Booking</div>
        <div class='card-body justify-content-left'>

          <div class='card'>
            <div class="card-body">
              <p class="card-text">Do you want to place the following order?</p>

              <ul class='list-group list-group-flush'>
                <li class='list-group-item'>
                  <img class='mr-3' src='{{ asset('/images/icons/clock.png') }}' alt='time' style='width:1.3rem' >
                  {{ $inputs['booking']->start_at }}
                </li>
                <li class='list-group-item'>
                  <img class='mr-3' src='{{ asset('/images/icons/scissor.png') }}' alt='time' style='width:1.3rem' >
                    {{ $inputs['treatment']->name }}
                </li>
                <li class='list-group-item'>
                  <img class='mr-3' src='{{ asset('/images/icons/user.png') }}' alt='time' style='width:1.3rem' >
                    {{ $inputs['customer']->first_name }} {{ $inputs['customer']->last_name }}
                </li>
                <li class='list-group-item'>
                  <img class='mr-3' src='{{ asset('/images/icons/phone.png') }}' alt='time' style='width:1.3rem' >
                    {{ $inputs['customer']->phone }}
                </li>
                <li class='list-group-item'>
                  <img class='mr-3' src='{{ asset('/images/icons/mail.png') }}' alt='time' style='width:1.3rem' >                
                    {{ $inputs['customer']->email }}
                </li>
              </ul>
            </div>
          </div>

          <form action={{ action('BookingViewController@postCreateBooking') }} method='POST'>
            @csrf

            @if (\Session::has('success'))
              <div class="alert alert-success">
                <p>{{ \Session::get('success') }}</p>
              </div><br />
            @endif
            {{-- Submit --}}
            <div class="row">
              <div class="col-md-4 d-flex"></div>
              <div class="form-group col-md-4 d-flex"  style="margin-top:60px">
                <input 
                  type="submit"
                  class="btn btn-success mx-auto"
                  value="Book"
                >
              </div>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</div> 
@endsection