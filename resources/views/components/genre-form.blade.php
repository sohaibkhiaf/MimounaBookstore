<div class="form-container">

    <form method="POST" action="{{$action === 'edit' ? route('admin.genres.update', ['genre' => $genre->id])
        : route('admin.genres.store')}}">
        @csrf
        @if ($action === 'edit')
            @method('PUT')
        @endif

        <h3>
            {{ $action === 'edit' ? __('components/genre-form.header_edit').' `'. ((app()->getLocale() === 'ar') ?
            $genre->ar_name : ( app()->getLocale() === 'fr' ? $genre->fr_name : $genre->en_name) ).'`' : __('components/genre-form.header_add')}}
        </h3>

        <span>{{__('components/genre-form.label_en_name')}}*</span>
        <input type="text" name="english-name" class="box" value="{{$action === 'edit' ? $genre->en_name : ''}}"
            placeholder="{{__('components/genre-form.placeholder_en_name')}}" maxlength="255" required/>
        @error('english-name')
            <div class="error">{{$message}}</div>
        @enderror

        <span>{{__('components/genre-form.label_ar_name')}}*</span>
        <input type="text" name="arabic-name" class="box" value="{{$action === 'edit' ? $genre->ar_name : ''}}"
            placeholder="{{__('components/genre-form.placeholder_ar_name')}}" maxlength="255" required/>
        @error('arabic-name')
            <div class="error">{{$message}}</div>
        @enderror

        <span>{{__('components/genre-form.label_fr_name')}}*</span>
        <input type="text" name="french-name" class="box" value="{{$action === 'edit' ? $genre->fr_name : ''}}"
            placeholder="{{__('components/genre-form.placeholder_fr_name')}}" maxlength="255" required/>
        @error('french-name')
            <div class="error">{{$message}}</div>
        @enderror

        <span>{{__('components/genre-form.label_fa_icon')}}*</span>
        <input type="text" name="fontawesome" class="box" value="{{$action === 'edit' ? $genre->fa_icon : ''}}"
            placeholder="{{__('components/genre-form.placeholder_fa_icon')}}" maxlength="255" required/>
        @error('fontawesome')
            <div class="error">{{$message}}</div>
        @enderror

        @if ($action === 'edit')
            <div class="buttons-container">
                <a href="{{route('admin.books')}}" class="cancel-button">
                    {{__('components/genre-form.button_cancel')}}
                </a>
                <input type="submit" value="{{__('components/genre-form.button_edit')}}" class="edit-button" name="edit-genre"/>
            </div>
        @else
            <input type="submit" value="{{__('components/genre-form.button_add')}}" class="create-button" name="create-genre"/>
        @endif

    </form>

</div>
