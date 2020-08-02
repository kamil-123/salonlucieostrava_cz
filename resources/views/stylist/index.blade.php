@extends('layouts.app')

@section('content')
  <div class='container'>
    <div class='row justify-content-center'>
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Stylist list</div>
          <div class="card-body">
            {{-- show error message if error basicly comment not filled --}}
            @if (count($errors) > 0)        
              <div class="alert alert-danger">
                <ul>      
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                 @endforeach
                </ul>
              </div>
            @endif
            {{-- show success message when comment is stored --}}
            @if(Session::has('success_message'))
              <div class="alert alert-success">
                {{ Session::get('success_message') }}
              </div>
            @endif
            <div id="table" class="table-editable">
              <span class="table-add float-right mb-3 mr-2"><a href="#!" class="text-success"><i 
                class="fas fa-plus fa-2x" aria-hidden="true"></i></a></span>
              <table class="table table-bordered table-responsive-md table-striped text-center">
                <thead>
                  <tr>
                  <th class="text-center">Photo</th>
                  <th class="text-center">Name</th>
                  <th class="text-center">Job title</th>
                  <th class="text-center">Service</th>
                  <th class="text-center">Edit</th>
                  <th class="text-center">Delete</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($stylists as $stylist)
                    <tr>
                      <th class="pt-3-half"><img src="{{ asset('/images/stylists/') }}/{{$stylist->profile_photo_url}}" alt="Photo {{ $stylist->user->first_name .' '. $stylist->user->last_name }}" class="stylist__image"></th>
                      <td class="pt-3-half">{{ $stylist->user->first_name .' '. $stylist->user->last_name }}</td>
                      <td class="pt-3-half">{{ $stylist->job_title }}</td>
                      <td class="pt-3-half">{{ $stylist->service }}</td>
                      <td>
                        <span class="table-remove">
                        <a href="{{action('StylistController@edit',[$stylist->id])}}"><button type="button" class="btn btn-primary btn-rounded btn-sm my-0" id="btnedit{{$stylist->id}}">Edit</button></a>
                        </span>
                      </td>
                      <td>
                        <span class="table-remove">
                          <form action={{action('StylistController@remove')}} method="POST">
                            @method('delete')
                            @csrf
                            <input type="hidden" name="stylist_id" value={{ $stylist->id }}>
                            
                            <input type="submit" class="btn btn-danger btn-rounded btn-sm my-0" value="Delete">
                          </form>
                        </span>
                      </td>
                   </tr>
                  @endforeach
                                 
                </tbody>
              </table>
              {{-- <div class='row my-4 justify-content-between'> --}}
                <a href="{{action('StylistController@create')}}" class="row my-4 justify-content-between">       
                  <button class="btn btn-success my-3 mx-auto col-4">
                    Add new stylist
                  </button>
                </a>
              {{-- </div>     --}}
            </div>
          </div>  
        </div>
      </div>
    </div>
  </div>

@endsection