<?php

namespace AppBundle\Helper;


interface TokenGeneratorInterface
{
    /**
     * @return string
     */
    public function generateToken();
}
