<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use GraphAwareReco\Bridge\Guzzle\Client;
use GraphAwareReco\Bridge\Guzzle\RecommendationDescriptionBuilder;
use GraphAwareReco\Domain\Common\RecommendationFactory;
use GraphAwareReco\Domain\Common\RecommendationService;
use GraphAwareReco\Domain\Common\ResponseParser;
use GraphAwareReco\Domain\Exception\GraphAwareRecoException;
use GraphAwareReco\Domain\Exception\ServerErrorException;
use GraphAwareReco\Domain\Exception\UnFoundItemException;
use GraphAwareReco\Domain\Model\Recommendation;
use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\Command\Guzzle\GuzzleClient;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context, SnippetAcceptingContext
{
    /**
     * @var Client
     */
    private $client;
    /**
     * @var Recommendation[]
     */
    private $recommendations;
    /**
     * @var GraphAwareRecoException
     */
    private $exception;

    /**
     * @Given I have a service description
     */
    public function iHaveAServiceDescription()
    {
        $service = new RecommendationService('http://localhost:7474/');
        $description = RecommendationDescriptionBuilder::getDescriptionFromService($service);
        $guzzle = new GuzzleClient(new Guzzle(), $description, ['defaults' => []]);
        $this->client = new Client($guzzle, new RecommendationFactory(), new ResponseParser());
    }

    /**
     * @When I request recommendations for id :id and with a limit of :limit
     */
    public function iRequestRecommendationsForIdAndWithALimitOf($id, $limit)
    {
        try {
            $this->recommendations = $this->client->getRecommendations(['id' => $id, 'limit' => $limit]);
        } catch (Exception $ex) {
            $this->exception = $ex;
        }
    }

    /**
     * @Then I should receive :count recommendations
     */
    public function iShouldReceiveRecommendations($count)
    {
        if ($this->exception) {
            print_r($this->exception->getMessage());
        }

        expect(is_array($this->recommendations))->toBe(true);
        expect(count($this->recommendations))->toBe((int)$count);
    }

    /**
     * @Then I should have an exception for an unknown id
     */
    public function iShouldHaveAnExceptionForAnUnknownId()
    {
        expect($this->exception)->beAnInstanceOf(UnFoundItemException::class);
    }

    /**
     * @Then I should have an exception for a server failure
     */
    public function iShouldHaveAnExceptionAServerFailure()
    {
        expect($this->exception)->beAnInstanceOf(ServerErrorException::class);
    }
}
