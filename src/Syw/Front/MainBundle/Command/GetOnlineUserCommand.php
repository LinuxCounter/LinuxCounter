<?php

namespace Syw\Front\MainBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Syw\Front\MainBundle\Entity\StatsOnlineUsers;

/**
 *
 */
class GetOnlineUserCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('syw:get:onlineusers')
            ->setDescription('Saves the online users of the last 5 minutes (as statistical numbers) in the database')
            ->setDefinition(array())
            ->setHelp(<<<EOT
The <info>syw:get:onlineusers</info> command Saves the online users
of the last 5 minutes (as statistical numbers) in the database

EOT
            );
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $counts = $this->getOnlineUsers();

        $obj = null;
        unset($obj);
        $obj = new StatsOnlineUsers();
        $obj->setTimestamp(new \DateTime());
        $obj->setType('all');
        $obj->setNum($counts['complete']);
        $em->persist($obj);
        $em->flush();

        $obj = null;
        unset($obj);
        $obj = new StatsOnlineUsers();
        $obj->setTimestamp(new \DateTime());
        $obj->setType('loggedin');
        $obj->setNum($counts['loggedin']);
        $em->persist($obj);
        $em->flush();

        $output->writeln('Online users stored in statistics table.');
    }

    /**
     * @see Command
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {

    }

    public function getOnlineUsers()
    {
        $counts = array();
        $em = $this->getContainer()->get('doctrine')->getManager();
        $qb = $em->createQueryBuilder();

        $qb->select($qb->expr()->countDistinct('a.ipaddress'))
            ->from('SywFrontMainBundle:Activity', 'a')
            ->where('a.createdat >= :when')
            ->setParameter('when', new \DateTime('-5 minutes'))
        ;
        $counts['complete'] = $qb->getQuery()->getSingleScalarResult();

        $qb->select($qb->expr()->countDistinct('a.ipaddress'))
            // ->from('SywFrontMainBundle:Activity', 'a')
            ->where('a.createdat >= :when')
            ->andwhere('a.isbot = :isbot')
            ->andwhere('a.user IS NOT NULL')
            ->setParameter('when', new \DateTime('-5 minutes'))
            ->setParameter('isbot', '0')
        ;
        $counts['loggedin'] = $qb->getQuery()->getSingleScalarResult();

        return $counts;
    }
}
