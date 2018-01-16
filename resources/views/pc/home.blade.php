@extends('pc.layouts.app')

@section('content')
<home :attributes="{{ $dynamics }}" :specials="{{ $specials }}"></home>
@endsection
