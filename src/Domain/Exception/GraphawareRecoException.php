<?php
/**
 * @author      Peter Fox <peter.fox@peterfox.me>
 * @copyright   Peter Fox 2015
 *
 * @package     graphaware-reco-php-client
 */

namespace GraphAwareReco\Domain\Exception;

use Exception;

class GraphAwareRecoException extends Exception
{
    /**
     * @var array
     */
    private $inputParameters;

    public function __construct($inputParameters = [], $message = "", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->inputParameters = $inputParameters;
    }

    /**
     * @return array
     */
    public function getInputParameters()
    {
        return $this->inputParameters;
    }
}