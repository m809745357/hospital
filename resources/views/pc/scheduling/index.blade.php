@extends('layouts.app')

@section('content')
<scheduling-index :attributes="{{ $doctors }}" :categories="{{ $departments }}"></scheduling-index>
@endsection