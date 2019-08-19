<?php

namespace InetStudio\ProductsFinder\Products\Models;

use Illuminate\Support\Arr;
use Laravel\Scout\Searchable;
use OwenIt\Auditing\Auditable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use InetStudio\Uploads\Models\Traits\HasImages;
use InetStudio\Favorites\Models\Traits\Favoritable;
use InetStudio\MetaPackage\Meta\Models\Traits\HasMeta;
use InetStudio\Classifiers\Models\Traits\HasClassifiers;
use InetStudio\ProductsFinder\Links\Models\Traits\Links;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use InetStudio\Reviews\Messages\Models\Traits\HasReviews;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\AdminPanel\Base\Models\Traits\Scopes\BuildQueryScopeTrait;
use InetStudio\ProductsFinder\Products\Contracts\Models\ProductModelContract;

/**
 * Class ProductModel.
 */
class ProductModel extends Model implements ProductModelContract
{
    use Links;
    use HasMeta;
    use Auditable;
    use HasImages;
    use HasReviews;
    use Searchable;
    use SoftDeletes;
    use Favoritable;
    use HasClassifiers;
    use BuildQueryScopeTrait;

    const ENTITY_TYPE = 'products_finder_product';

    /**
     * Should the timestamps be audited?
     *
     * @var bool
     */
    protected $auditTimestamps = true;

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
     * Атрибуты, для которых разрешено массовое назначение.
     *
     * @var array
     */
    protected $fillable = [
        'feed_hash',
        'ean',
        'brand',
        'series',
        'group_name',
        'shade',
        'title',
        'description',
        'benefits',
        'how_to_use',
        'features',
        'volume',
        'update',
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
            'meta' => function ($query) {
                $query->select(['metable_id', 'metable_type', 'key', 'value']);
            },

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

            'reviews' => function ($reviewQuery) {
                $reviewQuery->select([
                    'id',
                    'is_active',
                    'created_at',
                    'user_id',
                    'name',
                    'email',
                    'title',
                    'message',
                    'rating',
                    'reviewable_id',
                    'reviewable_type',
                ])->active()->orderBy('created_at', 'desc');
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
     * Геттер атрибута type.
     *
     * @return string
     */
    public function getTypeAttribute(): string
    {
        return self::ENTITY_TYPE;
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
        return trim(config('scout.elasticsearch.index', '').'_products_finder', '_');
    }

    /**
     * Get the _type name for the model.
     *
     * @return string
     */
    public function searchableAs()
    {
        return '_doc';
    }

    /**
     * Настройка полей для поиска.
     *
     * @return array
     */
    public function toSearchableArray(): array
    {
        $items = Cache::remember('products_finder_filtered_products', 600, function () {
            $productsService = app()->make(
                'InetStudio\ProductsFinder\Products\Contracts\Services\Front\ItemsServiceContract'
            );

            $filterService = app()->make(
                'InetStudio\ProductsFinder\Products\Contracts\Managers\FilterServicesManagerContract'
            )->with('builder');

            $filter = $productsService->getDefaultFilters();

            $query = $this->newQuery()->select(['id']);

            return $filterService->apply($query, $filter['main'])
                ->pluck('id')
                ->toArray();
        });

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

        $arr['search_field'] = $arr['brand'].' '.$arr['title'].' '.implode(' ', collect($arr['classifiers'])->pluck('value')->toArray());
        $arr['type'] = $this['type'];

        return $arr;
    }
}
