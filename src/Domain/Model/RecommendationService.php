<?php
/**
 * @author      Peter Fox <peter.fox@peterfox.me>
 * @copyright   Peter Fox 2015
 *
 * @package     graphaware-reco-php-client
 */

namespace GraphAwareReco\Domain\Model;

interface RecommendationService
{
    /**
     * @return string
     */
    public function getBaseUrl();

    /**
     * @return array
     */
    public function getUriParameters();

    /**
     * @return array
     */
    public function getQueryParameters();

    /**
     * @return string
     */
    public function getRecommendationPath();
}