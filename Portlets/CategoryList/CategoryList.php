<?php

declare(strict_types=1);

namespace Plugin\cb_category_list\Portlets\CategoryList;

use Illuminate\Support\Collection;
use JTL\Catalog\Category\Kategorie;
use JTL\Catalog\Hersteller;
use JTL\Helpers\Text;
use JTL\OPC\InputType;
use JTL\OPC\Portlet;
use JTL\OPC\PortletInstance;
use JTL\Shop;

/**
 * Class CategoryList
 * @package Plugin\cb_category_list\Portlets
 */
class CategoryList extends Portlet
{
    public function categories()
    {
        $data  = Shop::Container()->getDB()->getObjects(
            "SELECT kKategorie, cName FROM tkategorie WHERE 1"
        );

        return $data;
    }

    /**
     * @return array
     */
    public function getPropertyDesc(): array
    {
        return [
            'maxCategories' => [
                'type'     => InputType::NUMBER,
                'label'    => \__('maxCategories'),
                'width'    => 30,
                'default'  => 15,
                'required' => true,
            ],
            'cb-category-source' => [
                'type'     => InputType::SELECT,
                'label'    => \__('CategorySource'),
                'width'    => 33,
                'options'  => [
                    'explicit'  => \__('All Category'),
                    'filter'    => \__('Select Category'),
                ],
                'default'  => 'filter',
                'required' => true,
            ],
        ];
    }

    /**
     * @return array
     */
    public function getPropertyTabs(): array
    {
        return [
            \__('Styles') => 'styles',
        ];
    }

    /**
     * @param PortletInstance $instance
     * @return string
     * @throws \Exception
     */
    public function getConfigPanelHtml(PortletInstance $instance): string
    {
        $selectedCategories = [];
        if ($instance->getProperty('cb-category-source') === "filter") {
            foreach ($this->getFilteredCategoryIds($instance) as $key => $categoryId) {
                $selectedCategories[] = $categoryId;
            }
        }
        Shop::Smarty()->assign([
            'categories' => $this->categories(),
            'selectedCategories' => $selectedCategories
        ]);
        return parent::getConfigPanelHtml($instance) . $this->getConfigPanelHtmlFromTpl($instance);
    }

    public function getFilteredCategoryIds(PortletInstance $instance): Collection
    {
        if ($instance->getProperty('cb-category-source') === "explicit") {
            $categories = [];
            foreach ($this->categories() as $category) {
                $categories[] = $category->kKategorie;
            }
        } else {
            $categories = $instance->getProperty('categories');
        }
        return (new Collection($categories))->slice(0, $instance->getProperty('maxCategories'));
    }


    /**
     * @param PortletInstance $instance
     * @return array
     * @throws CircularReferenceException
     * @throws ServiceNotFoundException
     */
    public function getFilteredCategories(PortletInstance $instance): array
    {
        $categories = [];
        foreach ($this->getFilteredCategoryIds($instance) as $key => $categoryId) {
            $categoryId = (int)$categoryId;
            if ($categoryId) {
                $category = new Kategorie($categoryId);
                $tmp = [];
                $tmp['kKategorie'] = (int)$category->getID();
                $tmp['cName'] = $category->getName();
                $tmp['image_url'] = $category->getImage();
                $tmp['category_url'] = $category->getURL();
                $categories[] = $tmp;
            }
        }

        return $categories;
    }
}