@extends('mobile.layouts.app')

@section('content')
<package-show :attributes="{{ $package }}"></package-show>
@endsection