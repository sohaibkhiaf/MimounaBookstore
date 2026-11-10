@extends('layouts.app')

@section('title' , __('auth/login.title_login'))

@section('stylesheet')
    <link rel="stylesheet" href="{{url('css/auth/login.css')}}"/>
@endsection

@section('content')

    <div class="login">

        <div class="form-container">

            <form method="POST" action="{{route('auth.login', ['intended' => $intended , 'bid' => $bid ?? -1 ])}}" class="login-form">
                @csrf

                <h3>{{__('auth/login.header_login')}}</h3>

                <span>{{__('auth/login.label_email')}}</span>
                <input type="email" name="email" class="box" placeholder="{{__('auth/login.placeholder_email')}}" maxlength="100" required/>
                @error('email')
                    <div class="error">{{$message}}</div>
                @enderror

                <span>{{__('auth/login.label_password')}}</span>
                <input type="password" name="password" class="box" placeholder="{{__('auth/login.placeholder_password')}}" maxlength="50" required/>
                @error('password')
                    <div class="error">{{$message}}</div>
                @enderror

                <div class="remember-me">
                    <input type="checkbox" name="remember" checked/>
                    <label for="remember">{{__('auth/login.label_remember')}}</label>
                </div>

                <input type="submit" name="login" value="{{__('auth/login.button_login')}}" class="login-button"/>

                <p data-intended-page="{{$intended}}" data-book-id="{{$bid}}" class="forgot-password">
                    {{__('auth/login.label_forgot_password')}}
                    <a class="reset-password">{{__('auth/login.link_reset_password')}}</a>
                </p>
                <p data-intended-page="{{$intended}}" data-book-id="{{$bid}}" class="lack-account">
                    {{__('auth/login.label_lack_account')}}
                    <a class="create-account">{{__('auth/login.link_create_account')}}</a>
                </p>

            </form>

        </div>

    </div>

@endsection

@section('script')
    <script type="module" src="{{url('js/auth/login.js')}}"></script>
@endsection
