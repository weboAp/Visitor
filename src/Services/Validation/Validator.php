<?php

namespace Weboap\Visitor\Services\Validation;

/**
 * Class Validator.
 */
class Validator implements ValidationInterface
{
    /**
     * @param $ip
     *
     * @return bool
     */
    public function validate($ip)
    {
        if ($this->_is_ip4($ip) || $this->_is_ipv6($ip)) {
            return true;
        }
    }

    /**
     * @param $ip
     *
     * @return bool
     */
    private function _is_ip4($ip)
    {
        return filter_var($ip, FILTER_VALIDATE_IP) !== false;
    }

    /**
     * @param $ip
     *
     * @return bool
     */
    private function _is_ipv6($ip)
    {
        return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) !== false;
    }
}
