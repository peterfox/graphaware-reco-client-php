<?php
/**
 * @author      Peter Fox <peter.fox@peterfox.me>
 * @copyright   Peter Fox 2015
 *
 * @package     graphaware-reco-php-client
 */

namespace GraphAwareReco\Domain\Model;

class Score
{
    /**
     * @var float
     */
    private $totalScore;

    /**
     * @var ScorePart[]
     */
    private $scoreParts;

    public static function fromArray($data)
    {
        if (!array_key_exists('totalScore', $data) || !array_key_exists('scoreParts', $data)) {
            throw new \InvalidArgumentException('array does not contain \'totalScore\' or \'scoreParts\'');
        }

        if (!is_array($data['scoreParts'])) {
            throw new \InvalidArgumentException('\'scoreParts\' must be an array');
        }

        $score = new self();
        $score->setTotalScore($data['totalScore']);
        foreach($data['scoreParts'] as $keyScore => $scorePart) {
            $score->addScorePart($keyScore, ScorePart::fromArray($scorePart));
        }

        return $score;
    }

    /**
     * @return float
     */
    public function getTotalScore()
    {
        return $this->totalScore;
    }

    /**
     * @param float $totalScore
     */
    public function setTotalScore($totalScore)
    {
        $this->totalScore = $totalScore;
    }

    /**
     * @return ScorePart[]
     */
    public function getScoreParts()
    {
        return $this->scoreParts;
    }

    /**
     * @param $key
     * @return ScorePart
     */
    public function getScorePart($key)
    {
        return $this->scoreParts[$key];
    }

    /**
     * @param $key
     * @param ScorePart $scorePart
     */
    public function addScorePart($key, ScorePart $scorePart)
    {
        $this->scoreParts[$key] = $scorePart;
    }
}