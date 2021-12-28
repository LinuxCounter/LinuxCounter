<?php

namespace Syw\Front\MainBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class SywFrontMainBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
