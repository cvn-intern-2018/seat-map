@extends('frame')

@section('title')
Hello World!
@endsection

@section('main')
<main class="content">
    <h1>This is the content.</h1>
    @isset($variable)
    <p>{{ $variable }}</p>
    @endisset
</main>
@endsection