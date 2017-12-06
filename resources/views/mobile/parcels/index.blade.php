@extends('mobile.layouts.app')

@section('content')
<parcel-index :attributes="{{ $parcels }}"></parcel-index>
@endsection