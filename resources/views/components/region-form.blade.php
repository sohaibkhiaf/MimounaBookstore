<div class="form-container">

    <form method="POST" action="{{route('admin.regions.update' , ['region' => $region ] )}}">
        @csrf
        @method('PUT')

        <h3>{{__('components/region-form.header_edit_region')}}</h3>

        <span>{{__('components/region-form.label_region')}}</span>
        <input type="text" name="name" class="box" value="{{$region->fr_name.' - '.$region->ar_name}}" maxlength="255" disabled/>
        @error('name')
            <div class="error">{{$message}}</div>
        @enderror

        <span>{{__('components/region-form.label_a_domicile')}}*</span>
        <input type="number" name="a_domicile" class="box" value="{{$region->a_domicile}}"
            placeholder="{{__('components/region-form.placeholder_a_domicile')}}" required/>
        @error('a_domicile')
            <div class="error">{{$message}}</div>
        @enderror

        <span>{{__('components/region-form.label_stop_desk')}}*</span>
        <input type="number" name="stop_desk" class="box" value="{{$region->stop_desk}}"
            placeholder="{{__('components/region-form.placeholder_stop_desk')}}" required/>
        @error('stop_desk')
            <div class="error">{{$message}}</div>
        @enderror

        <div class="shipping">
            <input style="{{(app()->getLocale() === 'ar') ? 'margin-left: .5rem;' : 'margin-right: .5rem;' }}"
                type="checkbox" name="status" {{!$region->enabled ? 'checked' : ''}}/>
            <label for="shipping">{{__('components/region-form.label_shipping')}}</label>
        </div>
        @error('status')
            <div class="error">{{$message}}</div>
        @enderror

        <div class="buttons-container">
            <a href="{{route('admin.regions')}}" class="cancel-button">
                {{__('components/region-form.button_cancel')}}
            </a>
            <input type="submit" value="{{__('components/region-form.button_edit_region')}}" class="edit-button" name="edit-region"/>
        </div>

    </form>

</div>
