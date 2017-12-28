@extends('mobile.layouts.app')

@section('content')
<promoter-record :attributes="{{ $promoterRecords}}" message="{{ $message }}"></promoter-record>
@endsection