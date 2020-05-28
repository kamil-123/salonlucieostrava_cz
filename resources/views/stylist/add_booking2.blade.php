@extends('layouts.app')

@section('content')
  <div class='container'>
    <div class='row justify-content-center'>
      <div class='col-md-8'>
        <div class='card'>
          <div class='card-header'>New Booking</div>
          <div class='card-body justify-content-left'>
            <form action={{ action('BookingViewController@postCreateTime') }} method='POST'>
              @csrf

              @if (\Session::has('success'))
                <div class="alert alert-success">
                  <p>{{ \Session::get('success') }}</p>
                </div><br />
              @endif

              {{-- Time  --}}
              <div class="row">
                <div class="form-group col-md-4">
                  <label for="time">Starting Time</label>
                  <select class="form-control" id="time" name='time'>
                    @foreach ($free_slots[$date] as $slot => $info)
                      @if ($slot === $timeslot)
                        <option selected value={{ $slot }}>{{ $slot }}</option>
                      @else 
                        <option value={{ $slot }}>{{ $slot }}</option>
                      @endif
                    @endforeach
                  </select> 
                </div>
              </div>

              {{-- Names --}}
              <div class="row mb-4">
                <div class="col">
                  <label for="first_name">First Name</label>
                  <input id='first_name' name='first_name' type="text" class="form-control" placeholder='First name'>
                </div>
                <div class="col">
                  <label for="last_name">Last Name</label>
                  <input id='last_name' name='last_name' type="text" class="form-control" placeholder='Last name'>
                </div>
              </div>

              {{-- Phone --}}
              <div class="row">
                <div class="form-group col-md-8">
                  <label for="phone_number">Phone</label>
                  <input id='phone_number' name='phone' type="tel" class="form-control" placeholder='Phone number'>
                </div>
              </div>

              {{-- Email --}}
              <div class="row">
                <div class="form-group col-md-8">
                  <label for="email_address">Email</label>
                  <input id='email_address' name='email' type="email" class="form-control" placeholder='Email address'>
                </div>
              </div>

              {{-- Submit --}}
              <div class="row">
                <div class="col-md-4 d-flex"></div>
                <div class="form-group col-md-4 d-flex"  style="margin-top:60px">
                  <input 
                    type="submit"
                    class="btn btn-success mx-auto"
                    value="Next"
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