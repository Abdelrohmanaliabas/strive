@extends('layouts.employer')

@section('title','Employer Dashboard')

@section('content')
<h3>Welcome, {{ Auth::user()->name ?? 'Employer' }}</h3>

@endsection
