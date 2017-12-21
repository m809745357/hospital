@extends('mobile.layouts.app')

@section('content')
<parcel-index :attributes="{{ $parcels }}" :other="{{ $ipad }}"></parcel-index>
@endsection