@extends('layouts.app-admin')

@section('title' , __('admin/regions-index.title_regions_shipping'))

@section('stylesheet')
    <link rel="stylesheet" href="{{url('css/admin/regions-index.css')}}"/>
@endsection

@section('content')

    <section class="regions">

        <div class="content-container">

            <div class="regions-container">

                <h3>{{__('admin/regions-index.header_regions_shipping')}}</h3>

                <table>

                    <tr>
                        <th class="region-header" data-header-regionid="{{__('admin/regions-index.table_header_region')}}"
                            data-header-r="{{__('admin/regions-index.table_header_r')}}">
                            {{__('admin/regions-index.table_header_region')}}
                        </th>

                        <th class="name-header" data-header-name="{{__('admin/regions-index.table_header_name')}}"
                            data-header-n="{{__('admin/regions-index.table_header_n')}}">
                            {{__('admin/regions-index.table_header_name')}}
                        </th>

                        <th class="desk-header" data-header-desk="{{__('admin/regions-index.table_header_desk')}}"
                            data-header-dk="{{__('admin/regions-index.table_header_dk')}}">
                            {{__('admin/regions-index.table_header_desk')}}
                        </th>

                        <th class="home-header" data-header-home="{{__('admin/regions-index.table_header_home')}}"
                            data-header-hd="{{__('admin/regions-index.table_header_hd')}}">
                            {{__('admin/regions-index.table_header_home')}}
                        </th>

                        <th class="status-header" data-header-status="{{__('admin/regions-index.table_header_status')}}"
                            data-header-st="{{__('admin/regions-index.table_header_st')}}">
                            {{__('admin/regions-index.table_header_status')}}
                        </th>

                        <th class="edit-header" data-header-edit="{{__('admin/regions-index.table_header_edit')}}"
                            data-header-ed="{{__('admin/regions-index.table_header_ed')}}">
                            {{__('admin/regions-index.table_header_edit')}}
                        </th>

                    </tr>

                    @foreach ($regions as $region)

                        <tr>
                            <td>{{$region->id < 10 ? '0'.$region->id : $region->id}}</td>
                            <td>{{$region->fr_name.' - '.$region->ar_name}}</td>
                            <td>{{$region->stop_desk}}{{__('admin/regions-index.hardcoded_da')}}</td>
                            <td>{{$region->a_domicile}}{{__('admin/regions-index.hardcoded_da')}}</td>
                            <td>{{$region->enabled ? __('admin/regions-index.table_data_available') : __('admin/regions-index.table_data_unavailable') }}</td>
                            <td><i class="fas fa-pen region-edit" data-region-id="{{$region->id}}"></i></td>
                        </tr>

                    @endforeach

                </table>

            </div>

        </div>

    </section>

@endsection

@section('script')
    <script type="module" src="{{url('js/admin/regions-index.js')}}"></script>
@endsection
