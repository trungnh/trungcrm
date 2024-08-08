@extends('layouts.admin')

{{-- Page same pageId will same js, css --}}
@section('pageId', 'productEdit')

@section('content')
    @include('admin.product.components.edit')
@endsection

@section('head')
    @jsData([
    'product' => $product,
    'loggedUser' => $loggedUser,
    ])
@endsection
