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
      <a class="mainbutton mainbutton--order" href="{{ route('saloon')}}#services">OBJEDNAT</a>
      
    </div>
  </div>
  <div class="services" id="services">
    <h1>Služby a ceník</h1>
    @foreach ($stylists as $stylist)
      <div class="stylisttreatment">
        <div class="stylistbox">
          <img src="{{ asset('/images/stylists/') }}/{{$stylist->profile_photo_url}}" alt="Photo {{ $stylist->user->first_name .' '. $stylist->user->last_name }}" class="stylistbox__image">
          <p> <strong>{{ $stylist->user->first_name .' '. $stylist->user->last_name }}</strong><br>
              {{-- {{ $stylist->job_title }} <br> --}}
              {{ $stylist->service }} <br>
          </p>
        </div>
        <div class="treatmentbox">
          <form action="" method="POST">
            @foreach ($stylist->treatments as $treatment)
              <input type="radio" name="treatment" id="{{$treatment->id}}"  value="{{$treatment->id}}" {{$stylist->active === 1 ? '' : 'disabled'}}>
              <label for="{{$treatment->id}}" class="trname">{{$treatment->name}}</label>
              <label for="{{$treatment->id}}" class="trprice">{{$treatment->price}} Kč</label>
              <br>    
            @endforeach
            @if ($stylist->active === 1)
              @csrf
              <input type="hidden" name="stylist" value="{{ $stylist->id }}">
              <input type="submit" class="orderbutton" value="OBJEDNAT">    
            @else
              <strong>Bohužel, není možné se objednat.</strong>
            @endif
              
          </form>
        </div>
      </div>    
    @endforeach
    
  </div>
  <div class="findmehere" id="findmehere">
    <h1>Kde nás najdete?</h1>
    <div style="width: 100%"><iframe width="100%" height="300" src="https://maps.google.com/maps?width=100%&amp;height=300&amp;hl=en&amp;q=Velka%2012%2C%20Ostrava+(Sal%C3%B3n%20Lucie)&amp;ie=UTF8&amp;t=&amp;z=18&amp;iwloc=B&amp;output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"><a href="https://www.maps.ie/draw-radius-circle-map/">km radius map</a></iframe></div><br />
  </div>
  <div class="contact" id="contact">
    <h1>Kontakt</h1>
    @foreach ($stylists as $stylist)
      @if ($stylist->user->role === 1)
        <img src="{{ asset('/images/stylists/') }}/{{$stylist->profile_photo_url}}" alt="Photo {{ $stylist->user->first_name .' '. $stylist->user->last_name }}" class="contact__image">  
        <p> 
          <strong>Majitelka</strong><br>
          <strong>{{ $stylist->user->first_name .' '. $stylist->user->last_name }}</strong><br>
          {{ $stylist->user->phone }}<br>
          {{ $stylist->user->email }}
        </p>  
      @endif
        
    @endforeach
  </div>  
  

  

@endsection