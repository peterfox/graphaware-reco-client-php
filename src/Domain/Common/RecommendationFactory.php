<?php
/**
 * @author      Peter Fox <peter.fox@peterfox.me>
 * @copyright   Peter Fox 2015
 *
 * @package     graphaware-reco-php-client
 */

namespace GraphAwareReco\Domain\Common;

use GraphAwareReco\Domain\Common\Recommendation as RecommendationImpl;
use GraphAwareReco\Domain\Model\Recommendation;
use GraphAwareReco\Domain\Model\RecommendationFactory as RecommendationFactoryInterface;
use GraphAwareReco\Domain\Model\Score;

class RecommendationFactory implements RecommendationFactoryInterface
{
    /**
     * @param array $data
     * @return Recommendation
     */
    public function getRecommendation(array $data)
    {
        return new RecommendationImpl($data['id'], $data['uuid'], Score::fromArray($data['score']));
    }
}