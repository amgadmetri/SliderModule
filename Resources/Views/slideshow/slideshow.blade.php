@extends('app')
@section('content')

<div class="container">
  <div class="col-sm-9">
              <a 
              class ="btn btn-default" 
              href  ='{{ url("admin/slider/slideshow/create", $sliderSlug ) }}' 
              role  ="button">
              Add Slide show
              </a> 
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Slide show id</th>
          <th>Slide show slug</th>
          <th>Slide show description</th>
          <th>Options</th>
        </tr>
      </thead>
      <tbody>
        @foreach($slideShows as $slide)
          <tr>
            <th>{{ $slide->id }}</th>
            <th>{{ $sliderSlug }}</th>
            <th>{!! $slide->description !!}</th>
            <th>
            @if(\CMS::permissions()->can('edit', 'SlideShows'))
                  <a class="btn btn-default" href='{{ url("admin/slider/slideshow/edit/$slide->id", $sliderSlug) }}' role="button">Edit</a>
            @endif

            @if(\CMS::permissions()->can('delete', 'SlideShows'))
                  <a class="btn btn-default" href='{{ url("admin/slider/slideshow/delete/$slide->id") }}' role="button">Delete</a>
            @endif

            @if(\CMS::permissions()->can('edit', 'SlideShows'))
              @if($slide->status == 'disabled')
                    <a class="btn btn-default" href='{{ url("admin/slider/slideshow/enable/$slide->id") }}' role="button">Enable</a>
              @else
                    <a class="btn btn-default active" href='{{ url("admin/slider/slideshow/disable/$slide->id") }}' role="button">Disable</a>
              @endif
            @endif

            @if(\CMS::permissions()->can('show', 'LanguageContents'))
              <a 
              class ="btn btn-default" 
              href  ='{{ url("admin/language/languagecontents/show/slide_show/$slide->id") }}'
              role  ="button">
              Translations
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