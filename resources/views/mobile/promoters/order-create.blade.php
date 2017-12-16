@extends('mobile.layouts.app')

@section('content')
<promoter-order-create :attributes="{{ $departments }}"></promoter-order-create>
@endsection