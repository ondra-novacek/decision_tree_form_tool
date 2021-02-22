@extends('layouts.app')

@section('title', 'DT tool')

@section('content')
    <div id="app">
        <router-view :user={{Auth::user()}}></router-view>
    </div>    
@endsection
