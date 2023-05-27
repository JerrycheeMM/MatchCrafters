@extends('layouts.master')

@prepend('scripts')
    <script src="{{ mix('js/app.js') }}"></script>
@endprepend

@section('header')
    @include('partials.header')
@stop

@section('footer')
    @include('partials.footer')
@stop

@section('page.class', 'page-main')

@section('content')
    @include('partials.calculator')
@append
