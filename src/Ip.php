<?php namespace Weboap\Visitor;



use Illuminate\Http\Request as Request;


class Ip {
    
    protected $ip = null;
    
    protected $request;
    
    
    public function __construct(Request $request, array $validators = array())
    {
        $this->request = $request;
        $this->validators = $validators;
        
    }

    public function get()
    {
        $ip = $this->request->getClientIp();

        if($ip == '::1') {
            $ip = '127.0.0.1';
        }

        return $ip;
        
    }
    
    public function isValid( $ip = null )
    {
        if( ! isset( $ip ) )
	{
	    return false;
	}
        
	foreach ($this->validators as $validator)
            {
                    if( ! $validator->validate( $ip ) ) return false;
            }
		
	return true;
    }
    
    
    
    
    
}