<?php namespace Weboap\Visitor\Models;



use \Illuminate\Database\Eloquent\Model as Eloquent;

class VisitorModel extends Eloquent {

    protected $table = "visitor_registry";
    protected $fillable = array(
				'ip',
				'geo',
                                'counter'
				);
    
    
    
    
    
    
    
}