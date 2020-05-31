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
      <a class="mainbutton mainbutton--order" href="#">OBJEDNAT</a>
      
    </div>
  </div>
  <div class="services">
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
          <table>
            @foreach ($stylist->treatments as $treatment)
            <tr>
              <td class="treatmentname">
                {{ $treatment->name }}
              </td>
              <td class="treatmentprice">
                {{ $treatment->price }} Kč
              </td>
            </tr>    
            @endforeach  
          </table>
        </div>
      </div>    
    @endforeach
    
  </div>

  

@endsection