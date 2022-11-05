@extends('layouts.admin')

{{-- Page same pageId will same js, css --}}
@section('pageId', 'adAccount')

@section('content')
    @include('admin.bm.components.ada_ignore_ids')
    @include('admin.bm.components.ad_account_list')
@endsection

@section('head')
    @jsData([
    'bmData' => $bmData,
    'userId' => $userId,
    'adaIgnoreIds' => $adaIgnoreIds
    ])
@endsection
