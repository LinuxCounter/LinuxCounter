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
class CorrectUserProfilesCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('syw:correct:userprofiles')
            ->setDescription('Re-adds the profile id to the user table')
            ->setDefinition(array(
                new InputArgument('item', InputArgument::REQUIRED, 'the item to import')
            ))
            ->setHelp(<<<EOT
The <info>syw:correct:userprofiles</info> command Re-adds the profile id to the user table.

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
        $db = $this->getContainer()->get('doctrine')->getManager();

        $importlogfile = "import.correct.userprofiles";


        if ($item == "start") {
            @exec("php app/console syw:correct:userprofiles continue >>".$importlogfile.".log 2>&1 3>&1 4>&1 &");
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
                $nums     = $licotestdb->fetchAll('SELECT COUNT(id) AS num FROM fos_user');
                $numusers = $nums[0]['num'];
                $start    = 0; // $numusers;
                $counter  = 0;
            }
            $itemsperloop = 200;

            $z = 0;
            $a = $start;

            unset($rows);
            $users = $db->getRepository('SywFrontMainBundle:User')->findBy(array(), array('id' => 'ASC'), $itemsperloop, $a);
            foreach ($users as $user) {
                $counter++;
                $profile = $db->getRepository('SywFrontMainBundle:UserProfile')->findOneBy(array('user' => $user));
                if (true === isset($profile) && true === is_object($profile)) {
                    $id = $profile->getId();
                    $user->setProfile($profile);
                    $licotest->persist($user);
                    $licotest->flush();
                    echo ".";
                    gc_collect_cycles();
                }
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
            @exec("php app/console syw:correct:userprofiles start >>".$importlogfile.".log 2>&1 3>&1 4>&1 &");
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
