@extends('layouts.admin')

{{-- Page same pageId will same js, css --}}
@section('pageId', 'actAccount')

@section('content')
    @include('admin.act.components.ad_account_list')
@endsection

@section('head')
    @jsData([
    'actData' => $actData,
    ])
@endsection
