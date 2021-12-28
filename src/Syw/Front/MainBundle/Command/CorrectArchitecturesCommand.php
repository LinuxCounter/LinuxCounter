<?php

namespace Syw\Front\MainBundle\Command;

use Proxies\__CG__\Syw\Front\MainBundle\Entity\Architectures;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use FOS\UserBundle\Model\User;
use Syw\Front\MainBundle\Entity\archs;
use Syw\Front\MainBundle\Entity\Machines;

/**
 *
 */
class CorrectArchitecturesCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('syw:correct:architectures')
            ->setDescription('corrects and merges the architectures versions')
            ->setDefinition(array(
                new InputArgument('item', InputArgument::REQUIRED, 'the item to import')
            ))
            ->setHelp(<<<EOT
The <info>syw:correct:architectures</info> command corrects and merges the architectures versions.

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

        $importlogfile = "import.correct.architectures";




        $allowed_archs = array(
            'alpha',
            'alpha64',
            'amd64',
            'arm',
            'arm64',
            'i286',
            'i386',
            'i486',
            'i586',
            'i686',
            'x86',
            'x86_64',
            'ppc',
            'ppc64',
            'mips',
            'mips64',
            'risc',
            'risc64',
            'sparc',
            'sparc64'
        );



        if ($item == "start") {
            @exec("php app/console syw:correct:architectures continue >>".$importlogfile.".log 2>&1 3>&1 4>&1 &");
            exit(0);
        } else if ($item == "continue") {
            $nums     = $licotestdb->fetchAll('SELECT COUNT(id) AS num FROM architectures');
            $numusers = $nums[0]['num'];
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
                $start    = 0; // $numusers;
                $counter  = 0;
            }
            $itemsperloop = 20;

            $z = 0;
            $a = $start;

            if ($a >= ($numusers+($itemsperloop*2))) {
                echo "Done.\n";
                exit(0);
                die();
            }


            unset($rows);
            $archs = $db->getRepository('SywFrontMainBundle:Architectures')->findBy(array(), array('id' => 'ASC'), $itemsperloop, $a);
            foreach ($archs as $arch) {
                $counter++;

                $newarchitecture = null;
                unset($newarchitecture);
                $obj = null;
                unset($obj);

                $machines = null;
                unset($machines);
                $machines = $arch->getMachines();
                $var = trim($arch->getName());
                $newarch = "";
                $delete = false;

                if (false === in_array($var, $allowed_archs)) {
                    #
                    #
                    #
                    #

                    if (false !== stripos($var, "arm") && false !== stripos($var, "64")) {
                        $newarch = "arm64";
                    } elseif (false !== stripos($var, "raspberry")) {
                        $newarch = "arm";
                    } elseif (false !== stripos($var, "arm")) {
                        $newarch = "arm";
                    } elseif (false !== stripos($var, "amd") && false !== stripos($var, "64")) {
                        $newarch = "amd64";
                    } elseif (false !== stripos($var, "x86") && false !== stripos($var, "64")) {
                        $newarch = "x86_64";
                    } elseif (false !== stripos($var, "x86")) {
                        $newarch = "x86";
                    } elseif (preg_match("`[xi]+-?[2-7]+86`i", $var)) {
                        $newarch = "i".preg_replace("`.*[xi]+-?([2-7]+86).*`i", "$1", $var);
                    } elseif (false !== stripos($var, "power") && false !== stripos($var, "64")) {
                        $newarch = "ppc64";
                    } elseif (false !== stripos($var, "intel core")) {
                        $newarch = "i686";
                    } elseif (false !== stripos($var, "power")) {
                        $newarch = "ppc";
                    } elseif (false !== stripos($var, "mips") && false !== stripos($var, "64")) {
                        $newarch = "mips64";
                    } elseif (false !== stripos($var, "mips")) {
                        $newarch = "mips";
                    } elseif (false !== stripos($var, "sparc") && false !== stripos($var, "64")) {
                        $newarch = "sparc64";
                    } elseif (false !== stripos($var, "sparc")) {
                        $newarch = "sparc";
                    } elseif (false !== stripos($var, "sun")) {
                        $newarch = "sparc";
                    } elseif (false !== stripos($var, "risc") && false !== stripos($var, "64")) {
                        $newarch = "risc64";
                    } elseif (false !== stripos($var, "risc")) {
                        $newarch = "risc";
                    } elseif (false !== stripos($var, "alpha") && false !== stripos($var, "64")) {
                        $newarch = "alpha64";
                    } elseif (false !== stripos($var, "alpha")) {
                        $newarch = "alpha";
                    } else {
                        $newarch = "unknown";
                        $delete = true;
                    }


                    if ($newarch != "") {
                        $obj = $em->getRepository('SywFrontMainBundle:Architectures')->findOneBy(array('name' => $newarch));
                        if (false === isset($obj) || false === is_object($obj) || $obj == null) {
                            $newarchitecture = new Architectures();
                            $newarchitecture->setName($newarch);
                            $newarchitecture->setMachinesNum(0);
                            $em->persist($newarchitecture);
                        } else {
                            $newarchitecture = $obj;
                        }
                        $delete = true;
                    }

                    if ($delete === true) {
                        $arch->setName('XXX__'.$arch->getName().'__WILL_GET_DELETED_SOON');
                    }


                    #
                    #
                    #
                    #
                }
                $em->flush();
                if (true === isset($newarchitecture) && true === is_object($newarchitecture) && $newarchitecture != null) {
                    foreach ($machines as $machine) {
                        $machine->setArchitecture($newarchitecture);
                    }
                }
                $em->flush();

                if (true === isset($obj) && true === is_object($obj) && $obj != null) {
                    $obj->setMachinesNum(sizeof($obj->getMachines()));
                }
                if (true === isset($newarchitecture) && true === is_object($newarchitecture) && $newarchitecture != null) {
                    $newarchitecture->setMachinesNum(sizeof($newarchitecture->getMachines()));
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
            @exec("php app/console syw:correct:architectures start >>".$importlogfile.".log 2>&1 3>&1 4>&1 &");
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
