<?php

namespace GraphAwareReco\Domain;
use GraphAwareReco\Domain\Exception\ServerErrorException;
use GraphAwareReco\Domain\Exception\UnFoundItemException;
use GraphAwareReco\Domain\Model\Recommendation;

/**
 * @author      Peter Fox <peter.fox@peterfox.me>
 * @copyright   Peter Fox 2015
 *
 * @package     graphaware-reco-php-client
 */
interface GraphAwareRecoClient
{
    /**
     * @param array $parameters
     * @return Recommendation[]
     * @throws ServerErrorException
     * @throws UnFoundItemException
     */
    public function getRecommendations(array $parameters);
}