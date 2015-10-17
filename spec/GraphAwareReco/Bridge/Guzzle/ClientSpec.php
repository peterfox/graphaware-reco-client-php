<?php
/**
 * @author      Peter Fox <peter.fox@peterfox.me>
 * @copyright   Peter Fox 2015
 *
 * @package     Default (Template) Project
 */

namespace spec\GraphAwareReco\Bridge\Guzzle;

use GraphAwareReco\Bridge\Guzzle\Client;
use GraphAwareReco\Domain\Common\Recommendation;
use GraphAwareReco\Domain\Model\RecommendationFactory;
use GraphAwareReco\Domain\Model\ResponseParser;
use GraphAwareReco\Domain\Model\Score;
use GuzzleHttp\Command\Command;
use GuzzleHttp\Command\Guzzle\GuzzleClient;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class ClientSpec
 * @package spec\GraphAwareReco\Bridge\Guzzle
 * @mixin Client
 */
class ClientSpec extends ObjectBehavior
{
    function let(GuzzleClient $client, RecommendationFactory $factory, ResponseParser $parser)
    {
        $this->beConstructedWith($client, $factory, $parser);
    }

    function it_should_return_recommendations
    (
        GuzzleClient $client,
        ResponseParser $parser,
        RecommendationFactory $factory,
        Command $command
    ) {
        $parameters = ['id' => '1', 'limit' => 30];
        $client->getCommand('recommendations', $parameters)->willReturn($command);

        $results = [['id' => '1', 'uuid' => 'abc', ['score' => ['totalScore' => 0, 'scoreParts' => []]]]];

        $client->execute($command)->willReturn($results);

        $parser->parse($results)->willReturn($results);

        $factory
            ->getRecommendation(['id' => '1', 'uuid' => 'abc', ['score' => ['totalScore' => 0, 'scoreParts' => []]]])
            ->willReturn(new Recommendation('1', 'abc', new Score()));

        $recommendationResult = $this->getRecommendations($parameters);
        $recommendationResult->shouldBeArray();
    }
}