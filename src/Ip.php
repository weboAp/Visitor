<?php

namespace Weboap\Visitor;

use Illuminate\Http\Request as Request;

/**
 * Class Ip.
 */
class Ip
{
    /**
     * @var null
     */
    protected $ip = null;

    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * Ip constructor.
     *
     * @param \Illuminate\Http\Request $request
     * @param array                    $validators
     */
    public function __construct(Request $request, array $validators = [])
    {
        $this->request = $request;
        $this->validators = $validators;
    }

    /**
     * @return string
     */
    public function get()
    {
        $ip = $this->request->getClientIp();

        if ($ip == '::1') {
            $ip = '127.0.0.1';
        }

        return $ip;
    }

    /**
     * @param null $ip
     *
     * @return bool
     */
    public function isValid($ip = null)
    {
        if (!isset($ip)) {
            return false;
        }

        foreach ($this->validators as $validator) {
            if (!$validator->validate($ip)) {
                return false;
            }
        }

        return true;
    }
}
