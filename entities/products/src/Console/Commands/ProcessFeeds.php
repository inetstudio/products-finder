<?php

namespace InetStudio\ProductsFinder\Products\Console\Commands;

use SimpleXMLElement;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Spatie\MediaLibrary\Models\Media;
use GuzzleHttp\Exception\ClientException;
use InetStudio\ProductsFinder\Products\Contracts\Models\ProductModelContract;
use InetStudio\Classifiers\Groups\Contracts\Services\Back\GroupsServiceContract as GroupsServiceContract;
use InetStudio\ProductsFinder\Links\Contracts\Services\Back\ItemsServiceContract as LinksServiceContract;
use InetStudio\Classifiers\Entries\Contracts\Services\Back\EntriesServiceContract as EntriesServiceContract;
use InetStudio\ProductsFinder\Products\Contracts\Services\Back\ItemsServiceContract as ProductsServiceContract;

/**
 * Class ProcessFeeds.
 */
class ProcessFeeds extends Command
{
    /**
     * Имя команды.
     *
     * @var string
     */
    protected $name = 'inetstudio:products-finder:products:feeds';

    /**
     * Описание команды.
     *
     * @var string
     */
    protected $description = 'Process products feeds';

    /**
     * @var LinksServiceContract
     */
    protected $linksService;

    /**
     * @var ProductsServiceContract
     */
    protected $productsService;

    /**
     * @var GroupsServiceContract
     */
    protected $classifiersGroupsService;

    /**
     * @var EntriesServiceContract
     */
    protected $classifiersEntriesService;

    /**
     * ProcessFeeds constructor.
     *
     * @param LinksServiceContract $linksService
     * @param ProductsServiceContract $productsService
     * @param GroupsServiceContract $groupsService
     * @param EntriesServiceContract $entriesService
     */
    public function __construct(LinksServiceContract $linksService,
                                ProductsServiceContract $productsService,
                                GroupsServiceContract $groupsService,
                                EntriesServiceContract $entriesService)
    {
        parent::__construct();

        $this->linksService = $linksService;
        $this->productsService = $productsService;
        $this->classifiersGroupsService = $groupsService;
        $this->classifiersEntriesService = $entriesService;
    }

    /**
     * Запуск команды.
     *
     * @return void
     */
    public function handle(): void
    {
        $feeds = config('products_finder_products.feeds');

        foreach ($feeds ?? [] as $productsFeed => $url) {
            $this->info(PHP_EOL.'Обработка фида: '.$productsFeed);

            $xml = $this->getFeedContent($url);

            if (! $xml) {
                continue;
            }

            $bar = $this->output->createProgressBar(count($xml->channel->item));

            $feedHash = md5($url);

            foreach ($xml->channel->item as $item) {
                $ean = trim($this->getNodeValue('id', $item));
                $productObject = $this->getProduct($feedHash, $ean);

                if ($productObject && $productObject->update == 0) {
                    continue;
                }

                $productData = [
                    'feed_hash' => $feedHash,
                    'ean' => $ean,
                    'brand' => trim($this->getNodeValue('brand', $item)),
                    'series' => trim($this->getNodeValue('series', $item)),
                    'group_name' => trim($this->getNodeValue('products_group_name', $item)),
                    'shade' => trim($this->getNodeValue('shade', $item)),
                    'title' => trim($this->getNodeValue('title', $item)),
                    'description' => trim($this->getNodeValue('description', $item)),
                    'benefits' => trim($this->getNodeValue('benefits', $item)),
                    'how_to_use' => trim($this->getNodeValue('how_to_use', $item)),
                    'features' => trim($this->getNodeValue('composition_features', $item)),
                    'volume' => trim($this->getNodeValue('volume', $item)),
                ];

                $productObject = $this->productsService->saveModel($productData, ($productObject) ? $productObject['id'] : 0);

                $this->attachMedia($productObject, $item);
                $this->attachLinks($productObject, $item);
                $this->attachRecommendations($productObject, $item);
                $this->attachClassifiers($productObject, $item);

                event(app()->makeWith('InetStudio\ProductsFinder\Products\Contracts\Events\Back\ModifyItemEventContract', [
                    'item' => $productObject,
                ]));

                $bar->advance();
            }

            $bar->finish();
        }
    }

    /**
     * Получаем фид в виде массива.
     *
     * @param string $url
     *
     * @return SimpleXMLElement|null
     */
    protected function getFeedContent(string $url): ?SimpleXMLElement
    {
        $client = new Client();

        try {
            $response = $client->get($url);
        } catch (ClientException $e) {
            $this->error('Фид недоступен: '.$url);

            return null;
        }

        $content = $response->getBody()->getContents();
        $responseXml = simplexml_load_string($content);


        return ($responseXml) ? $responseXml : null;
    }

    /**
     * Получаем значение элемента дерева.
     *
     * @param string $property
     * @param mixed $node
     *
     * @return mixed
     */
    protected function getNodeValue(string $property, $node)
    {
        $items = [$node];

        $gNode = $node->children('g', true);

        if ($gNode) {
            $items[] = $gNode;
        }

        foreach ($items as $item) {
            if (isset($item->$property)) {
                return $item->$property;
            }
        }

        return null;
    }

