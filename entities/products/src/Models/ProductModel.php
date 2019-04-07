<?php

namespace InetStudio\ProductsFinder\Products\Models;

use Illuminate\Support\Arr;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use InetStudio\Uploads\Models\Traits\HasImages;
use InetStudio\Favorites\Models\Traits\Favoritable;
use InetStudio\Classifiers\Models\Traits\HasClassifiers;
use InetStudio\ProductsFinder\Links\Models\Traits\Links;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use InetStudio\Reviews\Messages\Models\Traits\HasReviews;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\Favorites\Contracts\Models\Traits\FavoritableContract;
use InetStudio\AdminPanel\Base\Models\Traits\Scopes\BuildQueryScopeTrait;
use InetStudio\ProductsFinder\Products\Contracts\Models\ProductModelContract;

/**
 * Class ProductModel.
 */
class ProductModel extends Model implements ProductModelContract, FavoritableContract
{
    use Links;
    use HasImages;
    use HasReviews;
    use Searchable;
    use SoftDeletes;
    use Favoritable;
    use HasClassifiers;
    use BuildQueryScopeTrait;

    /**
     * @var array
     */
    protected $images = [
        'config' => 'products_finder_products',
        'model' => 'product',
    ];

    /**
     * Связанная с моделью таблица.
     *
     * @var string
     */
    protected $table = 'products_finder_products';

    /**
     * Атрибуты, для которых запрещено массовое назначение.
     *
     * @var array
     */
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Атрибуты, которые должны быть преобразованы в даты.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Загрузка модели.
     */
    protected static function boot()
    {
        parent::boot();

        self::$buildQueryScopeDefaults['columns'] = [
            'id',
            'brand',
            'title',
            'description',
        ];

        self::$buildQueryScopeDefaults['relations'] = [
            'media' => function ($query) {
                $query->select(
                    [
                        'id',
                        'model_id',
                        'model_type',
                        'collection_name',
                        'file_name',
                        'disk',
                        'mime_type',
                        'custom_properties',
                        'responsive_images',
                    ]
                );
            },

            'links' => function ($query) {
                $query->select(
                    [
                        'id',
                        'product_id',
                        'type',
                        'href',
                    ]
                );
            },

            'classifiers' => function ($query) {
                $query->select(['classifiers_entries.id', 'classifiers_entries.value', 'classifiers_entries.alias'])
                    ->with(
                        [
                            'groups' => function ($query) {
                                $query->select(['id', 'name', 'alias']);
                            },
                        ]
                    );
            },

            'recommendations' => function ($query) {
                $query->select(
                    [
                        'products_finder_products.id',
                        'products_finder_products.title',
                        'products_finder_products.brand',
                    ]
                )->with(
                    [
                        'media' => function ($query) {
                            $query->select(
                                [
                                    'id',
                                    'model_id',
                                    'model_type',
                                    'collection_name',
                                    'file_name',
                                    'disk',
                                    'mime_type',
                                    'custom_properties',
                                    'responsive_images',
                                ]
                            );
                        },
                    ]
                );
            },
        ];
    }

    /**
     * Сеттер атрибута feed_hash.
     *
     * @param $value
     */
    public function setFeedHashAttribute($value): void
    {
        $this->attributes['feed_hash'] = trim(strip_tags($value));
    }

    /**
     * Сеттер атрибута ean.
     *
     * @param $value
     */
    public function setEanAttribute($value): void
    {
        $this->attributes['ean'] = trim(strip_tags($value));
    }

    /**
     * Сеттер атрибута brand.
     *
     * @param $value
     */
    public function setBrandAttribute($value): void
    {
        $this->attributes['brand'] = trim(strip_tags($value));
    }

    /**
     * Сеттер атрибута series.
     *
     * @param $value
     */
    public function setSeriesAttribute($value): void
    {
        $this->attributes['series'] = trim(strip_tags($value));
    }

    /**
     * Сеттер атрибута group_name.
     *
     * @param $value
     */
    public function setGroupNameAttribute($value): void
    {
        $this->attributes['group_name'] = trim(strip_tags($value));
    }

    /**
     * Сеттер атрибута shade.
     *
     * @param $value
     */
    public function setShadeAttribute($value): void
    {
        $this->attributes['shade'] = trim(strip_tags($value));
    }

