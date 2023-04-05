@extends('layouts.admin')

{{-- Page same pageId will same js, css --}}
@section('pageId', 'homeIndex')

@section('content')
    @include('admin.home.content.main')
@endsection

@section('head')
    @jsData([
    'reportsOfLastMonth' => $reportsOfLastMonth,
    'reportsOfThisMonth' => $reportsOfThisMonth,
    'monthsInFilter' => $monthsInFilter,
    ])
@endsection
