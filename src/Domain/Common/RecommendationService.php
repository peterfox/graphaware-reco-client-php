<?php
/**
 * @author      Peter Fox <peter.fox@peterfox.me>
 * @copyright   Peter Fox 2015
 *
 * @package     graphaware-reco-php-client
 */

namespace GraphAwareReco\Domain\Common;

use GraphAwareReco\Domain\Model\RecommendationService as RecommendationServiceInterface;

class RecommendationService implements RecommendationServiceInterface
{

    /**
     * @var string
     */
    private $baseUrl;

    /**
     * @param string $baseUrl
     */
    public function __construct($baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * @return array
     */
    public function getUriParameters()
    {
        return ['id' => 'string'];
    }

    /**
     * @return array
     */
    public function getQueryParameters()
    {
        return ['limit' => 'string'];
    }

    /**
     * @return string
     */
    public function getRecommendationPath()
    {
        return '/graphaware/recommendation/{id}';
    }
}