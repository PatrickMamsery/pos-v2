@extends('layouts.app')

@section('title', 'Purchases')
@section('content-header', 'Purchases')

@section('css')
<link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">
@endsection
@section('content')
@livewire('purchase')
@endsection
