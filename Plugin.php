<?php namespace Site21\Fields;

use Backend;
use System\Classes\PluginBase;
use Event;
use Schema;
use Site21\Fields\Classes\Event\Product\ExtendProductFieldsHandler;
use Site21\Fields\Classes\Event\Product\ExtendProductModel;
use Site21\Fields\Classes\Event\Offer\ExtendOfferFieldsHandler;
use Site21\Fields\Classes\Event\Offer\ExtendOfferModel;
use Site21\Fields\Classes\Event\Category\ExtendCategoryFieldsHandler;
use Site21\Fields\Classes\Event\Category\ExtendCategoryModel;
use Site21\Fields\Classes\Event\Brand\ExtendBrandFieldsHandler;
use Site21\Fields\Classes\Event\Brand\ExtendBrandModel;

/**
 * Fields Plugin Information File
 */
class Plugin extends PluginBase
{
    public $require = ['Lovata.Shopaholic', 'Lovata.Toolbox'];

    public function pluginDetails()
    {
        return [
            'name'        => e(trans('site21.fields::lang.plugin.name')),
            'description' => e(trans('site21.fields::lang.plugin.description')),
            'author'      => 'Site21',
            'icon'        => 'icon-leaf',
            'homepage'    => 'https://site21.ru'
        ];
    }

    public function register()
    {

    }

    public function boot()
    {
        Event::listen('backend.menu.extendItems', function($manager) {
            $manager->addSideMenuItems('Lovata.Shopaholic', 'shopaholic-menu-main', [
                'fields' => [
                    'code'  => 'fields',
                    'label' => e(trans('site21.fields::lang.menu.label')),
                    'icon'  => 'icon-tags',
                    'url'   => Backend::url('site21/fields/fields'),
                    'order' => 550,
                ],
            ]);
        });
        if (class_exists('Lovata\Toolbox\Classes\Event\AbstractBackendFieldHandler') && Schema::hasTable('site21_shopaholic_fields')) {
            Event::subscribe(ExtendProductFieldsHandler::class);
            Event::subscribe(ExtendProductModel::class);
            Event::subscribe(ExtendOfferFieldsHandler::class);
            Event::subscribe(ExtendOfferModel::class);
            Event::subscribe(ExtendCategoryFieldsHandler::class);
            Event::subscribe(ExtendCategoryModel::class);
            Event::subscribe(ExtendBrandFieldsHandler::class);
            Event::subscribe(ExtendBrandModel::class);
        }
    }

    public function registerComponents()
    {
        return []; // Remove this line to activate

        return [
            'Site21\Fields\Components\MyComponent' => 'myComponent',
        ];
    }

    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'site21.fields.some_permission' => [
                'tab' => 'Fields',
                'label' => 'Some permission'
            ],
        ];
    }

    public function registerNavigation()
    {
        return []; // Remove this line to activate

        return [
            'fields' => [
                'label'       => 'Fields',
                'url'         => Backend::url('site21/fields/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['site21.fields.*'],
                'order'       => 500,
            ],
        ];
    }
}
