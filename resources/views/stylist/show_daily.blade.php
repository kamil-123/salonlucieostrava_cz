@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 mb-2">
            <div class="card">
                <div class="card-header">Schedule</div>
                <div class="card-body">
                    <h3>{{ date("j F Y, D", mktime(0,0,0, $month, $day, $year)) }}</h3>
                    {{-- <p class="card-text"></p> --}}

                    <div id="table" class="table-editable">
                        <span class="table-add float-right mb-3 mr-2">
                            <a href="#!" class="text-success">
                                <i class="fas fa-plus fa-2x" aria-hidden="true"></i>
                            </a>
                        </span>

                        @if ($message !== '')
                            <div class="row d-flex my-4">   
                                <div class='mx-auto'>{{ $message }}</div>
                            </div>
                        @endif

                        <table class="table table-bordered table-responsive-md table-striped text-center">
                            <thead>
                                <tr>
                                <th class="text-center">Time</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Information</th>
                                <th class="text-center">Book</th>
                                <th class="text-center">Block</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($full_schedule[$date] as $timeslot => $info)
                                    <tr>
                                        <td class="pt-3-half" contenteditable="true">{{ $timeslot }}</td>
                                        <td class="pt-3-half" contenteditable="true">
                                            {{
                                                isset($info['availability']) ? ($info['availability'] === 1 ? 'Booked' : 'Blocked')
                                                : 'Available' 
                                            }}
                                        </td>
                                        <td>
                                            @if ( isset($info['availability']) )
                                                @if ($info['availability'] === 1) 
                                                    <a href={{ route('booking.details', ['id' => $info['booking_id'], 'timeslot' => $timeslot]) }}>Details</a></td>
                                                @endif
                                            @endif
                                        <td>
                                            <span class="table-remove">
                                                @if ( isset($info['availability']) )
                                                    @if  ($info['availability'] === 0) 
                                                        Blocked
                                                    @endif
                                                @else 
                                                    <form
                                                        method='GET'
                                                        action={{ action('BookingViewController@create', [ 'timeslot' => $timeslot ]) }}
                                                        class="mx-auto";
                                                    >
                                                        <input type='submit' value='Book' class='btn btn-primary'>
                                                    </form>
                                                @endif

                                            </span>
                                        </td>
                                        <td>
                                            <span class="table-remove">
                                                @if ( isset($info['availability']) )

                                                    @if ( $info['availability'] === 0 )  {{-- Blocked --}}
                                                        <form 
                                                        method='POST' 
                                                        action={{ action('BookingViewController@destroy', ['id' => $info['booking_id']]) }}
                                                        class='mx-auto'
                                                        >
                                                            @csrf
                                                            @method('DELETE')
                                                            <input type='submit' value='Unblock' class='btn btn-warning'>
                                                        </form>
                                                    @endif

                                                @else {{--  Available --}}
                                                    <form
                                                        action={{ action('BookingViewController@block', ['timeslot' => $timeslot, 'date' => array_keys($full_schedule)[0]] ) }}
                                                        class="mx-auto"
                                                        method="POST"
                                                    >
                                                        @csrf
                                                        <input type="hidden" name="timeslot" value="{{ $timeslot }}">
                                                        <input type='submit' value='Block' class='btn btn-danger'>
                                                    </form>
                                                @endif
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection