@extends('layouts.app')

@section('title', 'DT tool')

@section('content')
    <div id="app">
        <main-component :user={{Auth::user()}}></main-component>
    </div>    
@endsection
