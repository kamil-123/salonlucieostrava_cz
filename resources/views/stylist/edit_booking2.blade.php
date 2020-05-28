@extends('layouts.app')

@section('content')
  <div class='container'>
    <div class='row justify-content-center'>
      <div class='col-md-8'>
        <div class='card'>
          <div class='card-header'>Edit Booking</div>
          <div class='card-body justify-content-left'>
            <form action={{ action('BookingViewController@postEditTime') }} method='POST'>
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
                    @foreach ($free_slots as $free_slot)
                      @if ($free_slot === $time)
                        <option selected value={{ $free_slot }}>{{ $free_slot }}</option>
                      @else 
                        <option value={{ $free_slot }}>{{ $free_slot }}</option>
                      @endif
                    @endforeach
                  </select>
                </div>
              </div>

              {{-- Names --}}
              <div class="row mb-4">
                <div class="col">
                  <label for="first_name">First Name</label>
                  <input id='first_name' type="text" class="form-control" name="first_name" value={{ $customer->first_name }}>
                </div>
                <div class="col">
                  <label for="last_name">Last Name</label>
                  <input id='last_name' type="text" class="form-control" name="last_name" value={{ $customer->last_name }}>
                </div>
              </div>

              {{-- Phone --}}
              <div class="row">
                <div class="form-group col-md-8">
                  <label for="phone_number">Phone</label>
                  <input id='phone_number' type="tel" class="form-control" name="phone" value={{ $customer->phone }}>
                </div>
              </div>

              {{-- Email --}}
              <div class="row">
                <div class="form-group col-md-8">
                  <label for="email_address">Email</label>
                  <input id='email_address' type="email" class="form-control" name="email" value={{ $customer->email }}>
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