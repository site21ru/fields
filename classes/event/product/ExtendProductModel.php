<?php namespace Site21\Fields\Classes\Event\Product;

use Lovata\Shopaholic\Models\Product;
use Site21\Fields\Models\Field;

class ExtendProductModel
{
    public function subscribe()
    {
        Product::extend(function ($obProduct) {
			$fields = Field::where('module', 'product')->where('active', 1)->select('slug')->get();
        	if($fields) {
				$array = [];
				foreach($fields as $field) {
				    $obProduct->fillable[] = $field->slug;
				    $array[] = $field->slug;    
				}
	            $obProduct->addCachedField($array);
	        }
        });
    }
}