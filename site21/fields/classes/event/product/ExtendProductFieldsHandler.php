<?php namespace Site21\Fields\Classes\Event\Product;

use Lovata\Toolbox\Classes\Event\AbstractBackendFieldHandler;
use Lovata\Shopaholic\Models\Product;
use Lovata\Shopaholic\Controllers\Products;
use Site21\Fields\Models\Field;


class ExtendProductFieldsHandler extends AbstractBackendFieldHandler
{
    protected function extendFields($obWidget)
    {
        // Получаем все кастомные поля только для товара
        $fields = Field::where('module', 'product')->where('active', 1)->select('name', 'slug', 'type')->get();
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
        return Product::class;
    }
    protected function getControllerClass() : string
    {
        return Products::class;
    }
}