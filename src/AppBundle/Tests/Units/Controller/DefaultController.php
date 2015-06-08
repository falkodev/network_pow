<?php

namespace AppBundle\Tests\Units\Controller;

use atoum;

class DefaultController extends atoum
{
    public function testDummy()
    {
        $this
            ->if($a = 1)
            ->then
            ->integer($a)->isEqualTo(1);

    }
}
