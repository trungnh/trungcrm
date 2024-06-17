@extends('layouts.admin')

{{-- Page same pageId will same js, css --}}
@section('pageId', 'reportEdit')

@section('content')
    @include('admin.report.components.info')
    @include('admin.report.components.table')
@endsection

@section('head')
    @jsData([
    'report' => $report,
    'loggedUser' => $loggedUser,
    ])
@endsection
