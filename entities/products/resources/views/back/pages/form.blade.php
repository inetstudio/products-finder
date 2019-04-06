@extends('admin::back.layouts.app')

@php
    $title = ($item['id']) ? 'Редактирование продукта' : 'Создание продукта';
@endphp

@section('title', $title)

@section('content')

    @push('breadcrumbs')
        @include('admin.module.products-finder.products::back.partials.breadcrumbs.form')
    @endpush

    <div class="wrapper wrapper-content">
        <div class="ibox">
            <div class="ibox-title">
                <a class="btn btn-sm btn-white" href="{{ route('back.products-finder.products.index') }}">
                    <i class="fa fa-arrow-left"></i> Вернуться назад
                </a>
            </div>
        </div>

        {!! Form::info() !!}

        {!! Form::open(['url' => (! $item['id']) ? route('back.products-finder.products.store') : route('back.products-finder.products.update', [$item['id']]), 'id' => 'mainForm', 'enctype' => 'multipart/form-data']) !!}

        @if ($item['id'])
            {{ method_field('PUT') }}
        @endif

        {!! Form::hidden('product_id', (! $item['id']) ? '' : $item['id'], ['id' => 'object-id']) !!}

        {!! Form::hidden('product_type', get_class($item), ['id' => 'object-type']) !!}

        <div class="ibox">
            <div class="ibox-title">
                {!! Form::buttons('', '', ['back' => 'back.products-finder.products.index']) !!}
            </div>
            <div class="ibox-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel-group float-e-margins" id="mainAccordion">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#mainAccordion" href="#collapseMain"
                                           aria-expanded="true">Основная информация</a>
                                    </h5>
                                </div>
                                <div id="collapseMain" class="collapse show" aria-expanded="true">
                                    <div class="panel-body">

                                        <div class="form-group row ">
                                            <label for="ean" class="col-sm-2 col-form-label font-bold font-bold">Изображение</label>
                                            <div class="col-sm-10">
                                                <div class="product-image">
                                                    <a data-fancybox
                                                       href="{{ url($item->getFirstMediaUrl('preview')) }}">
                                                        <img src="{{ url($item->getFirstMediaUrl('preview', 'preview_admin')) }}"
                                                             class=" m-b-md img-fluid" alt="post_image">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>

                                        {!! Form::string('ean', $item->ean, [
                                           'label' => [
                                               'title' => 'EAN',
                                           ],
                                        ]) !!}

                                        {!! Form::string('brand', $item->brand, [
                                           'label' => [
                                               'title' => 'Бренд',
                                           ],
                                        ]) !!}

                                        {!! Form::string('title', $item->title, [
                                           'label' => [
                                               'title' => 'Название',
                                           ],
                                        ]) !!}

                                        {!! Form::string('series', $item->series, [
                                           'label' => [
                                               'title' => 'Серия',
                                           ],
                                        ]) !!}

                                        {!! Form::string('group_name', $item->group_name, [
                                           'label' => [
                                               'title' => 'Группа',
                                           ],
                                        ]) !!}

                                        {!! Form::string('shade', $item->shade, [
                                           'label' => [
                                               'title' => 'Оттенок',
                                           ],
                                        ]) !!}

                                        {!! Form::string('volume', $item->volume, [
                                           'label' => [
                                               'title' => 'Объем',
                                           ],
                                        ]) !!}

                                        {!! Form::wysiwyg('description', $item->description, [
                                            'label' => [
                                                'title' => 'Описание',
                                            ],
                                            'field' => [
                                                'class' => 'tinymce',
                                                'id' => 'description',
                                                'hasImages' => false,
                                            ],
                                        ]) !!}

                                        {!! Form::wysiwyg('benefits', $item->benefits, [
                                            'label' => [
                                                'title' => 'Выгода',
                                            ],
                                            'field' => [
                                                'class' => 'tinymce',
                                                'id' => 'benefits',
                                                'hasImages' => false,
                                            ],
                                        ]) !!}

                                        {!! Form::wysiwyg('how_to_use', $item->how_to_use, [
                                            'label' => [
                                                'title' => 'Как использовать',
                                            ],
                                            'field' => [
                                                'class' => 'tinymce',
                                                'id' => 'how_to_use',
                                                'hasImages' => false,
                                            ],
                                        ]) !!}

                                        {!! Form::wysiwyg('features', $item->features, [
                                            'label' => [
                                                'title' => 'Особенности',
                                            ],
                                            'field' => [
                                                'class' => 'tinymce',
                                                'id' => 'features',
                                                'hasImages' => false,
                                            ],
                                        ]) !!}

                                        {!! Form::classifiers('', $item, [
                                            'label' => [
                                                'title' => 'Область',
                                            ],
                                            'field' => [
                                                'placeholder' => 'Выберите области применения',
                                                'group' => 'products_finder_scopes_of_use',
                                                'multiple' => 'multiple',
                                            ],
                                        ]) !!}

                                        {!! Form::classifiers('', $item, [
                                            'label' => [
                                                'title' => 'Тип',
                                            ],
                                            'field' => [
                                                'placeholder' => 'Выберите типы',
                                                'group' => 'products_finder_types',
                                                'multiple' => 'multiple',
                                            ],
                                        ]) !!}

                                        {!! Form::classifiers('', $item, [
                                            'label' => [
                                                'title' => 'Цвет',
                                            ],
                                            'field' => [
                                                'placeholder' => 'Выберите цвета',
                                                'group' => 'products_finder_colors',
                                                'multiple' => 'multiple',
                                            ],
                                        ]) !!}

                                        {!! Form::classifiers('', $item, [
                                            'label' => [
                                                'title' => 'Страны',
                                            ],
                                            'field' => [
                                                'placeholder' => 'Выберите страны',
                                                'group' => 'products_finder_countries',
                                                'multiple' => 'multiple',
                                            ],
                                        ]) !!}

                                        {!! Form::classifiers('', $item, [
                                            'label' => [
                                                'title' => 'Возраст',
                                            ],
                                            'field' => [
                                                'placeholder' => 'Выберите возраст',
                                                'group' => 'products_finder_age',
                                                'multiple' => 'multiple',
                                            ],
                                        ]) !!}

                                        {!! Form::classifiers('', $item, [
                                            'label' => [
                                                'title' => 'Пол',
                                            ],
                                            'field' => [
                                                'placeholder' => 'Выберите пол',
                                                'group' => 'products_finder_sex',
                                                'multiple' => 'multiple',
                                            ],
                                        ]) !!}

                                        {!! Form::classifiers('', $item, [
                                            'label' => [
                                                'title' => 'Типы кожи',
                                            ],
                                            'field' => [
                                                'placeholder' => 'Выберите типы кожи',
                                                'group' => 'products_finder_skin_types',
                                                'multiple' => 'multiple',
                                            ],
                                        ]) !!}

                                        {!! Form::classifiers('', $item, [
                                            'label' => [
                                                'title' => 'Текстура',
                                            ],
                                            'field' => [
                                                'placeholder' => 'Выберите текстуры',
                                                'group' => 'products_finder_textures',
                                                'multiple' => 'multiple',
                                            ],
                                        ]) !!}

                                        {!! Form::classifiers('', $item, [
                                            'label' => [
                                                'title' => 'SPF',
                                            ],
                                            'field' => [
                                                'placeholder' => 'Выберите SPF',
                                                'group' => 'products_finder_spf',
                                                'multiple' => 'multiple',
                                            ],
                                        ]) !!}

                                        {!! Form::classifiers('', $item, [
                                            'label' => [
                                                'title' => 'Применение для лица',
                                            ],
                                            'field' => [
                                                'placeholder' => 'Выберите применение',
                                                'group' => 'products_finder_face_applications',
                                                'multiple' => 'multiple',
                                            ],
                                        ]) !!}

                                        {!! Form::classifiers('', $item, [
                                            'label' => [
                                                'title' => 'Применение для волос',
                                            ],
                                            'field' => [
                                                'placeholder' => 'Выберите применение',
                                                'group' => 'products_finder_hair_applications',
                                                'multiple' => 'multiple',
                                            ],
                                        ]) !!}

                                        {!! Form::radios('update', (! $item->update && ! $item->id) ? 1 : $item->update, [
                                            'label' => [
                                              'title' => 'Обновлять продукт',
                                            ],
                                            'radios' => [
                                              [
                                                  'label' => 'Да',
                                                  'value' => 1,
                                                  'options' => [
                                                      'class' => 'i-checks',
                                                  ],
                                              ],
                                              [
                                                  'label' => 'Нет',
                                                  'value' => 0,
                                                  'options' => [
                                                      'class' => 'i-checks',
                                                  ],
                                              ],
                                            ],
                                        ]) !!}

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ibox-footer">
                {!! Form::buttons('', '', ['back' => 'back.products-finder.products.index']) !!}
            </div>
        </div>

        {!! Form::close()!!}
    </div>
@endsection
