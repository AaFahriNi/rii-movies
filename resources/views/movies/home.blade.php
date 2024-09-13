@extends('layouts.app')

@section('content')
    @include('movies.index')
    @include('movies.trending')
    @include('movies.movie')
    @include('movies.coming-soon')
@endsection