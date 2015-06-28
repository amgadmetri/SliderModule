@extends('core::app')
@section('content')

<div class="container">
  <div class="col-sm-8">
    @if (count($errors) > 0)
    <div class="alert alert-danger">
      <strong>Whoops!</strong> There were some problems with your input.<br><br>
      <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    @if (Session::has('message'))
    <div class="alert alert-success">
      <ul>
        <li>{{ Session::get('message') }}</li>
      </ul>
    </div>
    @endif
    
    <div class="col-sm-12">
      <div class="col-sm-6">
       <div class="form-group">
        <label for="slider_image">Slide Image</label>
        <img class="img-responsive" src="http://placehold.it/200x200" width="200" height="200" id="slideshow_image">
        <br>
        {!! $sliderImageMediaLibrary !!}
      </div>
    </div>
  </div>

  <form method="post" id="slideshow_form">  
    <input name="_token" type="hidden" value="{{ csrf_token() }}">
    <input type="hidden" name="image_id">
    <input type="hidden" name="slider_id" value="{{ $slider->id }}">

    <div class="form-group">
      <label for="link">Link: <i>If you want to "#" it leave it blank </i></label>
      <div class="input-group">
        <span class="input-group-addon">@</span>
        <input 
        type             ="text" 
        class            ="form-control" 
        name             ="link" 
        value            ="{{ old('link') }}" 
        placeholder      ="Add Link here .." 
        aria-describedby ="sizing-addon2"
        id               ="link" 
        >
      </div>
    </div>

    <div class="form-group">
      <label for="description">Slide Description</label>
      <input 
      type             ="text" 
      class            ="form-control" 
      name             ="description" 
      value            ="{{ old('description') }}" 
      placeholder      ="Slide Description .." 
      aria-describedby ="sizing-addon2"
      >
    </div>

    <div class="form-group">
    <label for="status">Status:</label>
      <select name="status" class="form-control">
        <option value ="enabled">Enabled</option>
        <option value ="disabled">Disabled</option>
      </select>
    </div>

    <div class="form-group">
      <label for="display_order">Display Order:</label>
      <input 
      type             ="text" 
      class            ="form-control" 
      name             ="display_order" 
      value            ="{{ $maxDisplayOrder + 1 }}" 
      placeholder      ="Add display order here .." 
      aria-describedby ="sizing-addon2"
      >
    </div>



    <button type="submit" class="btn btn-primary form-control">Add Slide</button>
  </form>
</div>  
</div>

@include('slider::slideshow.assets.createslideimage')
@stop