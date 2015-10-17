<?php
/**
 * @author      Peter Fox <peter.fox@peterfox.me>
 * @copyright   Peter Fox 2015
 *
 * @package     graphaware-reco-php-client
 */

namespace GraphAwareReco\Domain\Common;

use GraphAwareReco\Domain\Model\ResponseParser as ResponseParserInterface;

class ResponseParser implements ResponseParserInterface
{

    /**
     * @param array $result
     * @return array
     */
    public function parse(array $result)
    {
        return $result;
    }
}