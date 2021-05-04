<?php namespace Site21\Fields\Classes\Event\Offer;

use Lovata\Shopaholic\Models\Offer;
use Site21\Fields\Models\Field;

class ExtendOfferModel
{
    public function subscribe()
    {
        Offer::extend(function ($obOffer) {
			$fields = Field::where('module', 'offer')->where('active', 1)->select('slug')->get();
        	if($fields) {
				$array = [];
				foreach($fields as $field) {
				    $obOffer->fillable[] = $field->slug;
				    $array[] = $field->slug;    
				}
	            $obOffer->addCachedField($array);
	        }
        });
    }
}