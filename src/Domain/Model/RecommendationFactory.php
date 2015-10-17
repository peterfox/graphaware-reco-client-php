<?php
/**
 * @author      Peter Fox <peter.fox@peterfox.me>
 * @copyright   Peter Fox 2015
 *
 * @package     graphaware-reco-php-client
 */

namespace GraphAwareReco\Domain\Model;

interface RecommendationFactory
{
    /**
     * @param array $data
     * @return Recommendation
     */
    public function getRecommendation(array $data);
}