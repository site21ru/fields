<?php namespace Site21\Fields\Classes\Event\Brand;

use Lovata\Shopaholic\Models\Brand;
use Site21\Fields\Models\Field;

class ExtendBrandModel
{
    public function subscribe()
    {
        Brand::extend(function ($obBrand) {
			$fields = Field::where('module', 'product')->where('active', 1)->select('slug')->get();
        	if($fields) {
				$array = [];
				foreach($fields as $field) {
				    $obBrand->fillable[] = $field->slug;
				    $array[] = $field->slug;    
				}
	            $obBrand->addCachedField($array);
	        }
        });
    }
}