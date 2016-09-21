<?php namespace Weboap\Visitor\Services\Validation;


/**
 * Interface ValidationInterface
 *
 * @package Weboap\Visitor\Services\Validation
 */
interface ValidationInterface
{

    /**
     * @param $ip
     *
     * @return mixed
     */
    public function validate($ip);

}