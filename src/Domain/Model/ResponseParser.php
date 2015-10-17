<?php
/**
 * @author      Peter Fox <peter.fox@peterfox.me>
 * @copyright   Peter Fox 2015
 *
 * @package     graphaware-reco-php-client
 */

namespace GraphAwareReco\Domain\Model;

interface ResponseParser
{
    /**
     * @param array $data
     * @return array
     */
    public function parse(array $data);
}