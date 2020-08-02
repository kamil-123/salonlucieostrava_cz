@extends('layouts.app')

@section('content')
<div class='container'>
    <div class='row justify-content-center'>

        <div class='col-md-8'>
            <div class='card'>
                <div class='card-header'>Treatment edit</div>
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
                      <form action={{ action('TreatmentController@update') }} method="POST">
                        @method('put')
                        @csrf
                        {{-- Name --}}
                        <li class='list-group-item treatment__item'>
                          <img class='mr-3' src='{{ asset('/images/icons/scissor.png') }}' alt='Treatment name' style='width:1.3rem' >
                          <label for="name" class="treatment__label">Name: </label> 
                          <input type="text" name="name" id="" class="form-control treatment__input" value="{{old('name',$treatment->name)}}"> 
                        </li>
                        {{-- Price --}}
                        <li class='list-group-item treatment__item'>
                          <img class='mr-3' src='{{ asset('/images/icons/money.png') }}' alt='Treatment price' style='width:1.3rem' >
                          <label for="name" class="treatment__label">Price: </label> 
                          <input type="text" name="price" id="" class="form-control treatment__input" value="{{old('price',$treatment->price)}}"><span style="margin-left : 0.5em">CZK</span>
                        </li>
                        <li class='list-group-item treatment__item'>
                          <img class='mr-3' src='{{ asset('/images/icons/clock.png') }}' alt='Treatment duration' style='width:1.3rem' >
                          <label for="name" class="treatment__label">Duration: </label> 
                          {{-- <input type="text" name="duration" id="" class="form-control treatment__input" value="{{old('duration',$treatment->duration)}}"> --}}
                          <select name="duration" id="duration" class="form-control treatment__input">
                            <option value="00:30:00" {{old('duration',$treatment->duration) === '00:30:00' ? 'selected' : ''}}>00:30:00</option>
                            <option value="01:00:00" {{old('duration',$treatment->duration) === '01:00:00' ? 'selected' : ''}}>01:00:00</option>
                            <option value="01:30:00" {{old('duration',$treatment->duration) === '01:30:00' ? 'selected' : ''}}>01:30:00</option>
                            <option value="02:00:00" {{old('duration',$treatment->duration) === '02:00:00' ? 'selected' : ''}}>02:00:00</option>
                            <option value="02:30:00" {{old('duration',$treatment->duration) === '02:30:00' ? 'selected' : ''}}>02:30:00</option>
                            <option value="03:00:00" {{old('duration',$treatment->duration) === '03:00:00' ? 'selected' : ''}}>03:00:00</option>
                          </select>
                        </li>
                        <div class='row my-2 justify-content-between'>
                          <input type="hidden" name="treatment_id" value="{{$treatment->id}}">
                          <input type="submit" value="Update" class="btn btn-secondary my-3 mx-auto col-2">
                        </div>
                    </form>
                  </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection