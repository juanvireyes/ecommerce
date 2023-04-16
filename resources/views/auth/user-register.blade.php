@extends('userRegisterLayout')

@if (Route::currentRouteName() == 'register')
    @section('register-action', route('register'))
@elseif (Route::currentRouteName() == 'saregister')
    @section('register-action', route('saregister'))
@else
    @section('register-action', route('adminregister'))
@endif