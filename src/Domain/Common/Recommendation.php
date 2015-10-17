<?php
/**
 * @author      Peter Fox <peter.fox@peterfox.me>
 * @copyright   Peter Fox 2015
 *
 * @package     graphaware-reco-php-client
 */

namespace GraphAwareReco\Domain\Common;

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