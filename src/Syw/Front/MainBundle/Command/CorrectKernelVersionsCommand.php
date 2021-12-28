<?php

namespace Syw\Front\MainBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use FOS\UserBundle\Model\User;
use Syw\Front\MainBundle\Entity\Kernels;
use Syw\Front\MainBundle\Entity\Machines;

/**
 *
 */
class CorrectKernelVersionsCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('syw:correct:kernelversions')
            ->setDescription('corrects and merges the kernel versions')
            ->setDefinition(array(
                new InputArgument('item', InputArgument::REQUIRED, 'the item to import')
            ))
            ->setHelp(<<<EOT
The <info>syw:correct:kernelversions</info> command corrects and merges the kernel versions.

EOT
            );
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $item = $input->getArgument('item');

        $lico       = $this->getContainer()->get('doctrine.dbal.lico_connection');
        $licotest   = $this->getContainer()->get('doctrine')->getManager();
        $licotestdb = $this->getContainer()->get('doctrine.dbal.default_connection');
        $db         = $this->getContainer()->get('doctrine')->getManager();
        $em         = $this->getContainer()->get('doctrine')->getManager();

        $importlogfile = "import.correct.kernelversions";


        if ($item == "start") {
            @exec("php app/console syw:correct:kernelversions continue >>".$importlogfile.".log 2>&1 3>&1 4>&1 &");
            exit(0);
        } else if ($item == "continue") {
            if (true === file_exists($importlogfile.'.db')) {
                $fp   = fopen($importlogfile.'.db', "r");
                $data = fread($fp, 1024);
                fclose($fp);
                $fp = null;
                unset($fp);
                $dataar  = explode(" ", trim($data));
                $start   = intval(trim($dataar[0]));
                $counter = intval(trim($dataar[1]));
            } else {
                $nums     = $licotestdb->fetchAll('SELECT COUNT(id) AS num FROM kernels');
                $numusers = $nums[0]['num'];
                $start    = 0; // $numusers;
                $counter  = 0;
            }
            $itemsperloop = 200;

            $z = 0;
            $a = $start;

            unset($rows);
            $kernels = $db->getRepository('SywFrontMainBundle:Kernels')->findBy(array(), array('id' => 'ASC'), $itemsperloop, $a);
            foreach ($kernels as $kernel) {
                $counter++;

                $machines = null;
                unset($machines);
                $machines = $kernel->getMachines();
                $var = $kernel->getName();

                if (preg_match("`^[^\.]{2,}\..*`", trim($var)) ||
                    preg_match("`^[05-9]{1,}\..*`", trim($var)) ||
                    preg_match("`^[1-4]{1}\.[^\.]{4,}\..*`", trim($var)) ||
                    preg_match("`^[1-4]{1}\.[^\.]{1,}\.[^\.-]{4,}.*`", trim($var))
                ) {
                    echo "> setting kernel " . $var . " (" . $kernel->getId() . ") to XXXXXXXXXXXXXXXXXXXX\n";
                    $kernel->setName("XXXXXXXXXXXXXXXXXXXX");
                    $kernel->setMachinesNum(-999999999);
                    // $em->flush();
                    foreach ($machines as $machine) {
                        $machine->setKernel(null);
                        // $em->flush();
                    }
                } else {
                    # trim the given kernel to major version, ie:  3.13.2
                    $version = preg_replace("`^([^\.-]+)\.([^\.-]+\.?[^\.-]*).*$`i", "$1.$2", trim($var));
                    $version = trim($version);
                    echo "=======================================================================\n";
                    echo "> old: " . $var . " | new " . $version . "\n";

                    if (preg_match("`^0\.`", $version)) {
                        echo "> setting kernel " . $var . " (" . $kernel->getId() . ") to XXXXXXXXXXXXXXXXXXXX\n";
                        $kernel->setName("XXXXXXXXXXXXXXXXXXXX");
                        $kernel->setMachinesNum(-999999999);
                        // $em->flush();
                        foreach ($machines as $machine) {
                            $machine->setKernel(null);
                            // $em->flush();
                        }
                        continue;
                    }

                    if (trim($var) != $version && $var != "XXXXXXXXXXXXXXXXXXXX") {
                        $obj = $em->getRepository('SywFrontMainBundle:Kernels')->findOneBy(array('name' => $version));
                        if (true === isset($obj) && true === is_object($obj) && $obj != null) {
                            foreach ($machines as $machine) {
                                $machine->setKernel($obj);
                                // $em->flush();
                            }
                            echo "> " . $obj->getName() . " found, setting kernel " . $var . " (" . $kernel->getId() . ") to XXXXXXXXXXXXXXXXXXXX\n";
                            $obj->setMachinesNum(sizeof($obj->getMachines()));
                            $kernel->setName("XXXXXXXXXXXXXXXXXXXX");
                            $kernel->setMachinesNum(-999999999);
                            // $em->flush();
                        } else {
                            echo "> Creating new kernel version " . $version . "\n";
                            $newkernel = new Kernels();
                            $newkernel->setName($version);
                            $em->persist($newkernel);
                            foreach ($machines as $machine) {
                                $machine->setKernel($newkernel);
                                // $em->flush();
                            }
                            $newkernel->setMachinesNum(sizeof($newkernel->getMachines()));
                            // $em->flush();
                        }
                    }
                }
                $em->flush();
                gc_collect_cycles();
            }

            $db->clear();
            $db->close();
            $licotest->clear();
            $licotest->close();
            $licotestdb->close();
            $lico->close();

            $licotest = null;
            unset($licotest);
            $licotestdb = null;
            unset($licotestdb);
            $lico = null;
            unset($lico);

            file_put_contents($importlogfile.'.db', ($a + $itemsperloop) . " " . $counter);
            @exec("php app/console syw:correct:kernelversions start >>".$importlogfile.".log 2>&1 3>&1 4>&1 &");
            exit(0);
        }

    }

    /**
     * @see Command
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {

    }
}
