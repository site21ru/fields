<?php namespace Site21\Fields\Classes\Event\Category;

use Lovata\Shopaholic\Models\Category;
use Site21\Fields\Models\Field;

class ExtendCategoryModel
{
    public function subscribe()
    {
        Category::extend(function ($obCategory) {
			$fields = Field::where('module', 'category')->where('active', 1)->select('slug')->get();
        	if($fields) {
				$array = [];
				foreach($fields as $field) {
				    $obCategory->fillable[] = $field->slug;
				    $array[] = $field->slug;    
				}
	            $obCategory->addCachedField($array);
	        }
        });
    }
}