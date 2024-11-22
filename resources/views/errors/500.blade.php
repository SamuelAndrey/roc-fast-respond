@extends('themes.layout-errors')

@section('title', __('Server Error'))
@section('code[0]', '5')
@section('code[1]', '0')
@section('code', '500')
@section('name', 'Internal Server Error')
@section('message-core', 'Something Wrong..') 
@section('message', ('We’re sorry, but something went wrong on our side. 
          Please try again in a few minutes,contact support if the issue persists.'))
