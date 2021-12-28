<?php

namespace Syw\Front\MainBundle\EventListener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Whisnet\IrcBotBundle\EventListener\Plugins\Commands\CommandListener;
use Whisnet\IrcBotBundle\Event\BotCommandFoundEvent;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Event\LifecycleEventArgs;

/**
 * Class HelloListener
 *
 * @category FormType
 * @package  SywFrontMainBundle
 * @author   Christin Löhner <alex.loehner@linux.com>
 * @license  GPL v3
 * @link     https://github.com/christinloehner/linuxcounter.new
 */
class IrcBotImportListener extends CommandListener
{
    protected $em;
    protected $container;

    public function setEntityManager(ContainerInterface $container, Doctrine $doctrine)
    {
        $this->em = $doctrine->getManager();
        $this->container = $container;
    }

    public function onCommand(BotCommandFoundEvent $event)
    {
        // get list of arguments passed after command
        // $args = $event->getArguments();

        $running = @exec('ps ax | grep "syw:import:lico" | grep -v grep');
        if (trim($running) == "") {
            $msg = "There is currently no import running.";
            $this->sendMessage(array($event->getChannel()), $msg);
        } else {
            $qb = $this->em->createQueryBuilder();
            $qb->select('count(user.id)');
            $qb->from('SywFrontMainBundle:User', 'user');
            $uCount = $qb->getQuery()->getSingleScalarResult();

            $qb = $this->em->createQueryBuilder();
            $qb->select('count(machines.id)');
            $qb->from('SywFrontMainBundle:Machines', 'machines');
            $mCount = $qb->getQuery()->getSingleScalarResult();

            $msg = "There are currently ".number_format($uCount)." users and ".number_format($mCount)." machines imported, out of around 600,000 users.";
            $this->sendMessage(array($event->getChannel()), $msg);




        }
    }
}
