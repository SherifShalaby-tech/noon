@extends('layouts.app')
@section('title', __('lang.initial_balance'))


@push('css')
    <style>
        .table-top-head {
            top: 155px !important;
        }

        .wrapper1 {
            margin-top: 25px;
        }

        @media(max-width:768px) {
            .table-top-head {
                top: 280px !important
            }

            .wrapper1 {
                margin-top: 110px !important;
            }
        }
    </style>
@endpush

@section('page_title')
    @lang('lang.initial_balance')
@endsection

@section('breadcrumbs')
    @parent

    <li class="breadcrumb-item  @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif active" aria-current="page"
        style="text-decoration: none;color: #596fd7">/ @lang('lang.initial_balance')</li>
@endsection

@section('button')
    <div class="widgetbar d-flex @if (app()->isLocale('ar')) justify-content-start @else justify-content-end @endif">
        {{-- <a type="button" class="btn btn-primary" target="_blank"
            href="{{ route('new-initial-balance.create') }}">@lang('lang.add_initial_balance')</a> --}}


        <button class="btn btn-primary" onclick="openNewWindow('{{ route('new-initial-balance.create') }}')">
            @lang('lang.add_initial_balance')
        </button>
    </div>
@endsection

@section('content')
    @livewire('initial-balance.index')
@endsection

@push('javascripts')
    <script>
        function openNewWindow(routeName) {
            // Open the new URL in a new tab/window

            window.open(routeName, "_blank")
            // Check if the current window has an opener
            // if (window.opener) {
            //     // Reload the opener window
            //     window.opener.location.reload();
            //     // Close the current tab
            //     window.close();
            // } else {
            //     // Reload the current window if there is no opener
            //     window.location.reload();
            // }
        }
    </script>
@endpush
