@extends('themes.layout-errors')

@section('title', __('Forbidden'))
@section('code[0]', '4')
@section('code[1]', '3')
@section('code', '403')
@section('name', 'Forbidden')
@section('message-core', 'Stop there !!')
@section('message', ('Sorry, you’re not allowed to access this page. Try logging in with the correct account 
          or contact support if needed.'))
