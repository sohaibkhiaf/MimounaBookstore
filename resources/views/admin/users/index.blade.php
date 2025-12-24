@extends('layouts.app-admin')

@section('title' , __('admin/users-index.title_users'))

@section('stylesheet')
    <link rel="stylesheet" href="{{url('css/admin/users-index.css')}}"/>
@endsection

@section('content')

    <section class="users">

        <div class="tabs-container">

            @isset($tab)
                <h3>{{ __('admin/users-index.header_filter') }}</h3>
                <a href="{{ route('admin.users' , ['tab' => 'all_users']) }}" class="{{ $tab == 'all_users' ? 'active' : ''}}">
                    <i class="fa-solid fa-user"></i>
                    {{ __('admin/users-index.tab_users_list') }}
                </a>

                <a href="{{ route('admin.users' , ['tab' => 'banned_users']) }}" class="{{ $tab == 'banned_users' ? 'active' : ''}}">
                    <i class="fa-solid fa-ban"></i>
                    {{ __('admin/users-index.tab_banned_users') }}
                </a>
            @else
                <h3>{{ __('admin/users-index.header_filter') }}</h3>
                <a href="{{ route('admin.users' , ['tab' => 'all_users']) }}" class="active">
                    <i class="fa-solid fa-user"></i>
                    {{ __('admin/users-index.tab_users_list') }}
                </a>

                <a href="{{ route('admin.users' , ['tab' => 'banned_users']) }}">
                    <i class="fa-solid fa-ban"></i>
                    {{ __('admin/users-index.tab_banned_users') }}
                </a>
            @endisset

        </div>

        <div class="content-container">

            <div class="users-container">

                <h3>
                    @if ($tab === 'banned_users')
                        {{ __('admin/users-index.header_banned_users') }}
                    @else
                        {{ __('admin/users-index.header_users') }}
                    @endif
                </h3>

                @if ($users->count() > 0)

                    <table>

                        <tr>
                            <th class="indentifier-header" data-header-userid="{{__('admin/users-index.header_identifier')}}"
                                data-header-id="{{__('admin/users-index.header_id')}}">
                                {{__('admin/users-index.header_identifier')}}
                            </th>
                            <th class="information-header" data-header-information="{{__('admin/users-index.header_information')}}"
                                data-header-in="{{__('admin/users-index.header_in')}}">
                                {{__('admin/users-index.header_information')}}
                            </th>
                            <th class="orders-header" data-header-orders="{{__('admin/users-index.header_orders')}}"
                                data-header-o="{{__('admin/users-index.header_o')}}">
                                {{__('admin/users-index.header_orders')}}
                            </th>
                            @if($tab === 'banned_users')
                                <th  class="unban-header" data-header-unban="{{__('admin/users-index.header_unban')}}"
                                    data-header-ub="{{__('admin/users-index.header_ub')}}">
                                    {{__('admin/users-index.header_unban')}}
                                </th>
                            @endif
                        </tr>

                        @foreach ($users as $user)

                            <tr>
                                <td>{{$user->id < 10 ? '0'.$user->id : $user->id}}</td>
                                <td>
                                    {{$user->name}} <br>
                                    {{$user->email}} <br>
                                    {{$user->phone}} <br>
                                    @if ($user->role === 1)
                                        {{__('admin/users-index.td_admin')}}
                                    @endif
                                </td>
                                <td>
                                    {{$user->orders->where('order_status_id', '=', 3)->count()}} {{__('admin/users-index.td_delivered')}} <br>
                                    {{$user->orders->where('order_status_id', '=', 5)->count()}} {{__('admin/users-index.td_returned')}} <br>
                                </td>
                                @if ($tab === 'banned_users')
                                    <td>
                                        <form action="{{route('admin.unban.user', ['user' => $user->id])}}" method="POST" class="unban-user-form" data-user-id="{{$user->id}}">
                                            @csrf
                                            @method('PUT')
                                            <i class="fa-solid fa-ban user-unban" data-user-id="{{$user->id}}" data-user-name="{{$user->name}}"></i>
                                        </form>
                                    </td>
                                @endif

                            </tr>

                        @endforeach

                    </table>

                    <div class="navigator-container">

                        @if ($users->currentPage() > 1)
                            <a href="{{$users->previousPageUrl()}}"><i class="{{(app()->getLocale() === 'ar') ? 'fa-solid fa-angle-right' : 'fa-solid fa-angle-left'}}"></i></a>
                        @else
                            <a href="{{$users->url($users->currentPage())}}"><i class="{{(app()->getLocale() === 'ar') ? 'fa-solid fa-angle-right' : 'fa-solid fa-angle-left'}}"></i></a>
                        @endif

                        @for ($i = 1; $i <= $users->lastPage(); $i++)
                            @if ($users->currentPage() == $i)
                                <a href="{{$users->url($i)}}" class="active">{{$i}}</a>
                            @else
                                <a href="{{$users->url($i)}}">{{$i}}</a>
                            @endif
                        @endfor

                        @if ($users->currentPage() < $users->lastPage())
                            <a href="{{$users->nextPageUrl()}}"><i class="{{(app()->getLocale() === 'ar') ? 'fa-solid fa-angle-left' : 'fa-solid fa-angle-right'}}"></i></a>
                        @else
                            <a href="{{$users->url($users->currentPage())}}"><i class="{{(app()->getLocale() === 'ar') ? 'fa-solid fa-angle-left' : 'fa-solid fa-angle-right'}}"></i></a>
                        @endif

                    </div>

                @else

                    <div class="no-users-found">
                        <i class="fa-solid fa-circle-exclamation"></i><br>
                        @if ($tab === 'banned_users')
                            {{__('admin/users-index.message_list_empty')}}
                        @else
                            {{__('admin/users-index.message_no_users_found')}}
                        @endif

                    </div>

                @endif

            </div>

        </div>



    </section>

@endsection

@section('script')
    <script type="module" src="{{url('js/admin/users-index.js')}}"></script>
@endsection
