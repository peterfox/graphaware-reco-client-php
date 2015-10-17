<?php
/**
 * @author      Peter Fox <peter.fox@peterfox.me>
 * @copyright   Peter Fox 2015
 *
 * @package     graphaware-reco-php-client
 */

namespace GraphAwareReco\Bridge\Guzzle;

use GraphAwareReco\Domain\Exception\ServerErrorException;
use GraphAwareReco\Domain\Exception\UnFoundItemException;
use GraphAwareReco\Domain\GraphAwareRecoClient;
use GraphAwareReco\Domain\Model\Recommendation;
use GraphAwareReco\Domain\Model\RecommendationFactory;
use GraphAwareReco\Domain\Model\RecommendationService;
use GraphAwareReco\Domain\Model\ResponseParser;
use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\Command\Exception\CommandClientException;
use GuzzleHttp\Command\Guzzle\GuzzleClient;

class Client implements GraphAwareRecoClient
{
    /**
     * @var GuzzleClient
     */
    private $client;
    /**
     * @var RecommendationFactory
     */
    private $factory;
    /**
     * @var ResponseParser
     */
    private $parser;

    public function __construct(GuzzleClient $client, RecommendationFactory $factory, ResponseParser $parser)
    {
        $this->client = $client;
        $this->factory = $factory;
        $this->parser = $parser;
    }

    /**
     * @param array $parameters
     * @return \GraphAwareReco\Domain\Model\Recommendation[]
     * @throws ServerErrorException
     * @throws UnFoundItemException
     */
    public function getRecommendations(array $parameters)
    {
        $command = $this->client->getCommand('recommendations', $parameters);
        try {
            $result = $this->client->execute($command);
        } catch(CommandClientException $ex) {
            if ($ex->getResponse()->getStatusCode() == 404) {
                throw new UnFoundItemException($parameters, $ex->getResponse()->getBody());
            } elseif ($ex->getResponse()->getStatusCode() == 500) {
                throw new ServerErrorException($parameters, $ex->getResponse()->getBody());
            } else {
                throw new ServerErrorException($parameters, $ex->getResponse()->getBody());
            }
        }

        $recommendationResults = $this->parser->parse($result);

        $recommendations = [];

        foreach($recommendationResults as $recommendation) {
            $recommendations[] = $this->factory->getRecommendation($recommendation);
        }

        return $recommendations;
    }
}