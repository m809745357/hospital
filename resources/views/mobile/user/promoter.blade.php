@extends('mobile.layouts.app')

@section('content')
<promoter-order :attributes="{{ $promoterOrders }}"></promoter-order>
@endsection