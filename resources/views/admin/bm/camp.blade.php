@extends('layouts.admin')

{{-- Page same pageId will same js, css --}}
@section('pageId', 'bmCamp')

@section('content')
    @include('admin.bm.components.camp')
@endsection

@section('head')
    @jsData([
    'bmData' => $bmData,
    ])
@endsection
