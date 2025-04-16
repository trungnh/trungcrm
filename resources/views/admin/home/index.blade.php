@extends('layouts.admin')

{{-- Page same pageId will same js, css --}}
@section('pageId', 'homeIndex')

@section('content')
    @include('admin.home.content.main')
    @include('admin.home.content.table')
@endsection

@section('head')
    @jsData([
    'reportsOfLastMonth' => $reportsOfLastMonth,
    'reportsOfThisMonth' => $reportsOfThisMonth,
    'thisMonthReportItemsTable' => $thisMonthReportItemsTable,
    'monthsInFilter' => $monthsInFilter,
    'usersInFilter' => $usersInFilter,
    'loggedUser' => $loggedUser
    ])
@endsection
