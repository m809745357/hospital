@extends('layouts.app')

@section('content')
<special-index :attributes="{{ $specials }}"></special-index>
@endsection