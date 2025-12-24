<div class="account-information">

    <form method="{{$action === 'edit' ? 'POST' : ''}}" action="{{$action === 'edit' ? route('edit.info' , ['intended' => $intended , 'user' => $user->id ]) : ''}}">
        @if ($action === 'edit')
            @csrf
            @method('PUT')
        @endif

        <h3>{{ $action === 'edit' ? __('components/account-information.header_edit') : __('components/account-information.header_show') }}</h3>

        <span>{{__('components/account-information.label_full_name')}}{{$action === 'edit' ? '*' : ''}}</span>
        <input type="text" name="name" class="box" value="{{$user->name}}" placeholder="{{__('components/account-information.placeholder_full_name')}}"
            maxlength="255" {{$action === 'show' ? 'disabled' : 'required'}}/>
        @error('name')
            <div class="error">{{$message}}</div>
        @enderror

        <span>{{__('components/account-information.label_phone')}}{{$action === 'edit' ? '*' : ''}}</span>
        <input type="tel" name="phone" class="box" value="{{$user->phone}}" placeholder="{{__('components/account-information.placeholder_phone')}}"
            maxlength="10" dir="{{(app()->getLocale() === 'ar') ? 'rtl' : 'ltr'}}" {{$action === 'show' ? 'disabled' : 'required'}}/>
        @error('phone')
            <div class="error">{{$message}}</div>
        @enderror

        <span>{{__('components/account-information.label_email')}}{{$action === 'edit' ? '*' : ''}}</span>
        <input type="email" name="email" class="box" value="{{$user->email}}" placeholder="{{__('components/account-information.placeholder_email')}}"
            maxlength="100" {{$action === 'show' ? 'disabled' : 'required'}} {{$user->email_verified_at !== null ? 'disabled' : ''}}/>
        @error('email')
            <div class="error">{{$message}}</div>
        @enderror

        <span>{{__('components/account-information.label_country')}}{{$action === 'edit' ? '*' : ''}}</span>
        <select name="country" disabled>
            <option value="">{{__('components/account-information.hardcoded_algeria')}}</option>
        </select>
        @error('country')
            <div class="error">{{$message}}</div>
        @enderror

        <span>{{__('components/account-information.label_address')}}{{$action === 'edit' ? '*' : ''}}</span>
        <input type="text" name="address" class="box" value="{{$user->address}}" placeholder="{{__('components/account-information.placeholder_address')}}"
            maxlength="250" {{$action === 'show' ? 'disabled' : 'required'}}/>
        @error('address')
            <div class="error">{{$message}}</div>
        @enderror

        <span>{{__('components/account-information.label_region')}}{{$action === 'edit' ? '*' : ''}}</span>
        <select name="region" {{$action === 'show' ? 'disabled' : 'required'}}>
            @foreach ($regions as $region)
                @if ($region->id === $user->region_id)
                    <option value="{{$region->id}}" selected>{{(app()->getLocale() === 'ar') ? $region->ar_name : $region->fr_name}}</option>
                @else
                    <option value="{{$region->id}}">{{(app()->getLocale() === 'ar') ? $region->ar_name : $region->fr_name}}</option>
                @endif
            @endforeach
        </select>
        @error('region')
            <div class="error">{{$message}}</div>
        @enderror

        <span>{{__('components/account-information.label_age')}}{{$action === 'edit' ? '*' : ''}}</span>
        <input type="number" name="age" class="box" value="{{$user->age}}" placeholder="{{__('components/account-information.placeholder_age')}}"
            max="99" {{$action === 'show' ? 'disabled' : 'required'}}/>
        @error('age')
            <div class="error">{{$message}}</div>
        @enderror

        <span>{{__('components/account-information.label_gender')}}{{$action === 'edit' ? '*' : ''}}</span>
        <select name="gender" {{$action === 'show' ? 'disabled' : 'required'}}>
            <option value="1" {{$user->gender == 1 ? 'selected' : ''}}>{{__('auth/register.gender_male')}}</option>
            <option value="0" {{$user->gender == 0 ? 'selected' : ''}}>{{__('auth/register.gender_female')}}</option>
        </select>
        @error('region')
            <div class="error">{{$message}}</div>
        @enderror

        <span>{{__('components/account-information.label_current_password')}}</span>
        <input type="password" name="current_password" class="box" maxlength="50" {{$action === 'show' ? 'disabled' : ''}}/>
        @error('current_password')
            <div class="error">{{$message}}</div>
        @enderror

        <span>{{__('components/account-information.label_new_password')}}</span>
        <input type="password" name="new_password" class="box" placeholder="{{__('components/account-information.placeholder_new_password')}}"
            maxlength="50" {{$action === 'show' ? 'disabled' : ''}}/>
        @error('new_password')
            <div class="error">{{$message}}</div>
        @enderror

        <span>{{__('components/account-information.label_password_confirmation')}}</span>
        <input type="password" name="new_password_confirmation" class="box" maxlength="50" {{$action === 'show' ? 'disabled' : ''}}/>
        @error('new_password_confirmation')
            <div class="error">{{$message}}</div>
        @enderror

        @if ($action === 'edit')
            <div class="buttons-container">
                <a href="{{route('user.account', ['tab'=> 'account_info' , 'action' => 'show'])}}"
                    class="cancel-button">
                    {{__('components/account-information.button_cancel')}}
                </a>
                <input type="submit" value="{{__('components/account-information.button_save')}}" class="save-button" name="save-button"/>
            </div>
        @else
            <a href="{{route('user.account', ['tab' => 'account_info', 'action' => 'edit'])}}"
                class="edit-button">
                {{__('components/account-information.button_edit')}}
            </a>
        @endif

    </form>

</div>
