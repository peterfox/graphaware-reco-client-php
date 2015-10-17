<?php
/**
 * @author      Peter Fox <peter.fox@peterfox.me>
 * @copyright   Peter Fox 2015
 *
 * @package     graphaware-reco-php-client
 */

namespace GraphAwareReco\Bridge\Guzzle;

use GraphAwareReco\Domain\Model\RecommendationService;
use GuzzleHttp\Command\Guzzle\Description;

class RecommendationDescriptionBuilder
{
    private $baseUrl;
    private $path;
    private $uriParameters = [];
    private $queryParameters = [];

    public static function getDescriptionFromService(RecommendationService $service)
    {
        $builder = (new RecommendationDescriptionBuilder())
            ->addBaseUrl($service->getBaseUrl())
            ->addPath($service->getRecommendationPath());

        foreach ($service->getUriParameters() as $parameter => $type) {
            $builder->addUriParameter($parameter, $type);
        }

        foreach ($service->getQueryParameters() as $parameter => $type) {
            $builder->addQueryParameter($parameter, $type);
        }

        return $builder->build();
    }

    public function addBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;
        return $this;
    }

    public function addPath($path)
    {
        $this->path = $path;
        return $this;
    }

    public function addUriParameter($parameter, $type = 'string')
    {
        $this->uriParameters[$parameter] = $this->getParameter($type, 'uri', true);
        return $this;
    }

    public function addQueryParameter($parameter, $type = 'string')
    {
        $this->queryParameters[$parameter] = $this->getParameter($type, 'query', false);
        return $this;
    }

    public function build()
    {
        return new Description([
            'baseUrl' => $this->baseUrl,
            'defaults' => [],
            'operations' => [
                'recommendations' => [
                    'httpMethod' => 'GET',
                    'uri' => $this->path,
                    'responseModel' => 'getRecommendations',
                    'parameters' => array_merge($this->queryParameters, $this->uriParameters)
                ]
            ],
            'models' => [
                'getRecommendations' => [
                    'type' => 'object',
                    'additionalProperties' => [
                        'location' => 'json'
                    ]
                ]
            ]
        ]);
    }

    private function getParameter($type, $location, $required = false) {
        return [
            'type' => $type,
            'location' => $location
        ];
    }
}