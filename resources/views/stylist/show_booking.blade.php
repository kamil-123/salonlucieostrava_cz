@extends('layouts.app')

@section('content')
<div class='container'>
    <div class='row justify-content-center'>

        <div class='col-md-8'>
            <div class='card'>
                <div class='card-header'>Booking Details</div>
                <div class='card-body'>
                <h4>{{ $date }}</h4>
                <p class='card-text'> </p>

                  <ul class='list-group list-group-flush'>
                      <li class='list-group-item'>
                        <img class='mr-3' src='{{ asset('/images/icons/clock.png') }}' alt='time' style='width:1.3rem' >
                        {{ $time }}
                      </li>
                      <li class='list-group-item'>
                        <img class='mr-3' src='{{ asset('/images/icons/scissor.png') }}' alt='time' style='width:1.3rem' >
                        @if ($booking->treatment)
                          {{ $booking->treatment->name }}
                        @endif
                      </li>
                      <li class='list-group-item'>
                        <img class='mr-3' src='{{ asset('/images/icons/user.png') }}' alt='time' style='width:1.3rem' >
                        @if ($booking->customer)
                          {{ $booking->customer->first_name }} {{ $booking->customer->last_name }}
                        @endif
                      </li>
                      <li class='list-group-item'>
                        <img class='mr-3' src='{{ asset('/images/icons/phone.png') }}' alt='time' style='width:1.3rem' >
                        @if ($booking->customer)
                          {{ $booking->customer->phone }}
                        @endif
                      </li>
                      <li class='list-group-item'>
                        <img class='mr-3' src='{{ asset('/images/icons/mail.png') }}' alt='time' style='width:1.3rem' >
                        @if ($booking->customer)
                          {{ $booking->customer->email }}
                        @endif
                      </li>
                      <div class='row my-2 justify-content-between'>
                        <a class='btn btn-secondary my-3 mx-auto col-2'
                          name='go_to_edit'
                          href={{ action('BookingViewController@edit', ['id' => $id, 'time' => $time]) }}
                        >
                          Edit
                        </a>
                        <a class='btn btn-danger my-3 mx-auto col-2'
                          name='go_to_edit'
                          href={{ action('BookingViewController@deleteConfirmation', ['id' => $booking->id]) }}
                        >
                          Delete
                        </a>
                      </div>
                    
                  </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
                