@extends('layouts.admin')

{{-- Page same pageId will same js, css --}}
@section('pageId', 'bmEdit')

@section('content')
    @include('admin.bm.components.edit')
@endsection

@section('head')
    @jsData([
    'bm' => $bm,
    'userId' => $userId,
    ])
@endsection
