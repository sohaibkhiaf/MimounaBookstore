<div class="account-information">

    <form method="POST" action="{{route('edit.info', ['intended' => $intended, 'user' => $user->id])}}">
        @csrf
        @method('PUT')

        <h3>{{ __('components/account-information.header_show') }}</h3>

        <span>{{__('components/account-information.label_full_name')}}*</span>
        <input type="text" name="name" class="box" value="{{old('name', $user->name)}}" placeholder="{{__('components/account-information.placeholder_full_name')}}"
            maxlength="255" required/>
        @error('name')
            <div class="error">{{$message}}</div>
        @enderror

        <span>{{__('components/account-information.label_phone')}}*</span>
        <input type="tel" name="phone" class="box" value="{{old('phone', $user->phone)}}" placeholder="{{__('components/account-information.placeholder_phone')}}"
            maxlength="10" dir="{{app()->getLocale() === 'ar' ? 'rtl' : 'ltr'}}" required/>
        @error('phone')
            <div class="error">{{$message}}</div>
        @enderror

        <span>{{__('components/account-information.label_email')}}*</span>
        <input type="email" name="email" class="box" value="{{old('email', $user->email)}}" placeholder="{{__('components/account-information.placeholder_email')}}"
            maxlength="100" @disabled($user->email_verified_at !== null) @required($user->email_verified_at === null)/>
        @error('email')
            <div class="error">{{$message}}</div>
        @enderror

        <span>{{__('components/account-information.label_country')}}*</span>
        <select name="country" disabled>
            <option value="">{{__('components/account-information.hardcoded_algeria')}}</option>
        </select>
        @error('country')
            <div class="error">{{$message}}</div>
        @enderror

        <span>{{__('components/account-information.label_address')}}*</span>
        <input type="text" name="address" class="box" value="{{old('address', $user->address)}}" placeholder="{{__('components/account-information.placeholder_address')}}"
            maxlength="250" required/>
        @error('address')
            <div class="error">{{$message}}</div>
        @enderror

        <span>{{__('components/account-information.label_region')}}*</span>
        <select name="region" required>
            @foreach ($regions as $region)
                <option value="{{$region->id}}" @selected($region->id == old('region', $user->region_id))>{{$region->name}}</option>
            @endforeach
        </select>
        @error('region')
            <div class="error">{{$message}}</div>
        @enderror

        <span>{{__('components/account-information.label_age')}}*</span>
        <input type="number" name="age" class="box" value="{{old('age', $user->age)}}" placeholder="{{__('components/account-information.placeholder_age')}}"
            max="99" required/>
        @error('age')
            <div class="error">{{$message}}</div>
        @enderror

        <span>{{__('components/account-information.label_gender')}}*</span>
        <select name="gender" required>
            <option value="1" @selected(old('gender', $user->gender) == 1)>{{__('auth/register.gender_male')}}</option>
            <option value="0" @selected(old('gender', $user->gender) == 0)>{{__('auth/register.gender_female')}}</option>
        </select>
        @error('gender')
            <div class="error">{{$message}}</div>
        @enderror

        <span>{{__('components/account-information.label_current_password')}}</span>
        <input type="password" name="current_password" class="box" maxlength="50"/>
        @error('current_password')
            <div class="error">{{$message}}</div>
        @enderror

        <span>{{__('components/account-information.label_new_password')}}</span>
        <input type="password" name="new_password" class="box" placeholder="{{__('components/account-information.placeholder_new_password')}}"
            maxlength="50"/>
        @error('new_password')
            <div class="error">{{$message}}</div>
        @enderror

        <span>{{__('components/account-information.label_password_confirmation')}}</span>
        <input type="password" name="new_password_confirmation" class="box" maxlength="50"/>
        @error('new_password_confirmation')
            <div class="error">{{$message}}</div>
        @enderror

        <div class="buttons-container">
            @if ($intended === 'cart')
                <a href="{{route('browse.cart')}}" class="cancel-button">
                    {{__('components/account-information.button_cancel')}}
                </a>
            @endif
            <input type="submit" value="{{__('components/account-information.button_save')}}" class="save-button" name="save-button"/>
        </div>

    </form>

</div>
