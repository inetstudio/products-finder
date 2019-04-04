@extends('admin::back.layouts.app')

@php
    $title = 'Отзывы';
@endphp

@section('title', $title)

@section('content')

    @push('breadcrumbs')
        @include('admin.module.products-finder.reviews.messages::back.partials.breadcrumbs.index')
    @endpush

    <div class="wrapper wrapper-content reviews-package" id="messages_table">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title table-group-buttons">
                        <a href="#" data-url="{{ route('back.reviews.messages.moderate.activity') }}" class="btn btn-xs btn-default">Изменить активность</a>
                        <a href="#" data-url="{{ route('back.reviews.messages.moderate.read') }}" class="btn btn-xs btn-default">Отметить как прочитанное</a>
                        <a href="#" data-url="{{ route('back.reviews.messages.moderate.destroy') }}" class="btn btn-xs btn-danger">Удалить</a>
                    </div>
                    <div class="ibox-content">
                        <div class="sk-spinner sk-spinner-double-bounce">
                            <div class="sk-double-bounce1"></div>
                            <div class="sk-double-bounce2"></div>
                        </div>
                        <div class="table-responsive">
                            {{ $table->table(['class' => 'table table-striped table-bordered table-hover dataTable']) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@pushonce('scripts:datatables_products_finder_reviews_messages_index')
    {!! $table->scripts() !!}
@endpushonce
