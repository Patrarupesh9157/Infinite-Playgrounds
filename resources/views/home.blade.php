@extends('layouts.app')

@section('title', 'Home - Infinite Playgrounds Shop')

@section('content')
    @include('sections.banner')
    @include('sections.features')
    @include('sections.trending')
    @include('sections.most-played')
    @include('sections.categories')
    @include('sections.cta')
@endsection