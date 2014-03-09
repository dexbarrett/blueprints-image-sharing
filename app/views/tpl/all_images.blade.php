@extends('frontend_master')

@section('content')
@if(count($images))
<ul>
    @foreach($images as $image)
        <li>
            <a href="{{ URL::to('snatch/' . $image->id) }}">
                {{ HTML::image(Config::get('image.thumb_folder') . '/' . $image->image) }}
            </a>
        </li>
    @endforeach
</ul>
<p>{{ $images->links() }}</p>
@else
    <p>No images uploaded yet, {{ HTML::link('/', 'care to upload one?') }}</p>
@endif
@stop