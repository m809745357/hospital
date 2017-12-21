@extends('mobile.layouts.app')

@section('content')
<order-show :attributes="{{ $order }}" :other="{{ $ipad }}"></order-show>
@endsection