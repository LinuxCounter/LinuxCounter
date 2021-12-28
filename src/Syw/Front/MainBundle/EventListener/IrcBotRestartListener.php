<?php

namespace Syw\Front\MainBundle\EventListener;

use Whisnet\IrcBotBundle\EventListener\Plugins\Commands\CommandListener;
use Whisnet\IrcBotBundle\Event\BotCommandFoundEvent;
use Whisnet\IrcBotBundle\Message\Message;
use Whisnet\IrcBotBundle\IrcCommands\QuitCommand;

/**
 * Class HelloListener
 *
 * @category FormType
 * @package  SywFrontMainBundle
 * @author   Christin Löhner <alex.loehner@linux.com>
 * @license  GPL v3
 * @link     https://github.com/christinloehner/linuxcounter.new
 */
class IrcBotRestartListener extends CommandListener
{
    public function onCommand(BotCommandFoundEvent $event)
    {
        $this->sendMessage(array($event->getChannel()), 'Will be back soon...');
        $this->connection->sendCommand(new QuitCommand(new Message('Restarting...')));
        $pid = @exec('ps ax | grep "app/console" | grep "irc:launch" | grep -v grep | xargs | sed "s/^\([0-9]*\) .*/\1/"');
        @exec('php app/console irc:launch >/dev/null 2>&1 &');
        @exec('kill '.$pid.' >/dev/null 2>&1');
        sleep(2);
    }
}
