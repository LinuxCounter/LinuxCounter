<?php

namespace Syw\Front\MainBundle\Util;

use Symfony\Component\DependencyInjection\ContainerAware;

/**
 * Class DetectBotFromUserAgent
 *
 * @category FormType
 * @package  SywFrontMainBundle
 * @author   Christin Löhner <alex.loehner@linux.com>
 * @license  GPL v3
 * @link     https://github.com/christinloehner/linuxcounter.new
 */
class DetectBotFromUserAgent extends ContainerAware
{
    /**
     * Checks if the user is a search robot or not
     * @author    Christin Löhner
     * @author    Eric Appelt
     * @copyright 2011
     * @return integer userid
     * @since     2.9.1 / 02.03.2011
     */
    public function licoIsBot($agent = false, $ip = false)
    {
        // use when browscap.ini is set in php.ini
        if (ini_get('browscap')) {
            if ($agent === false) {
                $browser = get_browser(null, true);
            } else {
                $browser = get_browser(trim($agent), true);
            }
            if (!empty($browser['crawler']) and $browser['crawler'] != '0') {
                return true;
            }
        }
        if ($this->licoIsBotAgent()) {
            if ($this->licoIsBotHost(gethostbyaddr($ip))) {
                return true;
            }
            // SET IF return true when bot host address is not verified
            return true;
        } elseif ($this->licoIsFacebook($agent)) {
            return true;
        }
        return false;
    }

    /**
     * Checks if the user agent is a search robot or not
     * @author    Eric Appelt
     * @copyright 2011
     * @return integer userid
     * @since     2.9.1 / 02.03.2011
     */
    public function licoIsBotAgent($agent = false)
    {
        $knownbots = array(
            'bot',
            'crawl',
            'search',
            'get',
            'spider',
            'find',
            'java',
            'google',
            'yahoo',
            'ask',
            'contaxe',
            'yandex',
            'libwww-perl',
            'Feedfetcher',
            'wget',
            'GbPlugin',
            'newsbeuter',
            'check_http',
            'Syndication',
            'Feed',
            'Liferea',
            'Gist Server',
            'postrank',
            'Test Certificate',
            'urlresolver',
            'Summify',
            'Wordpress'
        );

        foreach ($knownbots as $bot) {
            if (stripos($agent, $bot) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * Checks if the user host is a search robot or not
     * @author    Eric Appelt
     * @copyright 2011
     * @return integer userid
     * @since     2.9.1 / 02.03.2011
     */
    public function licoIsBotHost($host)
    {
        if (strpos($host, 'googlebot.com') !== false ||
            strpos($host, 'tweetmeme.com') !== false ||
            strpos($host, 'paper.li') !== false ||
            strpos($host, 'exabot.com') !== false ||
            strpos($host, 'crawl.yahoo.net') !== false
        ) {
            return true;
        }

        return false;
    }

    /**
     * Checks if the user agent is a facebook
     * @author    Eric Appelt
     * @copyright 2011
     * @return integer userid
     * @since     2.9.1 / 02.03.2011
     */
    public function licoIsFacebook($agent = false)
    {
        if (stripos($agent, 'facebook') !== false) {
            return true;
        }
        return false;
    }
}
