<?php

namespace Syw\Front\NewsBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class SywFrontNewsBundle
 *
 * @category Bundle
 * @package  SywFrontNewsBundle
 * @author   Christin Löhner <alex.loehner@linux.com>
 * @license  GPL v3
 * @link     https://github.com/christinloehner/linuxcounter.new
 */
class SywFrontNewsBundle extends Bundle
{
    public function getParent()
    {
        return 'BladeTesterLightNewsBundle';
    }
}
