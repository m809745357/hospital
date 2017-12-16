@extends('mobile.layouts.app')

@section('content')
<promoter-show :attributes="{{ $promoter }}"></promoter-show>
@endsection