@extends('themes.layout-errors')

@section('title', __('Unauthorized'))
@section('code[0]', '4')
@section('code[1]', '1')
@section('code', '401')
@section('name', 'Unauthorized')
@section('message-core', 'Access denied!') 
@section('message', ('You need valid authentication to access this page.
          If you believe this is a mistake, please contact the administrator'))
