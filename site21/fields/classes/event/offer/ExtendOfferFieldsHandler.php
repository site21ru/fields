<?php namespace Site21\Fields\Classes\Event\Offer;

use Lovata\Toolbox\Classes\Event\AbstractBackendFieldHandler;

use Lovata\Shopaholic\Models\Offer;
use Lovata\Shopaholic\Controllers\Offers;

use Site21\Fields\Models\Field;


class ExtendOfferFieldsHandler extends AbstractBackendFieldHandler
{
    protected function extendFields($obWidget)
    {
        // Получаем все кастомные поля только для оффера
        $fields = Field::where('module', 'offer')->where('active', 1)->select('name', 'slug', 'type')->get();
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
        return Offer::class;
    }

    protected function getControllerClass() : string
    {
        return Offers::class;
    }
}