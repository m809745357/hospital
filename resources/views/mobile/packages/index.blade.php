@extends('mobile.layouts.app')

@section('content')
<package-index :attributes="{{ $packages }}"></package-index>
@endsection