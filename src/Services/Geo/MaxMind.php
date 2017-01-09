<?php

namespace Weboap\Visitor\Services\Geo;

use GeoIp2\Database\Reader;
use GeoIp2\Exception\AddressNotFoundException;
use Illuminate\Config\Repository as Config;
use Weboap\Visitor\Ip;

/**
 * Class MaxMind.
 */
class MaxMind implements GeoInterface
{
    /**
     * @var
     */
    protected $reader;

    /**
     * @var \Illuminate\Config\Repository
     */
    protected $config;

    /**
     * @var \Weboap\Visitor\Ip
     */
    protected $ip;

    /**
     * MaxMind constructor.
     *
     * @param \Illuminate\Config\Repository $config
     * @param \Weboap\Visitor\Ip            $ip
     */
    public function __construct(Config $config, Ip $ip)
    {
        $this->config = $config;
        $this->ip = $ip;
    }

    /**
     * @return array
     */
    public function locate()
    {
        //
        $ip = $this->ip->get();
        $db = $this->config->get('visitor.maxmind_db_path');

        if (!is_string($db) || !file_exists($db) || !$this->ip->isValid($ip)) {
            return [];
        }

        $this->reader = new Reader($db);

        try {
            $record = $this->reader->city($ip);

            return [
                'country_code' => $record->country->isoCode,
                'country_name' => $record->country->name,
                'state_code'   => $record->mostSpecificSubdivision->isoCode,
                'state'        => $record->mostSpecificSubdivision->name,
                'city'         => $record->city->name,
                'postale_code' => $record->postal->code,

            ];
        } catch (AddressNotFoundException $e) {
            return [];
        }
    }
}
