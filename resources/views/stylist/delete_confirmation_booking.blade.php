@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Confirmation</div>
          <div class="card-body">
            <p class="card-text">Are you sure to delete the following booking?</p>
            
            <ul class='list-group list-group-flush my-3'>
              <li class='list-group-item'>Date : {{ $date }}</li>
              <li class='list-group-item'>Time : {{ $time }}</li>
              <li class='list-group-item'>Customer : {{ $booking->customer->first_name }} {{$booking->customer->last_name }}</li>
              <li class='list-group-item'>Menu : {{ $booking->treatment->name }}</li>
              <li class='list-group-item'>Phone : {{ $booking->customer->phone }}</li>
              <li class='list-group-item'>Email : {{ $booking->customer->email }}</li>
            </ul>
            <div class='row'>
              <form method='POST' 
                action={{ action('BookingViewController@destroy', ['id' => $id]) }}
                class='mx-auto'
              >
                @csrf
                @method('DELETE')
                <input type='hidden' name='id' value={{ $id }}>
                <input type='submit' value='Delete' class='btn btn-danger'>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection