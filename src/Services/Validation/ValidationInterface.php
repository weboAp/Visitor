<?php

namespace Weboap\Visitor\Services\Validation;

/**
 * Interface ValidationInterface.
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
