@extends('layouts.app')

@section('title' , __('auth/register.title_register'))

@section('stylesheet')
    <link rel="stylesheet" href="{{url('css/auth/register.css')}}"/>
@endsection

@section('content')

    <div class="register">

        <div class="form-container">

            <form method="POST" action="{{route('auth.register' , ['intended' => $intended , 'bid' => $bid ?? -1 ])}}" class="register-form">
                @csrf

                <h3>{{__('auth/register.header_register')}}</h3>

                <span>{{__('auth/register.label_full_name')}}*</span>
                <input type="text" name="name" class="box" value="{{old('name')}}" placeholder="{{__('auth/register.placeholder_full_name')}}" maxlength="255" required>
                @error('name')
                    <div class="error">{{$message}}</div>
                @enderror

                <span>{{__('auth/register.label_phone')}}*</span>
                <input type="tel" name="phone" class="box" value="{{old('phone')}}" placeholder="{{__('auth/register.placeholder_phone')}}" dir="{{(app()->getLocale() === 'ar') ? 'rtl' : 'ltr'}}" maxlength="10" required/>
                @error('phone')
                    <div class="error">{{$message}}</div>
                @enderror

                <span>{{__('auth/register.label_email')}}*</span>
                <input type="email" name="email" class="box" value="{{old('email')}}" placeholder="{{__('auth/register.placeholder_email')}}" maxlength="100" required/>
                @error('email')
                    <div class="error">{{$message}}</div>
                @enderror

                <span>{{__('auth/register.label_password')}}*</span>
                <input type="password" name="password" class="box" value="{{old('password')}}" placeholder="{{__('auth/register.placeholder_password')}}" maxlength="50" required/>
                @error('password')
                    <div class="error">{{$message}}</div>
                @enderror

                <span>{{__('auth/register.label_password_confirmation')}}*</span>
                <input type="password" name="password_confirmation" class="box" value="{{old('password_confirmation')}}" placeholder="{{__('auth/register.placeholder_password_confirmation')}}" maxlength="50" required/>
                @error('password_confirmation')
                    <div class="error">{{$message}}</div>
                @enderror

                <span>{{__('auth/register.label_country')}}*</span>
                <select name="country" disabled>
                    <option value="">{{__('auth/register.hardcoded_algeria')}}</option>
                </select>
                @error('country')
                    <div class="error">{{$message}}</div>
                @enderror

                <span>{{__('auth/register.label_address')}}*</span>
                <input type="text" name="address" class="box" value="{{old('address')}}" placeholder="{{__('auth/register.placeholder_address')}}" maxlength="250" required/>
                @error('address')
                    <div class="error">{{$message}}</div>
                @enderror

                <span>{{__('auth/register.label_region')}}*</span>
                <select name="region" required>
                    <option value="">{{__('auth/register.select_region')}}</option>
                    @foreach ($regions as $region)
                        <option value="{{$region->id}}" {{$region->id == old('region') ? 'selected' : ''}}>{{ (app()->getLocale() === 'ar') ? $region->ar_name : $region->fr_name}}</option>
                    @endforeach
                </select>
                @error('region')
                    <div class="error">{{$message}}</div>
                @enderror

                <span>{{__('auth/register.label_age')}}*</span>
                <input type="number" name="age" class="box" value="{{old('age')}}" placeholder="{{__('auth/register.placeholder_age')}}" max="99" required/>
                @error('age')
                    <div class="error">{{$message}}</div>
                @enderror

                <span>{{__('auth/register.label_gender')}}*</span>
                <select name="gender" required>
                    <option value="">{{__('auth/register.select_gender')}}</option>
                    <option value="1">{{__('auth/register.gender_male')}}</option>
                    <option value="0">{{__('auth/register.gender_female')}}</option>
                </select>
                @error('gender')
                    <div class="error">{{$message}}</div>
                @enderror

                <div class="receive-messages">
                    <input style="{{(app()->getLocale() === 'ar') ? 'margin-left: .5rem;' : 'margin-right: .5rem;'}}"
                        type="checkbox" name="receive-messages" checked>
                    <label for="receive-messages">{{__('auth/register.label_receive_messages')}}</label>
                </div>

                <input type="submit" name="register" value="{{__('auth/register.button_create_account')}}" class="register-button"/>

                <p data-intended-page="{{$intended}}" data-book-id="{{$bid}}" class="have-account">
                    {{__('auth/register.label_have_account')}}
                    <a class="login-link">{{__('auth/register.link_login')}}</a>
                </p>

            </form>

        </div>

    </div>

@endsection

@section('script')
    <script type="module" src="{{url('js/auth/register.js')}}"></script>
@endsection
