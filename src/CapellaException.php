<?php

namespace Capella;

class CapellaException extends \Exception
{

    public function __construct($message = "")
    {
        parent::__construct($message);
    }

}