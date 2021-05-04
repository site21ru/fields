<?php namespace Site21\Fields\Classes\Event\Category;

use Lovata\Toolbox\Classes\Event\AbstractBackendFieldHandler;

use Lovata\Shopaholic\Models\Category;
use Lovata\Shopaholic\Controllers\Categories;
use Site21\Fields\Models\Field;


class ExtendCategoryFieldsHandler extends AbstractBackendFieldHandler
{

    protected function extendFields($obWidget)
    {
        // Получаем все кастомные поля только для категории
        $fields = Field::where('module', 'category')->where('active', 1)->select('name', 'slug', 'type')->get();
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
        return Category::class;
    }

    protected function getControllerClass() : string
    {
        return Categories::class;
    }
}