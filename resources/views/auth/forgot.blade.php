@extends('layouts.app')

@section('title' , __('auth/forgot.title_reset_password'))
    
@section('stylesheet')
    <link rel="stylesheet" href="{{url('css/auth/forgot.css')}}"/>
@endsection

@section('content')

    <div class="forgot">

        <div class="form-container">

            <form method="POST" action="{{route('password.email')}}" class="reset-password-form">
                @csrf

                <h3>{{__('auth/forgot.header_reset_password')}}</h3>

                <span>{{__('auth/forgot.label_email')}}*</span>
                <input type="email" name="email" class="box" placeholder="{{__('auth/forgot.placeholder_email')}}" maxlength="100" required/>
                @error('email')
                    <div class="error">{{$message}}</div>
                @enderror

                <input type="submit" name="reset-password" value="{{__('auth/forgot.button_send')}}" class="reset-button"/>
                
                <p data-intended-page="{{$intended}}" data-book-id="{{$bid}}" class="lack-account">
                    {{__('auth/forgot.label_lack_account')}} 
                    <a class="create-account">{{__('auth/forgot.link_create_account')}}</a>
                </p>
                <p data-intended-page="{{$intended}}" data-book-id="{{$bid}}" class="have-account">
                    {{__('auth/forgot.label_have_account')}} 
                    <a class="login-link">{{__('auth/forgot.link_login')}}</a>
                </p>

            </form>

        </div>

    </div>
    
@endsection

@section('script')
    <script type="module" src="{{url('js/auth/forgot.js')}}"></script>
@endsection
