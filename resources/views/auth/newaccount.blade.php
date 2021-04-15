@extends('layouts.spa')

@section('content')
<div id="app">
<view-create-password token="{{ $token }}" email="{{ $email }}"></view-create-password>
</div>
@endsection
