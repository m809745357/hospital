@extends('pc.layouts.app')

@section('content')
<dynamic-index :attributes="{{ $dynamics }}"></dynamic-index>
@endsection