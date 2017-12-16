@extends('mobile.layouts.app')

@section('content')
<promoter-record :attributes="{{ $promoterRecords}}"></promoter-record>
@endsection