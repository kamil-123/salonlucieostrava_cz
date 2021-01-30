@extends('layouts.app')

@section('content')

<div class='container'>
  <div class='row justify-content-center'>

      <div class='col-md-8'>
          <div class='card'>
              <div class='card-header'>Update stylist</div>
                <div class='card-body'>
                  @if (count($errors) > 0)
                    <div class="alert alert-danger">
                      <ul>
                        @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                        @endforeach
                      </ul>
                    </div>
                  @endif
                  {{-- <p class='card-text'> </p> --}}
                  <ul class='list-group list-group-flush'>
                    <form action={{ action('StylistController@update') }} method="POST" enctype="multipart/form-data">
                      @method('put')
                      @csrf
                      {{-- First Name --}}
                      <li class='list-group-item stylist__item'>
                        <img class='mr-3' src='{{ asset('/images/icons/user.png') }}' alt='User icon' style='width:1.3rem' >
                        <label for="first_name" class="stylist__label">First name: </label>
                        <input type="text" name="first_name" id="" class="form-control stylist__input" value="{{old('first_name', $stylist->user->first_name)}}">
                      </li>
                      {{-- Last Name --}}
                      <li class='list-group-item stylist__item'>
                        <img class='mr-3' src='{{ asset('/images/icons/user.png') }}' alt='User icon' style='width:1.3rem' >
                        <label for="last_name" class="stylist__label">Last name: </label>
                        <input type="text" name="last_name" id="" class="form-control stylist__input" value="{{old('last_name', $stylist->user->last_name)}}">
                      </li>
                       {{-- Password --}}
                       <li class='list-group-item stylist__item'>
                        <img class='mr-3' src='{{ asset('/images/icons/user.png') }}' alt='User icon' style='width:1.3rem' >
                        <label for="password" class="stylist__label">Password: </label>
                        <input type="password" name="password" id="" class="form-control stylist__input" value="{{old('password')}}">
                      </li>
                      {{-- Phone --}}
                      <li class='list-group-item stylist__item'>
                        <img class='mr-3' src='{{ asset('/images/icons/phone.png') }}' alt='Phone icon' style='width:1.3rem' >
                        <label for="phone" class="stylist__label">Phone: </label>
                        <input type="text" name="phone" id="" class="form-control stylist__input" value="{{old('phone', $stylist->user->phone)}}">
                      </li>
                       {{-- Email --}}
                       <li class='list-group-item stylist__item'>
                        <img class='mr-3' src='{{ asset('/images/icons/mail.png') }}' alt='Email icon' style='width:1.3rem' >
                        <label for="phone" class="stylist__label">Email: </label>
                        <input type="text" name="email" id="" class="form-control stylist__input" value="{{old('email',$stylist->user->email)}}">
                      </li>
                      {{-- Photo --}}
                      <li class='list-group-item stylist__item'>
                        <img class='mr-3' src='{{ asset('/images/icons/photo.png') }}' alt='Photo icon' style='width:1.3rem' >
                        <label for="photo" class="stylist__label">Photo: </label>
                        <input type="file" name="photo" id="" class="form-control stylist__input" value="{{old('photo')}}">
                      </li>
                      {{-- Stylist job--}}
                      <li class='list-group-item stylist__item'>
                        <img class='mr-3' src='{{ asset('/images/icons/scissor.png') }}' alt='Scissorr icon' style='width:1.3rem' >
                        <label for="job" class="stylist__label">Job position: </label>
                        <input type="text" name="job" id="" class="form-control stylist__input" value="{{old('job',$stylist->job_title)}}">
                      </li>
                      {{-- Service --}}
                      <li class='list-group-item stylist__item'>
                        <img class='mr-3' src='{{ asset('/images/icons/scissor.png') }}' alt='Scissorr icon' style='width:1.3rem' >
                        <label for="service" class="stylist__label">Service: </label>
                        <input type="text" name="service" id="" class="form-control stylist__input" value="{{old('service', $stylist->service)}}">
                      </li>
                      {{-- Description --}}
                      <li class='list-group-item stylist__item'>
                        <img class='mr-3' src='{{ asset('/images/icons/scissor.png') }}' alt='Scissorr icon' style='width:1.3rem' >
                        <label for="service" class="stylist__label">Introduction: </label>
                        <textarea name="introduction" id="" class="form-control stylist__input">{{old('introduction',$stylist->introduction)}}</textarea>
                      </li>
                      <input type="hidden" name="stylist_id" value="{{$stylist->id}}">
                      <div class='row my-4 justify-content-between'>

                        <input type="submit" value="Update Stylist" class="btn btn-success my-3 mx-auto col-4">
                      </div>
                  </form>
                </ul>
              </div>
          </div>
      </div>
  </div>
</div>

@endsection
