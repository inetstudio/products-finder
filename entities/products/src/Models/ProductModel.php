<?php

namespace InetStudio\ProductsFinder\Products\Models;

use Illuminate\Support\Arr;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use InetStudio\Uploads\Models\Traits\HasImages;
use InetStudio\Favorites\Models\Traits\Favoritable;
use InetStudio\Classifiers\Models\Traits\HasClassifiers;
use InetStudio\ProductsFinder\Links\Models\Traits\Links;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use InetStudio\Reviews\Messages\Models\Traits\HasReviews;
use InetStudio\Favorites\Contracts\Models\Traits\FavoritableContract;
use InetStudio\AdminPanel\Base\Models\Traits\Scopes\BuildQueryScopeTrait;
use InetStudio\ProductsFinder\Products\Contracts\Models\ProductModelContract;

/**
 * Class ProductModel.
 */
class ProductModel extends Model implements ProductModelContract, HasMedia, FavoritableContract
{
    use Links;
    use HasImages;
    use HasReviews;
    use Searchable;
    use SoftDeletes;
    use Favoritable;
    use HasClassifiers;
    use BuildQueryScopeTrait;

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
        'feed_hash', 'ean', 'brand', 'series', 'group_name',
        'shade', 'title', 'description', 'benefits',
        'how_to_use', 'features', 'volume', 'update',
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
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        self::$buildQueryScopeDefaults['columns'] = [
            'id', 'brand', 'title', 'description'
        ];

        self::$buildQueryScopeDefaults['relations'] = [
            'media' => function ($query) {
                $query->select([
                    'id', 'model_id', 'model_type', 'collection_name', 'file_name',
                    'disk', 'mime_type', 'custom_properties', 'responsive_images',
                ]);
            },

            'links' => function ($query) {
                $query->select([
                    'id', 'product_id', 'type', 'href',
                ]);
            },

            'classifiers' => function ($query) {
                $query->select(['classifiers_entries.id', 'classifiers_entries.value', 'classifiers_entries.alias'])
                    ->with([
                        'groups' => function ($query) {
                            $query->select(['id', 'name', 'alias']);
                        },
                    ]);
            },

            'recommendations' => function ($query) {
                $query->select([
                    'products_finder_products.id', 'products_finder_products.title', 'products_finder_products.brand',
                ])->with([
                    'media' => function ($query) {
                        $query->select([
                            'id', 'model_id', 'model_type', 'collection_name', 'file_name',
                            'disk', 'mime_type', 'custom_properties', 'responsive_images',
                        ]);
                    },
                ]);
            },
        ];
    }

    /**
     * Сеттер атрибута feed_hash.
     *
     * @param $value
     */
    public function setFeedHashAttribute($value)
    {
        $this->attributes['feed_hash'] = trim(strip_tags($value));
    }

    /**
     * Сеттер атрибута ean.
     *
     * @param $value
     */
    public function setEanAttribute($value)
    {
        $this->attributes['ean'] = trim(strip_tags($value));
    }

    /**
     * Сеттер атрибута brand.
     *
     * @param $value
     */
    public function setBrandAttribute($value)
    {
        $this->attributes['brand'] = trim(strip_tags($value));
    }

    /**
     * Сеттер атрибута series.
     *
     * @param $value
     */
    public function setSeriesAttribute($value)
    {
        $this->attributes['series'] = trim(strip_tags($value));
    }

    /**
     * Сеттер атрибута group_name.
     *
     * @param $value
     */
    public function setGroupNameAttribute($value)
    {
        $this->attributes['group_name'] = trim(strip_tags($value));
    }

    /**
     * Сеттер атрибута shade.
     *
     * @param $value
     */
    public function setShadeAttribute($value)
    {
        $this->attributes['shade'] = trim(strip_tags($value));
    }

    /**
     * Сеттер атрибута title.
     *
     * @param $value
     */
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = trim(strip_tags($value));
    }

    /**
     * Сеттер атрибута description.
     *
     * @param $value
     */
    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = trim(str_replace("&nbsp;", ' ', strip_tags((isset($value['text'])) ? $value['text'] : (! is_array($value) ? $value : ''))));
    }

    /**
     * Сеттер атрибута benefits.
     *
     * @param $value
     */
    public function setBenefitsAttribute($value)
    {
        $this->attributes['benefits'] = trim(str_replace("&nbsp;", ' ', strip_tags((isset($value['text'])) ? $value['text'] : (! is_array($value) ? $value : ''))));
    }

    /**
     * Сеттер атрибута how_to_use.
     *
     * @param $value
     */
    public function setHowToUseAttribute($value)
    {
        $this->attributes['how_to_use'] = trim(str_replace("&nbsp;", ' ', strip_tags((isset($value['text'])) ? $value['text'] : (! is_array($value) ? $value : ''))));
    }

    /**
     * Сеттер атрибута features.
     *
     * @param $value
     */
    public function setFeaturesAttribute($value)
    {
        $this->attributes['features'] = trim(str_replace("&nbsp;", ' ', strip_tags((isset($value['text'])) ? $value['text'] : (! is_array($value) ? $value : ''))));
    }

    /**
     * Сеттер атрибута volume.
     *
     * @param $value
     */
    public function setVolumeAttribute($value)
    {
        $this->attributes['volume'] = trim(strip_tags($value));
    }

    /**
     * Сеттер атрибута update.
     *
     * @param $value
     */
    public function setUpdateAttribute($value)
    {
        $this->attributes['update'] = (bool) trim(strip_tags($value));
    }

    /**
     * Рекомендации.
     *
     * @return BelongsToMany
     */
    public function recommendations(): BelongsToMany
    {
        return $this->belongsToMany(
            app()->make('InetStudio\ProductsFinder\Products\Contracts\Models\ProductModelContract'),
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
     */
    public function toSearchableArray(): array
    {
        $productsService = app()->make('InetStudio\ProductsFinder\Products\Contracts\Services\Front\ProductsServiceContract');
        $filter = $productsService->getDefaultFilters();
        $builder = $this::select(['id']);
        $items = $productsService->getFilterBuilder($builder, $filter)->pluck('id')->toArray();

        if (! in_array($this['id'], $items)) {
            $this->unsearchable();

            return [];
        }

        $arr = Arr::only($this->toArray(), ['id', 'brand', 'series', 'title', 'description', 'benefits', 'how_to_use']);

        $arr['classifiers'] = $this->classifiers->map(function ($item) {
            return Arr::only($item->toArray(), ['id', 'value']);
        })->toArray();

        return $arr;
    }
}
