@extends('layouts.admin')

{{-- Page same pageId will same js, css --}}
@section('pageId', 'orderIndex')

@section('content')
    @include('admin.order.components.create')
    @include('admin.order.components.list')
@endsection

@section('head')
    @jsData([
    'orders' => $orders,
    'products' => $products,
    ])
@endsection
