<?php
/**
 * @author      Peter Fox <peter.fox@peterfox.me>
 * @copyright   Peter Fox 2015
 *
 * @package     graphaware-reco-php-client
 */

namespace GraphAwareReco\Domain\Model;

interface Recommendation
{
    /**
     * @return string
     */
    public function getUUID();

    /**
     * @return mixed
     */
    public function getItemIdentifier();

    /**
     * @return Score
     */
    public function getScore();
}