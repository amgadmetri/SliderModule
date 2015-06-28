@extends('core::app')
@section('content')

<div class="container">
  <div class="col-sm-9">

    <table class="table table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>Title</th>
          <th>Description</th>
          <th>Options</th>
        </tr>
      </thead>
      <tbody>
        @foreach($sliders as $slider)
          <tr>
            <th>{{ $slider->id }}</th>
            <th>{{ $slider->title }}</th>
            <th>{{ $slider->description }}</th>
            <th>
               @if(\CMS::permissions()->can('change-status', 'Sliders'))
                      @if($slider->is_active == 0)
                        <a class="btn btn-default" href='{{ url("admin/slider/activate/$slider->id") }}' role="button">Activate</a>
                      @else
                        <a class="btn btn-default active" href='{{ url("admin/slider/deactivate/$slider->id") }}'  role="button">Deactivate</a>
                      @endif
                    @endif
                @if(\CMS::permissions()->can('show', 'Sliders'))
                <a 
                class ="btn btn-default" 
                href  ='{{ url("admin/slider/slideshow/show", $slider->slider_slug) }}' 
                role  ="button">
                Slide shows
                </a> 
              @endif
            </th>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@stop