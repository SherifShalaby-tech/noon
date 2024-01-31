@extends('layouts.app')
@section('title', __('categories.categories'))


@push('css')
    <style>
        .table-top-head {
            top: 40px !important;
        }

        .rightbar {
            z-index: 2;
        }

        .wrapper1 {
            margin-top: 15px;
        }

        @media(max-width:768px) {
            .wrapper1 {
                margin-top: 140px
            }
        }
    </style>
@endpush

@section('page_title')
    @lang('categories.categories')
@endsection

@section('breadcrumbs')
    @parent
    <li class="breadcrumb-item @if (app()->isLocale('ar')) mr-2 @else ml-2 @endif  active" aria-current="page">
        @lang('categories.categories')</li>
@endsection

@section('button')
    <div class="widgetbar d-flex @if (app()->isLocale('ar')) justify-content-start @else justify-content-end @endif">
        <a href="{{ route('categories.create') }}" class="btn btn-primary mx-1">
            <i class="fa fa-plus"></i>
            @lang('categories.add_categorie_name')
        </a>
        <a href="{{ route('sub-categories', 'category') }}" class="btn btn-primary mx-1">
            <i class="fa fa-arrow-left"></i>
            @lang('categories.allcategories')
        </a>
    </div>
@endsection

@section('content')
    <div class="contentbar">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        @if (@isset($categories) && !@empty($categories) && count($categories) > 0)
                            @include('categories.filter')
                            <div class="wrapper1 @if (app()->isLocale('ar')) dir-rtl @endif">
                                <div class="div1"></div>
                            </div>
                            <div class="wrapper2 @if (app()->isLocale('ar')) dir-rtl @endif">
                                <div class="div2 table-scroll-wrapper">
                                    <!-- content goes here -->
                                    <div style="min-width:1300px;max-height: 90vh;overflow: auto">
                                        <table id="datatable-buttons" class="table table-striped table-bordered">
                                            <thead>
                                                <tr class="position-relative">
                                                    <th>#</th>
                                                    <th>@lang('categories.cover')</th>
                                                    <th>@lang('categories.categorie_name')</th>
                                                    <th>@lang('categories.parent')</th>
                                                    {{-- <th>@lang('categories.sub_categories')</th> --}}
                                                    <th>@lang('categories.status')</th>
                                                    <th>@lang('added_by')</th>
                                                    <th>@lang('updated_by')</th>
                                                    <th>@lang('categories.action')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($categories as $index => $categorie)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('categories.cover')">

                                                                <img src="{{ $categorie->imagepath }}"
                                                                    style="width: 50px; height: 50px;"
                                                                    alt="{{ $categorie->name }}">
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('categories.categorie_name')">

                                                                {{ $categorie->name }}
                                                        </td>
                                                        </span>
                                                        <td>
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('categories.parent')">

                                                                @if ($categorie->parent_id == 1)
                                                                    Category 1
                                                                @elseif ($categorie->parent_id == 2)
                                                                    Category 2
                                                                @elseif ($categorie->parent_id == 3)
                                                                    Category 3
                                                                @else
                                                                    Category 4
                                                                @endif
                                                        </td>
                                                        </span>
                                                        {{-- <td>
                                                                <span
                                                                    class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                    style="font-size: 12px;font-weight: 600"
                                                                    data-tooltip="@lang('categories.sub_categories')">
                                                                    <a href="{{ route('sub-categories', $categorie->id) }}"
                                                                        class="btn btn-sm btn-primary">
                                                                        {{ $categorie->subCategories->count() }}</a>
                                                                </span>
                                                            </td> --}}
                                                        <td>
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('categories.status')">
                                                                {{ __($categorie->status()) }}
                                                        </td>
                                                        </span>
                                                        <td>
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('added_by')">

                                                                @if ($categorie->user_id > 0 and $categorie->user_id != null)
                                                                    {{ $categorie->created_at->diffForHumans() }} <br>
                                                                    {{ $categorie->created_at->format('Y-m-d') }}
                                                                    ({{ $categorie->created_at->format('h:i') }})
                                                                    {{ $categorie->created_at->format('A') == 'AM' ? __('am') : __('pm') }}
                                                                    <br>
                                                                    {{ $categorie->createBy?->name }}
                                                                @else
                                                                    {{ __('no_update') }}
                                                                @endif
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span
                                                                class="custom-tooltip d-flex justify-content-center align-items-center"
                                                                style="font-size: 12px;font-weight: 600"
                                                                data-tooltip="@lang('updated_by')">

                                                                @if ($categorie->last_update > 0 and $categorie->last_update != null)
                                                                    {{ $categorie->updated_at->diffForHumans() }} <br>
                                                                    {{ $categorie->updated_at->format('Y-m-d') }}
                                                                    ({{ $categorie->updated_at->format('h:i') }})
                                                                    {{ $categorie->updated_at->format('A') == 'AM' ? __('am') : __('pm') }}
                                                                    <br>
                                                                    {{ $categorie->updateBy?->name }}
                                                                @else
                                                                    {{ __('no_update') }}
                                                                @endif
                                                            </span>
                                                        </td>
                                                        <td>
                                                            @include('categories.action')
                                                        </td>

                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <tfoot>
                                            <tr>
                                                <th colspan="12">
                                                    <div class="float-right">
                                                        {!! $categories->appends(request()->all())->links() !!}
                                                    </div>
                                                </th>
                                            </tr>
                                        </tfoot>
                                    </div>
                                @else
                                    <div class="alert alert-danger">
                                        {{ __('categories.data_no_found') }}
                                    </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End col -->
    </div>
    </div>
    </div>
@endsection
