<?php

namespace Weboap\Visitor\Services\Validation;

use Exception;
use Illuminate\Config\Repository as Config;
use Whitelist\Check;

/**
 * Class Checker.
 */
class Checker implements ValidationInterface
{
    /**
     * @var \Whitelist\Check
     */
    protected $checker;

    /**
     * @var \Illuminate\Config\Repository
     */
    protected $config;

    /**
     * Checker constructor.
     *
     * @param \Whitelist\Check              $checker
     * @param \Illuminate\Config\Repository $config
     */
    public function __construct(Check $checker, Config $config)
    {
        $this->checker = $checker;
        $this->config = $config;
    }

    /**
     * @param $ip
     *
     * @throws \Weboap\Visitor\Services\Validation\InvalidArgumentException
     *
     * @return bool
     */
    public function validate($ip)
    {
        $list = $this->config->get('visitor.ignored');

        if (!is_array($list)) {
            $list = [];
        }

        try {
            $this->checker->whitelist($list);
        } catch (InvalidArgumentException $e) {
            throw new InvalidArgumentException('invalid definition encountered in white list!');
        }

        /*
         *if ip is in the ignored list return false mean dont register
         * if ip is not in ignored list return  true  mean register
         **/
        return !$this->checker->check($ip);
    }
}

/**
 * Class InvalidArgumentException.
 */
class InvalidArgumentException extends Exception
{
}
