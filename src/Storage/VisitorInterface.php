<?php

namespace Weboap\Visitor\Storage;

/**
 * Interface VisitorInterface.
 */
interface VisitorInterface
{
    /**
     * @param array $data
     *
     * @return mixed
     */
    public function create(array $data);

    /**
     * @param $ip
     *
     * @return mixed
     */
    public function get($ip);

    /**
     * @param       $ip
     * @param array $data
     *
     * @return mixed
     */
    public function update($ip, array $data);

    /**
     * @param $ip
     *
     * @return mixed
     */
    public function delete($ip);

    /**
     * @return mixed
     */
    public function all();

    /**
     * @param $ip
     *
     * @return mixed
     */
    public function count($ip);

    /**
     * @param $ip
     *
     * @return mixed
     */
    public function increment($ip);

    /**
     * @return mixed
     */
    public function clicksSum();

    /**
     * @param $start
     * @param $end
     *
     * @return mixed
     */
    public function range($start, $end);
}
