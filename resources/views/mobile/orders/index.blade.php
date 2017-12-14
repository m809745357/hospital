@extends('mobile.layouts.app')

@section('content')
<order-index :attributes="{{ $orders }}"></order-index>
@endsection