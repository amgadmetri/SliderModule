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
    
    <div class="form-group">
      <label for="widget_image">Widget Image</label>
      @if($slideShow->slideShowImage)
        <a href="{{ url('admin/gallery/show', $slideShow->slideShowImage->id) }}" target="_blank">
          <img class="img-responsive" src="{{ $slideShow->slideShowImage->path }}" width="200" height="200" id="widget_image">
        </a>
      @else
        <img class="img-responsive" src="http://placehold.it/900x300" width="200" height="200" id="widget_image">
      @endif
      <br>
      {!! $sliderImageMediaLibrary !!}
    </div>

  <form method="post" id="slideshow_form">  
    <input name="_token" type="hidden" value="{{ csrf_token() }}">
    <input type="hidden" name="image_id" value="{{ $slideShow->image_id }}" >
    <input type="hidden" name="slider_id" value="{{ $slider->id }}">

    <div class="form-group">
      <label for="link">Link:</label>

      <div class="input-group">
        <span class="input-group-addon">@</span>
        <input 
        type             ="text" 
        class            ="form-control" 
        name             ="link"
        @if ($slideShow->link ==='#')
        value           ="{{''}}" 
        @else
        value           ="{{ $slide->link }}"
        @endif  
        placeholder      ="Add Link here or choos from below .." 
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
      value            ="{{ $slideShow->description }}" 
      placeholder      ="Widget Description .." 
      aria-describedby ="sizing-addon2"
      >
    </div>


    <div class="form-group">
      <label for="status">Published:</label>
      <select  name  ="status" class="form-control">
        <option @if($slideShow->status === "enabled") selected @endif  value ="enabled">Enabled</option>
        <option @if($slideShow->status === "disabled") selected @endif  value ="disabled">Disabled</option>
      </select>
    </div>

    <div class="form-group">
      <label for="display_order">Display Order:</label>
      <input 
      type             ="text" 
      class            ="form-control" 
      name             ="display_order" 
      value            ="{{ $slideShow->display_order }}" 
      placeholder      ="Add display order here .." 
      aria-describedby ="sizing-addon2"
      >
    </div>



    <button type="submit" class="btn btn-primary form-control">Update Slide</button>
  </form>
</div>  
</div>

@include('slider::slideshow.assets.createslideimage')
@stop