@extends('layouts.app')

@section('content')
<dynamic-show :attributes="{{ $dynamic }}"></dynamic-show>
@endsection