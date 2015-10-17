<?php
/**
 * @author      Peter Fox <peter.fox@peterfox.me>
 * @copyright   Peter Fox 2015
 *
 * @package     graphaware-reco-php-client
 */

namespace GraphAwareReco\Domain\Model;

class ScorePart
{
    /**
     * @var float
     */
    private $value;
    /**
     * @var string[]
     */
    private $reasons;

    public static function fromArray($data)
    {
        if (!array_key_exists('value', $data) || !array_key_exists('reasons', $data)) {
            throw new \InvalidArgumentException('array does not contain \'value\' or \'reasons\'');
        }

        if (!is_array($data['reasons'])) {
            throw new \InvalidArgumentException('\'reasons\' must be an array');
        }

        $scorePart = new self();

        $scorePart->setValue($data['value']);
        $scorePart->setReasons($data['reasons']);

        return $scorePart;
    }

    /**
     * @return float
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param float $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return string[]
     */
    public function getReasons()
    {
        return $this->reasons;
    }

    /**
     * @param string[] $reasons
     */
    public function setReasons($reasons)
    {
        $this->reasons = $reasons;
    }
}