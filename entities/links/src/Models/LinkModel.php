<?php

namespace InetStudio\ProductsFinder\Links\Models;

use Illuminate\Database\Eloquent\Model;
use InetStudio\ProductsFinder\Products\Models\Traits\Product;
use InetStudio\ProductsFinder\Links\Contracts\Models\LinkModelContract;

/**
 * Class LinkModel.
 */
class LinkModel extends Model implements LinkModelContract
{
    use Product;

    /**
     * Связанная с моделью таблица.
     *
     * @var string
     */
    protected $table = 'products_finder_links';

    /**
     * Атрибуты, для которых разрешено массовое назначение.
     *
     * @var array
     */
    protected $fillable = [
        'type', 'product_id', 'href',
    ];

    /**
     * Атрибуты, которые должны быть преобразованы в даты.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * Сеттер атрибута type.
     *
     * @param $value
     */
    public function setTypeAttribute($value)
    {
        $this->attributes['type'] = trim(strip_tags($value));
    }

    /**
     * Сеттер атрибута product_id.
     *
     * @param $value
     */
    public function setProductIdAttribute($value)
    {
        $this->attributes['product_id'] = (int) trim(strip_tags($value));
    }

    /**
     * Сеттер атрибута href.
     *
     * @param $value
     */
    public function setHrefAttribute($value)
    {
        $this->attributes['href'] = trim(strip_tags($value));
    }

    /**
     * Получаем домен ссылки.
     *
     * @return string
     */
    public function getShopClassAttribute()
    {
        $url = parse_url($this->href);

        if (isset($url['host'])) {
            if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $url['host'], $regs)) {
                return strtok($regs['domain'], '.');
            }
        }

        return 'default';
    }
}