    /**
     * Сеттер атрибута title.
     *
     * @param $value
     */
    public function setTitleAttribute($value): void
    {
        $this->attributes['title'] = trim(strip_tags($value));
    }

    /**
     * Сеттер атрибута description.
     *
     * @param $value
     */
    public function setDescriptionAttribute($value): void
    {
        $value = (isset($value['text'])) ? $value['text'] : (! is_array($value) ? $value : '');

        $this->attributes['description'] = trim(str_replace('&nbsp;', ' ', strip_tags($value)));
    }

    /**
     * Сеттер атрибута benefits.
     *
     * @param $value
     */
    public function setBenefitsAttribute($value): void
    {
        $value = (isset($value['text'])) ? $value['text'] : (! is_array($value) ? $value : '');

        $this->attributes['benefits'] = trim(str_replace('&nbsp;', ' ', strip_tags($value)));
    }

    /**
     * Сеттер атрибута how_to_use.
     *
     * @param $value
     */
    public function setHowToUseAttribute($value): void
    {
        $value = (isset($value['text'])) ? $value['text'] : (! is_array($value) ? $value : '');

        $this->attributes['how_to_use'] = trim(str_replace('&nbsp;', ' ', strip_tags($value)));
    }

    /**
     * Сеттер атрибута features.
     *
     * @param $value
     */
    public function setFeaturesAttribute($value): void
    {
        $value = (isset($value['text'])) ? $value['text'] : (! is_array($value) ? $value : '');

        $this->attributes['features'] = trim(str_replace('&nbsp;', ' ', strip_tags($value)));
    }

    /**
     * Сеттер атрибута volume.
     *
     * @param $value
     */
    public function setVolumeAttribute($value): void
    {
        $this->attributes['volume'] = trim(strip_tags($value));
    }

    /**
     * Сеттер атрибута update.
     *
     * @param $value
     */
    public function setUpdateAttribute($value): void
    {
        $this->attributes['update'] = (bool) trim(strip_tags($value));
    }

    /**
     * Рекомендации.
     *
     * @return BelongsToMany
     *
     * @throws BindingResolutionException
     */
    public function recommendations(): BelongsToMany
    {
        $productModel = app()->make('InetStudio\ProductsFinder\Products\Contracts\Models\ProductModelContract');

        return $this->belongsToMany(
            get_class($productModel),
            'products_finder_products_recommendations',
            'product_id',
            'recommendation_id'
        );
    }

    /**
     * Get the index name for the model.
     *
     * @return string
     */
    public function searchableIndex()
    {
        return 'makeup_index_products_finder';
    }

    /**
     * Get the _type name for the model.
     *
     * @return string
     */
    public function searchableAs()
    {
        return 'doc';
    }

    /**
     * Настройка полей для поиска.
     *
     * @return array
     *
     * @throws BindingResolutionException
     */
    public function toSearchableArray(): array
    {
        $productsService = app()->make(
            'InetStudio\ProductsFinder\Products\Contracts\Services\Front\ItemsServiceContract'
        );
        $filter = $productsService->getDefaultFilters();
        $builder = $this::select(['id']);
        $items = $productsService->getFilterBuilder($builder, $filter)->pluck('id')->toArray();

        if (! in_array($this['id'], $items)) {
            $this->unsearchable();

            return [];
        }

        $arr = Arr::only($this->toArray(), ['id', 'brand', 'series', 'title', 'description', 'benefits', 'how_to_use']);
        $arr = collect($arr)->mapWithKeys(
            function ($item, $key) {
                $item = preg_replace('/[^A-Za-zА-Яа-я0-9\-\(\) ]+/u', '', $item);

                return [$key => $item];
            }
        )->toArray();

        $arr['classifiers'] = $this->getAttribute('classifiers')->map(
            function ($item) {
                return collect(Arr::only($item->toArray(), ['id', 'value']))->mapWithKeys(
                    function ($item, $key) {
                        $item = preg_replace('/[^A-Za-zА-Яа-я0-9\-\(\) ]+/u', '', $item);

                        return [$key => $item];
                    }
                )->toArray();
            }
        )->toArray();

        $arr['search_field'] = $arr['title'].' '.implode(' ', collect($arr['classifiers'])->pluck('value')->toArray());

        return $arr;
    }
}
