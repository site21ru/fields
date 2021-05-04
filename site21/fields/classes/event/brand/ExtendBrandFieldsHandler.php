<?php namespace Site21\Fields\Classes\Event\Brand;

use Lovata\Toolbox\Classes\Event\AbstractBackendFieldHandler;

use Lovata\Shopaholic\Models\Brand;
use Lovata\Shopaholic\Controllers\Brands;
use Site21\Fields\Models\Field;


class ExtendBrandFieldsHandler extends AbstractBackendFieldHandler
{
    protected function extendFields($obWidget)
    {
        // Получаем все кастомные поля только для бренда
        $fields = Field::where('module', 'brand')->where('active', 1)->select('name', 'slug', 'type')->get();
        if($fields) {
            $arAdditionFields = [];
            foreach($fields as $field) {
                $arAdditionFields[$field->slug] = [
                    'label'   => $field->name,
                    'type'    => $field->type,
                ];
            }

            $obWidget->addTabFields($arAdditionFields);
        }
    }

    protected function getModelClass() : string
    {
        return Brand::class;
    }

    protected function getControllerClass() : string
    {
        return Brands::class;
    }
}