GraphAware-Reco client for PHP
------------------------------

The client is designed to work in turning recommendations and scores from a GraphAware Recommendation endpoint into objects
that are easy to work with.

The current implementation uses Guzzle but can easily build your own to work with any HTTP client library.

Install
=======

Use composer to get the package

```ssh
composer require peterfox/graphaware-reco-client
```

Basic Setup
===========

A basic example can use the common implementations of the interfaces set out but it's easy to create your own or extend the common
ones to make it work with your own tweaks to the recommendations end point you've created.

```php
use GraphAwareReco\Bridge\Guzzle\Client;
use GraphAwareReco\Bridge\Guzzle\RecommendationDescriptionBuilder;
use GraphAwareReco\Domain\Common\RecommendationFactory;
use GraphAwareReco\Domain\Common\RecommendationService;
use GraphAwareReco\Domain\Common\JsonResponseParser;
use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\Command\Guzzle\GuzzleClient;

$service = new RecommendationService('http://localhost:7474/');

$description = RecommendationDescriptionBuilder::getDescriptionFromService($service);

$guzzle = new GuzzleClient(new Guzzle(), $description, ['defaults' => []]);

$client = new Client($guzzle, new RecommendationFactory(), new JsonResponseParser());
```

You can then just supply a parameter array to fetch a set of recommendations

```php
$recommendations = $client->getRecommendations(['id' => 1, 'limit' => 30]);
```

Implement your own service
==========================

You can implement your own setup as needed, the common classes are mainly for examples and because they cover how most
developers would set up a recommendation endpoint for their service.

###Create a recommendation service

The purpose of the RecommendationService interface is to simply state the uri for the endpoint and any arguments that
you'll use for to request your recommendations.

```php
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
```

###Create a response parser

Overall the response parser is simply used as a way of taking the json as an array and breaking it down into an array of recommendations.
By default most setups will just be an array of recommendations already so nothing happens in the common example but if
you need to change that you can.

```php
use GraphAwareReco\Domain\Model\JsonResponseParser as ResponseParserInterface;

class JsonResponseParser implements ResponseParserInterface
{

    /**
     * @param array $result
     * @return array
     */
    public function parse(array $result)
    {
        return $result;
    }
}
```

###Create a recommendation model

Your models might differ from the common example as each recommendation might provide more details about the nodes it's
recommending, as such you can implement your own.

```php
use GraphAwareReco\Domain\Model\Recommendation as RecommendationInterface;
use GraphAwareReco\Domain\Model\Score;

class Recommendation implements RecommendationInterface
{
    /**
     * @var
     */
    private $identifier;
    /**
     * @var
     */
    private $uuid;
    /**
     * @var
     */
    private $score;

    public function __construct($identifier, $uuid, $score)
    {
        $this->identifier = $identifier;
        $this->uuid = $uuid;
        $this->score = $score;
    }

    /**
     * @return string
     */
    public function getUUID()
    {
        return $this->uuid;
    }

    /**
     * @return mixed
     */
    public function getItemIdentifier()
    {
        return $this->identifier;
    }

    /**
     * @return Score
     */
    public function getScore()
    {
        $this->score;
    }
}
```

###Create a recommendation factory

If you have made your own recommendation models you'll need to implement a factory for the client to initiate an instance
of it using the date for each recommendation.

```php
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
```

Testing
=======

There's some basic testing you can run for the library, namely PHPSpec and Behat. To run the behat tests you must also run
the tutu server to emulate a GraphAware Reco setup.

###Run tutu
```
cd tutu && php -S localhost:7474 -t web -d date.timezone=UTC
```

###Run behat:
```
bin/behat
```

###Run phpspec:
```
bin/phpspec
```

[Peter Fox]:http://www.peterfox.me