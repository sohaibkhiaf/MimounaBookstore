<section class="footer">

    <div class="box-container">

        <div class="box">
            <h3>{{__('components/footer.header_locations')}}</h3>
            <a href="{{$ourLocations['link']}}" target="_blank">
                <i style="{{(app()->getLocale() === 'ar') ? 'padding-left: .4rem;' : 'padding-right: .4rem;'}}" class="fas fa-map-marker-alt"></i>
                {{$ourLocations['label']}}
            </a>
        </div>

        <div class="box">
            <h3>{{__('components/footer.header_quick_links')}}</h3>
            @foreach ($quickLinks as $label => $data)
                <a href="{{$data['link']}}">
                    <i style="padding-right: .4rem;" class="{{$data['icon']}}"></i>
                    {{ucfirst($label)}}
                </a>
            @endforeach
        </div>

        <div class="box">
            <h3>{{__('components/footer.header_more_links')}}</h3>
            @foreach ($moreLinks as $label => $data)
                <a href="{{$data['link']}}">
                    <i style="{{(app()->getLocale() === 'ar') ? 'padding-left: .4rem;' : 'padding-right: .4rem;'}}" class="{{$data['icon']}}"></i>
                    {{ucfirst($label)}}
                </a>
            @endforeach
        </div>

        <div class="box">
            <h3>{{__('components/footer.header_contact_info')}}</h3>
            <a href="#" class="phone">
                <i style="{{(app()->getLocale() === 'ar') ? 'padding-left: .4rem;' : 'padding-right: .4rem;'}}" class="fa-brands fa-whatsapp"></i>
                {{$phone}}
            </a>
        </div>

    </div>

    <div class="share">
        <a href="https://www.instagram.com/mimouna.bookstore" target="_blank" class="fab fa-instagram"></a>
        <a href="https://www.facebook.com/people/Mimouna-Bookstore/61555592071472/?mibextid=9R9pXO" target="_blank" class="fab fa-facebook-f"></a>
    </div>

    <div class="credit"> {{__('components/footer.credit_rights')}} &copy; <span>{{__('components/footer.credit_bookstore')}}</span> </div>

</section>
