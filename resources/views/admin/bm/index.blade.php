@extends('layouts.admin')

{{-- Page same pageId will same js, css --}}
@section('pageId', 'bmIndex')

@section('content')
    @include('admin.bm.components.create')
    @include('admin.bm.components.list')
@endsection

@section('head')
    @jsData([
    'bms' => $bms,
    ])
@endsection
