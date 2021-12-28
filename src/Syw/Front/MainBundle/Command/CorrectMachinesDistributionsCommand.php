<?php

namespace Syw\Front\MainBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use FOS\UserBundle\Model\User;
use Syw\Front\MainBundle\Entity\StatsRegistration;

/**
 *
 */
class CorrectMachinesDistributionsCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('syw:correct:distributions')
            ->setDescription('Re-adds the profile id to the user table')
            ->setDefinition(array())
            ->setHelp(<<<EOT
The <info>syw:correct:distributions</info> command corrects the distributions.

EOT
            );
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $db = $this->getContainer()->get('doctrine')->getManager();

        $importlogfile = "import.correct.machines.distributions";

        $distributions = $db->getRepository('SywFrontMainBundle:Distributions')->findByLower('machinesnum', '50');
        foreach ($distributions as $distribution) {
            $machines = null;
            unset($machines);
            $machines = $distribution->getMachines();
            $mnum = count($machines);
            $desc = $distribution->getDescription();

            if ($mnum <= 49 && ($desc == null || trim($desc) == "")) {
                $mnum = -999999;
                foreach ($machines as $machine) {
                    $machine->setDistribution(null);
                    $db->persist($machine);
                }
            }

            $distribution->setMachinesNum($mnum);
            $db->persist($distribution);
            $db->flush();
            gc_collect_cycles();
        }
        gc_collect_cycles();
    }

    /**
     * @see Command
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {

    }
}
