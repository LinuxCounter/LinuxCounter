<?php

namespace Syw\Front\MainBundle\Twig;

/**
 * Class MainTwigExtension
 *
 * @category FormType
 * @package  SywFrontMainBundle
 * @author   Christin Löhner <alex.loehner@linux.com>
 * @license  GPL v3
 * @link     https://github.com/christinloehner/linuxcounter.new
 */
class MainTwigExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('secformat', array($this, 'secFormatFilter')),
        );
    }

    public function secFormatFilter($seconds)
    {
        $time_in_seconds = ceil($seconds);

        // Check for 0
        if ($time_in_seconds == 0) {
            return 'Less than a second';
        }

        // Years
        $years = floor($time_in_seconds / (60 * 60 * 24 * 365));
        $time_in_seconds -= $years * (60 * 60 * 24 * 365);

        // Days
        $days = floor($time_in_seconds / (60 * 60 * 24));
        $time_in_seconds -= $days * (60 * 60 * 24);

        // Hours
        $hours = floor($time_in_seconds / (60 * 60));
        $time_in_seconds -= $hours * (60 * 60);

        // Minutes
        $minutes = floor($time_in_seconds / 60);
        $time_in_seconds -= $minutes * 60;

        // Seconds
        $seconds = floor($time_in_seconds);

        // Format for return
        $return = '';
        if ($years > 0) {
            $return .= $years . ' year' . ($years == 1 ? '' : 's'). ' ';
        }
        if ($days > 0) {
            $return .= $days . ' day' . ($days == 1 ? '' : 's'). ' ';
        }
        if ($hours > 0) {
            $return .= $hours . ' hour' . ($hours == 1 ? '' : 's') . ' ';
        }
        if ($minutes > 0) {
            $return .= $minutes . ' minute' . ($minutes == 1 ? '' : 's') . ' ';
        }
        if ($seconds > 0) {
            $return .= $seconds . ' second' . ($seconds == 1 ? '' : 's') . ' ';
        }
        $return = trim($return);

        return $return;
    }

    public function getName()
    {
        return 'app_extension';
    }
}
