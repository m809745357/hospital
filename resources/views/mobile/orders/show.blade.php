@extends('mobile.layouts.app')

@section('content')
<order-show :attributes="{{ $order }}"></order-show>
@endsection