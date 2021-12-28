<?php

namespace Syw\Front\MainBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use FOS\UserBundle\Model\User;

/**
 *
 */
class DeleteOldestActivityCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('syw:activity:delete')
            ->setDescription('Delete oldest activities')
            ->setDefinition(array())
            ->setHelp(<<<EOT
The <info>fos:activity:delete</info> command deletes the oldest activities.

EOT
            );
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $licotestdb = $this->getContainer()->get('doctrine.dbal.default_connection');
        $licotestdb->exec('DELETE FROM activity WHERE DATE(createdat) <= DATE(DATE_SUB(NOW(), INTERVAL 1 MONTH))');
        $output->writeln('Activities deleted.');
    }

    /**
     * @see Command
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {

    }
}
