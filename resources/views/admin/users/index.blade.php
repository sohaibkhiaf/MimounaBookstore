@extends('layouts.app-admin')

@section('title' , __('admin/users-index.title_users'))

@section('stylesheet')
    <link rel="stylesheet" href="{{url('css/admin/users-index.css')}}"/>
@endsection

@section('content')

    @php
        $currentTab = $tab ?? 'all_users';
    @endphp

    <section class="users">

        <div class="tabs-container">

            <h3>{{ __('admin/users-index.header_filter') }}</h3>

            <a href="{{ route('admin.users', ['tab' => 'all_users']) }}" @class(['active' => $currentTab === 'all_users'])>
                <i class="fa-solid fa-user"></i>
                {{ __('admin/users-index.tab_users_list') }}
            </a>

            <a href="{{ route('admin.users', ['tab' => 'banned_users']) }}" @class(['active' => $currentTab === 'banned_users'])>
                <i class="fa-solid fa-ban"></i>
                {{ __('admin/users-index.tab_banned_users') }}
            </a>

        </div>

        <div class="content-container">

            <div class="users-container">

                <h3>
                    {{ $currentTab === 'banned_users' ? __('admin/users-index.header_banned_users') : __('admin/users-index.header_users') }}
                </h3>

                @if ($users->isNotEmpty())

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
                            @if ($currentTab === 'banned_users')
                                <th class="unban-header" data-header-unban="{{__('admin/users-index.header_unban')}}"
                                    data-header-ub="{{__('admin/users-index.header_ub')}}">
                                    {{__('admin/users-index.header_unban')}}
                                </th>
                            @endif
                        </tr>

                        @foreach ($users as $user)

                            <tr>
                                <td>{{ str_pad($user->id, 2, '0', STR_PAD_LEFT) }}</td>
                                <td>
                                    {{$user->name}} <br>
                                    {{$user->email}} <br>
                                    {{$user->phone}} <br>
                                    @if ($user->role === 1)
                                        {{__('admin/users-index.td_admin')}}
                                    @endif
                                </td>
                                <td>
                                    {{$user->delivered_orders_count ?? $user->orders->where('order_status_id', 3)->count()}} {{__('admin/users-index.td_delivered')}} <br>
                                    {{$user->returned_orders_count ?? $user->orders->where('order_status_id', 5)->count()}} {{__('admin/users-index.td_returned')}} <br>
                                </td>
                                @if ($currentTab === 'banned_users')
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
                        {{ $users->links() }}
                    </div>

                @else

                    <div class="no-users-found">
                        <i class="fa-solid fa-circle-exclamation"></i><br>
                        {{ $currentTab === 'banned_users' ? __('admin/users-index.message_list_empty') : __('admin/users-index.message_no_users_found') }}
                    </div>

                @endif

            </div>

        </div>

    </section>

@endsection

@section('script')
    <script type="module" src="{{url('js/admin/users-index.js')}}"></script>
@endsection
