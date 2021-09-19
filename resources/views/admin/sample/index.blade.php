@extends('layouts.frontend')

{{-- Page same pageId will same js, css --}}
@section('pageId', 'exampleIndex')

@section('content')
    <main class="main">
        {{ $content }}

        <input name="test" value="@value('test', $test, 1111)" />
    </main>
@endsection

{{-- Send data to js file --}}
@section('head')
    @jsData([
        'sampleData' => 'You have this value in js file by variable global.sampleData',
    ])
@endsection
