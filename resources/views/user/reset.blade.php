@extends('layouts.app')

@section('title' , __('user/reset.title_reset'))

@section('stylesheet')
    <link rel="stylesheet" href="{{url('css/user/reset.css')}}"/>
@endsection

@section('content')

    <div class="reset-password-container">

        <div class="reset-password">

            <form method="POST" action="{{route('password.update')}}" class="reset-password-form">
                @csrf

                <h3>{{__('user/reset.header_reset')}}</h3>

                <span>{{__('user/reset.label_new_password')}}</span>
                <input type="password" name="password" class="box" placeholder="{{__('user/reset.placeholder_new_password')}}" maxlength="50" required/>
                @error('password')
                    <div class="error">{{$message}}</div>
                @enderror

                <span>{{__('user/reset.label_password_confirmation')}}</span>
                <input type="password" name="password_confirmation" class="box" placeholder="{{__('user/reset.placeholder_password_confirmation')}}" maxlength="50" required/>
                @error('password_confirmation')
                    <div class="error">{{$message}}</div>
                @enderror

                <input type="hidden" name="email" value="{{e($_GET['email'])}}" />
                <input type="hidden" name="token" value="{{$token}}"/>

                <input type="submit" name="reset-password" value="{{__('user/reset.button_reset')}}" class="reset-button"/>

            </form>

        </div>

    </div>

@endsection
