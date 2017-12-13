@extends('mobile.layouts.app')

@section('content')
<advance-index :attributes="{{ $schedulings }}"></advance-index>
@endsection