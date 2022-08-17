@extends('layouts.admin')

{{-- Page same pageId will same js, css --}}
@section('pageId', 'actIndex')

@section('content')
    @include('admin.act.components.create')
    @include('admin.act.components.list')
@endsection

@section('head')
    @jsData([
    'acts' => $acts,
    'userId' => $userId,
    ])
@endsection
