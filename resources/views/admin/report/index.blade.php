@extends('layouts.admin')

{{-- Page same pageId will same js, css --}}
@section('pageId', 'reportIndex')

@section('content')
    @include('admin.report.components.create')
    @include('admin.report.components.list')
@endsection

@section('head')
    @jsData([
    'reports' => $reports,
    'products' => $products,
    'months' => $months,
    'sources' => $sources,
    'loggedUser' => $loggedUser,
    'monthsInFilter' => $monthsInFilter,
    'usersInFilter' => $usersInFilter,
    'productsInFilter' => $productsInFilter,
    ])
@endsection
