@extends('mobile.layouts.app')

@section('content')
<promoter-confirm :attributes="{{ $promoterRecords }}"></promoter-confirm>
@endsection