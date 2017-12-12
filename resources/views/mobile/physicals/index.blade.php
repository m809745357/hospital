@extends('mobile.layouts.app')

@section('content')
<physical-index :attributes="{{ $physicals }}"></physical-index>
@endsection