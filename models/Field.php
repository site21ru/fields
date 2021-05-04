<?php namespace Site21\Fields\Models;

use Model;
use Schema;

/**
 * Field Model
 */
class Field extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'site21_shopaholic_fields';


    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Validation rules for attributes
     */
    public $rules = [
        'name'      => 'required',
        'slug'      => 'required|unique:site21_shopaholic_fields',
        'type'      => 'required',
        'module'    => 'required',
    ];

    /**
     * @var array Attributes to be cast to native types
     */
    protected $casts = [];

    /**
     * @var array Attributes to be cast to JSON
     */
    protected $jsonable = [];

    /**
     * @var array Attributes to be appended to the API representation of the model (ex. toArray())
     */
    protected $appends = [];

    /**
     * @var array Attributes to be removed from the API representation of the model (ex. toArray())
     */
    protected $hidden = [];

    /**
     * @var array Attributes to be cast to Argon (Carbon) instances
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $hasOneThrough = [];
    public $hasManyThrough = [];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];


    function getModuleTable($module){
        $moduleTable = [
            'product'    => 'lovata_shopaholic_products',
            'offer'      => 'lovata_shopaholic_offers',
            'category'   => 'lovata_shopaholic_categories',
            'brand'      => 'lovata_shopaholic_brands',
        ];
        $obTable = $moduleTable[$module];
        return $obTable;
    }

    public function afterCreate()
    {
        $obTable = $this->getModuleTable($this->module);
        if (!Schema::hasTable($obTable) || Schema::hasColumn($obTable, $this->slug)) {
            return;
        }
        
        Schema::table($obTable, function ($table) {
            $type = [
                'text'       => 'string',
                'textarea'   => 'text'
            ];
            $obType = $type[$this->type];
            $table->$obType($this->slug)->nullable();
        });
    }


    public function afterDelete()
    {
        Schema::table($this->getModuleTable($this->module), function ($table) {
            $table->dropColumn($this->slug);
        });
    }

    public function afterUpdate()
    {
        if ($this->slug != $this->original['slug']) {
            Schema::table($this->getModuleTable($this->module), function ($table) {
                $table->renameColumn($this->original['slug'], $this->slug);
            }); 
        }
    }


}
