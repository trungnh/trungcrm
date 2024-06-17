@extends('layouts.admin')

{{-- Page same pageId will same js, css --}}
@section('pageId', 'productIndex')

@section('content')
    @include('admin.product.components.create')
    @include('admin.product.components.list')
@endsection

@section('head')
    @jsData([
    'products' => $products,
    'loggedUser' => $loggedUser
    ])
@endsection
