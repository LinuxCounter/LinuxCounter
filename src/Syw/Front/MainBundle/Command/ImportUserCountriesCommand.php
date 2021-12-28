<?php

namespace Syw\Front\MainBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Model\UserInterface;
use Syw\Front\MainBundle\Entity\UserProfile;

/**
 * Class ImportUserCountriesCommand
 *
 * @category Command
 * @package  SywFrontMainBundle
 * @author   Christin Löhner <alex.loehner@linux.com>
 * @license  GPL v3
 * @link     https://github.com/christinloehner/linuxcounter.new
 */
class ImportUserCountriesCommand extends ContainerAwareCommand
{

    public $container;

    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('syw:import:usercountries')
            ->setDescription('Imports data from lico into licotest')
            ->setHelp(<<<EOT
The <info>syw:import:usercountries</info> imports stuff from lico into licotest

EOT
            );
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $lico       = $this->getContainer()->get('doctrine.dbal.lico_connection');
        $licotest   = $this->getContainer()->get('doctrine')->getManager();
        $licotestdb = $this->getContainer()->get('doctrine.dbal.default_connection');

        $importlogfile = "import-syw.import.usercountries";

        gc_collect_cycles();

        if (true === file_exists($importlogfile.'.db')) {
            $data = file_get_contents($importlogfile.'.db');
            $cid = intval(trim($data));
        } else {
            $cid = 159;
        }

        $country = $licotest->getRepository('SywFrontMainBundle:Countries')->findOneBy(array('id' => $cid));
        if (true === isset($country) && true === is_object($country)) {
            $country->setUsersNum(0);
            $licotest->persist($country);
            $licotest->flush();
            $code = strtoupper($country->getCode());
            echo "> " . $cid . ", " . $code . ", " . $country->getName() . " \n";
            $rows = $lico->fetchAll("SELECT p.f_key AS id FROM persons p WHERE UPPER(country) = '" . $code . "'");
            echo "> " . count($rows) . " users found... \n";
            $c = 0;
            foreach ($rows as $row) {
                $user = null;
                unset($user);
                $user = $licotest->getRepository('SywFrontMainBundle:User')->findOneBy(array("id" => $row['id']));
                if (true === isset($user) && true === is_object($user)) {
                    $profile = null;
                    unset($profile);
                    $profile = $user->getProfile();
                    if (true === isset($profile) && true === is_object($profile)) {
                        echo ".";
                        $c++;
                        $country->setUsersNum($country->getUsersNum() + 1);
                        $licotest->persist($country);
                        $profile->setCountry($country);
                        $licotest->persist($profile);
                    }
                }
                gc_collect_cycles();
            }
            $licotest->flush();
            echo "\n";
            $licotest->flush();

            $licotest->clear();
        } else {
            exit(0);
        }
        $licotest->close();
        $licotestdb->close();
        $lico->close();

        $licotest = null;
        unset($licotest);
        $licotestdb = null;
        unset($licotestdb);
        $lico = null;
        unset($lico);

        gc_collect_cycles();
        $fp = file_put_contents($importlogfile . '.db', $cid+1);
        @exec("php app/console syw:import:usercountries >>".$importlogfile.".log 2>&1 3>&1 4>&1 &");
        exit(0);
    }

    /**
     * @see Command
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {

    }
}
