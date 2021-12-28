<?php

namespace Syw\Front\MainBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use FOS\UserBundle\Model\User;
use Syw\Front\MainBundle\Entity\StatsMachines;

/**
 *
 */
class SynchronizeLocationUserCountsCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('syw:synchronize:usercounts')
            ->setDescription('Synchronizes the user counts in the cities and countries tables')
            ->setDefinition(array(
                new InputArgument('item', InputArgument::REQUIRED, 'the item to import')
            ))
            ->setHelp(<<<EOT
The <info>syw:synchronize:usercounts</info> command Synchronizes the user counts in the cities and countries tables.

EOT
            );
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $item = $input->getArgument('item');

        $importlogfile = "import-syw.synchronize.usercounts";

        $licotestdb = $this->getContainer()->get('doctrine.dbal.default_connection');
        $db = $this->getContainer()->get('doctrine')->getManager();

        if ($item == "cities") {
            @exec("php app/console syw:synchronize:usercounts citiesbg >>".$importlogfile.".log 2>&1 3>&1 4>&1 &");
            exit(0);
        }


        if ($item == "citiesbg") {
            gc_collect_cycles();

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
                $nums     = $licotestdb->fetchAll('SELECT COUNT(id) AS num FROM cities');
                $numusers = $nums[0]['num'];
                $start    = 0; // $numusers;
                $counter  = 0;
            }
            $itemsperloop = 200;

            $z = 0;
            $a = $start;
            $c = 0;
            $cities = $db->getRepository('SywFrontMainBundle:Cities')->findBy(array(), array('id' => 'ASC'), $itemsperloop, $a);
            foreach ($cities as $city) {
                $counter++;
                gc_collect_cycles();

                $userProfiles = null;
                unset($userProfiles);
                $num = 0;
                $userProfiles = $city->getUsers();
                $num = sizeof($userProfiles);
                $city->setUserNum(intval($num));
                $db->persist($city);
                if ($c == 100) {
                    echo ".";
                    $c = 0;
                }

                gc_collect_cycles();

                $userProfiles = null;
                unset($userProfiles);

                $z++;

                file_put_contents(
                    $importlogfile.".log",
                    ">>> " . $counter . " | " . $z . " | " . $city->getId() . " | " . $num . " \n",
                    FILE_APPEND
                );

                gc_collect_cycles();
            }
            file_put_contents($importlogfile.'.db', ($a + $itemsperloop) . " " . $counter);

            $db->flush();
            $licotestdb->close();
            gc_collect_cycles();
            @exec("php app/console syw:synchronize:usercounts cities >>".$importlogfile.".log 2>&1 3>&1 4>&1 &");
            exit(0);
        }


        if ($item == "countries") {
            $countries = $db->getRepository('SywFrontMainBundle:Countries')->findAll();
            foreach ($countries as $country) {
                $userProfiles = null;
                unset($userProfiles);
                $userProfiles = $country->getUsers();
                $country->setUsersNum(sizeof($userProfiles));
                $db->persist($country);
                echo ".";
            }
            $db->flush();
            echo "\n";
            $output->writeln(sprintf('Usernumbers synchronized', ''));
        }
    }

    /**
     * @see Command
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        if (!$input->getArgument('item')) {
            $item = $this->getHelper('dialog')->askAndValidate(
                $output,
                'Please enter a item:',
                function ($item) {
                    if (empty($item)) {
                        throw new \Exception('item can not be empty');
                    }

                    return $item;
                }
            );
            $input->setArgument('item', $item);
        }
    }
}
