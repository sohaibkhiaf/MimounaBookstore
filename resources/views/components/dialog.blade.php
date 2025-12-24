<div class="dialog">

    <!--------------------------------------------------- close button ------------------------------------------------>
    <div class="fas fa-times close-dialog"></div>

    <div class="dialog-container">

        <!----------------------------------------------- logout dialog -------------------------------------------->

        <div class="logout-dialog">

            <h3>{{__('components/dialog.header_logout')}}</h3>

            <p>{{__('components/dialog.logout_confirmation')}}</p>

            <form action="{{route('auth.logout')}}" method="POST" class="logout-form">
                @csrf
                @method('DELETE')
                <div class="buttons-container">
                    <a class="cancel-logout">{{__('components/dialog.button_cancel')}}</a>
                    <button class="confirm-logout">{{__('components/dialog.button_logout')}}</button>
                </div>
            </form>

        </div>

        <!----------------------------------------------- language dialog -------------------------------------------->

        <form action="{{route('language.reset')}}" method="GET" class="language-form">

            <h3>{{__('components/dialog.header_select_language')}}</h3>

            <span>{{__('components/dialog.label_language')}}</span>
            <select name="language" required>
                <option value="">{{__('components/dialog.select_language')}}</option>

                <option value="en" {{ (app()->getLocale() === 'en') ? 'selected': '' }}>{{__('components/dialog.language_english')}}</option>
                <option value="ar" {{ (app()->getLocale() === 'ar') ? 'selected': '' }}>{{__('components/dialog.language_arabic')}}</option>
                <option value="fr" {{ (app()->getLocale() === 'fr') ? 'selected': '' }}>{{__('components/dialog.language_french')}}</option>

            </select>

            <input name="intended" type="hidden" value="{{url()->current()}}"/>

            <input type="submit" value="{{__('components/dialog.button_select')}}" class="select-language"/>

        </form>

    </div>

</div>