    /**
     * Получаем продукт.
     *
     * @param $feedHash
     * @param $productId
     *
     * @return ProductModelContract|null
     */
    protected function getProduct($feedHash, $productId): ?ProductModelContract
    {
        return $this->productsService->model::query()
            ->where('feed_hash', $feedHash)
            ->where('ean', trim($productId))
            ->first();
    }

    /**
     * Сохраняем изображение прдукта.
     * 
     * @param ProductModelContract $productObject
     * @param $item
     * 
     * @return Media|null
     */
    protected function attachMedia(ProductModelContract $productObject, $item): ?Media
    {
        $imageLink = trim($this->getNodeValue('image_link', $item));

        if (! $imageLink || $productObject->hasMedia('preview')) {
            return null;
        }

        try {
            return $productObject->addMediaFromUrl($imageLink)
                ->withCustomProperties(['source' => $imageLink])
                ->toMediaCollection('preview', 'products_finder_products');
        } catch (\Exception $error) {
            $this->info(PHP_EOL . 'Image error: ' . $imageLink);

            return null;
        }
    }

    /**
     * Сохраняем ссылки.
     *
     * @param ProductModelContract $productObject
     * @param $item
     */
    protected function attachLinks(ProductModelContract $productObject, $item): void
    {
        $hrefArr = [];

        $link = $this->getNodeValue('link', $item);
        $links = $this->getNodeValue('links', $item);
        $videoLinks = $this->getNodeValue('video_link', $item);

        $hrefArr['shop'][] = trim($link);

        if ($links) {
            foreach ($links->link as $link) {
                $hrefArr['shop'][] = trim($link->href);
            }
        }

        if ((string) $videoLinks) {
            $hrefArr['video'] = explode(',', $videoLinks);
        }

        $hrefArr['shop'] = array_filter($hrefArr['shop']);

        $this->linksService->model::where('product_id', $productObject['id'])->whereNotIn('href', $hrefArr)->delete();

        foreach ($hrefArr as $hrefsType => $hrefs) {
            foreach ($hrefs as $href) {
                $linkObject = $this->linksService->model::where('product_id', $productObject['id'])->where('href', $href)
                    ->first();

                $linkData = [
                    'type' => $hrefsType,
                    'product_id' => $productObject['id'],
                    'href' => $href,
                ];

                $this->linksService->save($linkData, ($linkObject) ? $linkObject->id : 0);
            }
        }
    }

    /**
     * Сохраняем рекомендации.
     *
     * @param ProductModelContract $productObject
     * @param $item
     */
    protected function attachRecommendations(ProductModelContract $productObject, $item): void
    {
        $recommendationsNodes = $item->recommendations;

        $recommendations = [
            $recommendationsNodes->recommendation1,
            $recommendationsNodes->recommendation2,
            $recommendationsNodes->recommendation3,
        ];

        $recommendationsIDs = [];

        foreach ($recommendations as $recommendation) {
            $ean = (string) $recommendation;

            if ($ean) {
                $recommendationObject = $this->productsService->model::where('ean', $ean)->first();

                if ($recommendationObject) {
                    $recommendationsIDs[] = $recommendationObject->id;
                }
            }
        }

        $productObject->recommendations()->sync($recommendationsIDs);
    }

    /**
     * Сохраняем классификаторы.
     *
     * @param ProductModelContract $productObject
     * @param $item
     */
    protected function attachClassifiers(ProductModelContract $productObject, $item)
    {
        $groups = [
            'scope_of_use' => 'products_finder_scopes_of_use',
            'type' => 'products_finder_types',
            'age' => 'products_finder_age',
            'sex' => 'products_finder_sex',
            'country' => 'products_finder_countries',
            'skin_type' => 'products_finder_skin_types',
            'color' => 'products_finder_colors',
            'texture' => 'products_finder_textures',
            'spf' => 'products_finder_spf',
            'face_application' => 'products_finder_face_applications',
            'hair_application' => 'products_finder_hair_applications',
        ];

        $classifiersIDs = [];
        foreach ($groups as $field => $groupAlias) {
            $value = trim($this->getNodeValue($field, $item));
            $value = str_replace([',', '/', ';', '+'], '##', $value);

            $values = explode('##', $value);
            $values = array_unique(array_filter($values));

            $group = $this->classifiersGroupsService->model::where('alias', '=', $groupAlias)->first();

            $entriesIDs = [];
            foreach ($values as $entryValue) {
                $alias = 'products_finder_'.$field.'_'.md5(Str::ucfirst(trim($entryValue)));

                $entry = $this->classifiersEntriesService->model::updateOrCreate([
                    'alias' => $alias,
                ], [
                    'value' => Str::ucfirst(trim($entryValue)),
                ]);

                $entriesIDs[] = $entry->id;
                $classifiersIDs[] = $entry->id;
            }

            $currentEntriesIDs = $group->entries()->pluck('classifiers_entries.id')->toArray();
            $entriesIDs = array_unique(array_merge($entriesIDs, $currentEntriesIDs));
            $group->entries()->sync($entriesIDs);
        }

        $productObject->syncClassifiers($classifiersIDs);
    }
}
