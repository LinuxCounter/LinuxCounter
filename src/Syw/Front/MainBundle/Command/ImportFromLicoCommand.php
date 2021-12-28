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
 * Class ImportFromLicoCommand
 *
 * @category Command
 * @package  SywFrontMainBundle
 * @author   Christin Löhner <alex.loehner@linux.com>
 * @license  GPL v3
 * @link     https://github.com/christinloehner/linuxcounter.new
 */
class ImportFromLicoCommand extends ContainerAwareCommand
{

    public $container;

    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('syw:import:lico')
            ->setDescription('Imports data from lico into licotest')
            ->setDefinition(array(
                new InputArgument('item', InputArgument::REQUIRED, 'the item to import')
            ))
            ->setHelp(<<<EOT
The <info>syw:import:lico</info> imports stuff from lico into licotest:

  <info>php app/console syw:import:lico machines</info>

This will export the data about machines from lico and import this to the tables in licotest

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

        if ($item == "processors" || $item == "all") {
            $rows = $lico->fetchAll('SELECT p.name, p.herz FROM processors p ORDER BY p.name ASC');
            foreach ($rows as $row) {
                $name  = $row['name'];
                $hertz = $row['herz'];
                $obj   = new \Syw\Front\MainBundle\Entity\Cpus();
                $obj->setName($name);
                $obj->setHertz($hertz);
                $licotest->persist($obj);
                $licotest->flush();
            }
        }

        if ($item == "countries" || $item == "all") {
            $rows = $lico->fetchAll('SELECT p.name, p.code, p.population FROM places p ORDER BY p.name ASC');
            foreach ($rows as $row) {
                $name       = $row['name'];
                $code       = $row['code'];
                $population = $row['population'];
                $obj        = new \Syw\Front\MainBundle\Entity\Countries();
                $obj->setName($name);
                $obj->setCode(strtolower($code));
                $obj->setPopulation($population);
                $licotest->persist($obj);
                $licotest->flush();
            }
        }

        if ($item == "distributions" || $item == "all") {
            $rows = $lico->fetchAll('SELECT DISTINCT m.distribution AS name FROM machines m ORDER BY m.distribution');
            foreach ($rows as $row) {
                $name = $row['name'];
                $obj  = new \Syw\Front\MainBundle\Entity\Distributions();
                $obj->setName($name);
                $licotest->persist($obj);
                $licotest->flush();
            }
        }

        if ($item == "architectures" || $item == "all") {
            $rows = $lico->fetchAll('SELECT DISTINCT m.arch AS name FROM machines m ORDER BY m.arch');
            foreach ($rows as $row) {
                $name = $row['name'];
                $obj  = new \Syw\Front\MainBundle\Entity\Architectures();
                $obj->setName($name);
                $licotest->persist($obj);
                $licotest->flush();
            }
        }

        if ($item == "kernels" || $item == "all") {
            $rows = $lico->fetchAll('SELECT DISTINCT m.kernel AS name FROM machines m ORDER BY m.kernel');
            foreach ($rows as $row) {
                $name = $row['name'];
                $obj  = new \Syw\Front\MainBundle\Entity\Kernels();
                $obj->setName($name);
                $licotest->persist($obj);
                $licotest->flush();
            }
        }

        if ($item == "classes" || $item == "all") {
            $rows = $lico->fetchAll('SELECT DISTINCT m.sysclass AS name FROM machines m ORDER BY m.sysclass');
            foreach ($rows as $row) {
                $name = $row['name'];
                $obj  = new \Syw\Front\MainBundle\Entity\Classes();
                $obj->setName($name);
                $licotest->persist($obj);
                $licotest->flush();
            }
        }

        if ($item == "purposes" || $item == "all") {
            $rows = $lico->fetchAll('SELECT DISTINCT m.purpose AS name FROM machines m ORDER BY m.purpose');
            foreach ($rows as $row) {
                $line = $row['name'];
                if (strpos($line, ",") !== false) {
                    $names = explode(",", trim($line));
                    foreach ($names as $name) {
                        $exists = false;
                        $exists = $licotest->getRepository('SywFrontMainBundle:Purposes')->findOneBy(array("name" => $name));
                        if (!$exists) {
                            $obj = new \Syw\Front\MainBundle\Entity\Purposes();
                            $obj->setName($name);
                            $licotest->persist($obj);
                            $licotest->flush();
                        }
                    }
                } else {
                    $exists = false;
                    $exists = $licotest->getRepository('SywFrontMainBundle:Purposes')->findOneBy(array("name" => $line));
                    if (!$exists) {
                        $obj = new \Syw\Front\MainBundle\Entity\Purposes();
                        $obj->setName($line);
                        $licotest->persist($obj);
                        $licotest->flush();
                    }
                }
            }
        }

        if ($item == "users") {
            @exec("php app/console syw:import:lico usersbg >>import.log 2>&1 3>&1 4>&1 &");
            exit(0);
        }

        if ($item == "usersbg") {
            gc_collect_cycles();

            if (true === file_exists('import.db')) {
                $fp   = fopen('import.db', "r");
                $data = fread($fp, 1024);
                fclose($fp);
                $fp = null;
                unset($fp);
                $dataar  = explode(" ", trim($data));
                $start   = intval(trim($dataar[0]));
                $counter = intval(trim($dataar[1]));
            } else {
                $nums     = $lico->fetchAll('SELECT COUNT(f_key) AS num FROM users');
                $numusers = $nums[0]['num'];
                $start    = 0; // $numusers;
                $counter  = 0;
            }
            $itemsperloop = 200;

            $z = 0;
            $a = $start;

            unset($rows);
            $rows = $lico->fetchAll('SELECT * FROM users ORDER BY f_key LIMIT ' . $a . ',' . $itemsperloop . '');
            foreach ($rows as $row) {
                $counter++;
                gc_collect_cycles();
                $sendmail = false;
                $id       = $row['f_key'];
                $email    = $row['email'];

                $userex = null;
                unset($userex);
                $userex = $licotest->getRepository('SywFrontMainBundle:User')->findOneBy(array("id" => $id));
                if (true === isset($userex) && true === is_object($userex)) {
                    continue;
                }
                $userex = null;
                unset($userex);
                $userex = $licotest->getRepository('SywFrontMainBundle:User')->findOneBy(array("email" => $email));
                if (true === isset($userex) && true === is_object($userex)) {
                    continue;
                }

                if (preg_match("`^([a-z]{5,}[0-9]{2,}[\+]+[a-z0-9]{3,}@gmail\.com)$`i", strtolower($email))) {
                    continue;
                }

                if (preg_match("`^(.*[a-z]+\.[a-z]+\.[a-z0-9]+\.[a-z0-9]+.*@gmail\.com)$`i", strtolower($email))) {
                    continue;
                }

                $lastLogin = $row['logintime'];
                $username  = $id;
                $password  = mt_rand(1000000000, 9999999999);

                $sendmail = true;

                $licotest   = $this->getContainer()->get('doctrine')->getManager();
                $licotestdb = $this->getContainer()->get('doctrine.dbal.default_connection');

                $licotestdb->prepare('SET autocommit=0;')->execute();

                if ($sendmail === true) {
                    $userManager = $this->getContainer()->get('fos_user.user_manager');
                    $user        = $userManager->createUser();
                    $user->setId($row['f_key']);
                    $user->setEnabled(true);
                    $user->setUsername($username);
                    $user->setEmail($email);
                    $user->setPlainPassword($password);
                    $user->setLastLogin(new \DateTime($lastLogin));
                    $user->setSuperAdmin(false);
                    $user->setLocale('en');
                    $userManager->updateUser($user);

                    $userid = $user->getId();
                    $id     = $userid;
                    // $licotestdb->query('UPDATE fos_user SET id=' . $id . ' WHERE id=\'' . $userid . '\'');

                    // unset($user);
                    // $user = $licotest->getRepository('SywFrontMainBundle:User')->findOneBy(array("id" => $id));

                    $userProfile = new UserProfile();
                    $userProfile->setUser($user);
                    $userProfile->setCreatedAt(new \DateTime($row['f_ctime']));
                    $userProfile->setModifiedAt(new \DateTime($row['f_mtime']));
                    $licotest->persist($userProfile);
                    $licotest->flush();

                    $mailpref = new \Syw\Front\MainBundle\Entity\Mail();
                    $mailpref->setUser($user);
                    $mailpref->setNewsletterAllowed(1);
                    $mailpref->setAdminAllowed(1);
                    $mailpref->setOtherUsersAllowed(1);
                    $mailpref->setModifiedAt(new \DateTime());
                    $licotest->persist($mailpref);
                    $licotest->flush();

                    $user->setProfile($userProfile);
                    $user->setMailPref($mailpref);
                    $userManager->updateUser($user);
                    $licotest->flush();

                    $userManager = null;
                    unset($userManager);
                    $userProfile = null;
                    unset($userProfile);

                    $privacy = new \Syw\Front\MainBundle\Entity\Privacy();
                    $privacy->setUser($user);
                    $privacy->setSecretProfile(0);
                    $privacy->setSecretCounterData(0);
                    $privacy->setSecretMachines(0);
                    $privacy->setSecretContactInfo(0);
                    $privacy->setSecretSocialInfo(0);
                    $privacy->setShowRealName(0);
                    $privacy->setShowEmail(0);
                    $privacy->setShowLocation(1);
                    $privacy->setShowHostnames(1);
                    $privacy->setShowKernel(1);
                    $privacy->setShowDistribution(1);
                    $privacy->setShowVersions(1);
                    $licotest->persist($privacy);
                    $licotest->flush();

                    $mrows = $lico->fetchAll('SELECT * FROM machines WHERE owner = \'' . $userid . '\' ORDER BY f_key');
                    foreach ($mrows as $mrow) {
                        gc_collect_cycles();
                        $userid    = $mrow['owner'];
                        $machineid = $mrow['f_key'];

                        $machine = new \Syw\Front\MainBundle\Entity\Machines();
                        $machine->setUser($user);
                        $machine->setId($machineid);

                        if (true === isset($mrow['update_key']) && trim($mrow['update_key']) != "") {
                            $machine->setUpdateKey(trim($mrow['update_key']));
                        }
                        if (true === isset($mrow['name']) && trim($mrow['name']) != "") {
                            $machine->setHostname(trim($mrow['name']));
                        }
                        if (true === isset($mrow['cpunum']) && trim($mrow['cpunum']) != "") {
                            $machine->setCores(trim($mrow['cpunum']));
                        }
                        if (true === isset($mrow['cpuflags']) && trim($mrow['cpuflags']) != "") {
                            $machine->setFlags(trim($mrow['cpuflags']));
                        }
                        if (true === isset($mrow['accounts']) && trim($mrow['accounts']) != "") {
                            $machine->setAccounts(trim($mrow['accounts']));
                        }
                        if (true === isset($mrow['disk']) && trim($mrow['disk']) != "") {
                            $machine->setDiskspace(trim($mrow['disk']));
                        }
                        if (true === isset($mrow['diskfree']) && trim($mrow['diskfree']) != "") {
                            $machine->setDiskspaceFree(trim($mrow['diskfree']));
                        }
                        if (true === isset($mrow['memory']) && trim($mrow['memory']) != "") {
                            $machine->setMemory(trim($mrow['memory']));
                        }
                        if (true === isset($mrow['memfree']) && trim($mrow['memfree']) != "") {
                            $machine->setMemoryFree(trim($mrow['memfree']));
                        }
                        if (true === isset($mrow['swap']) && trim($mrow['swap']) != "") {
                            $machine->setSwap(trim($mrow['swap']));
                        }
                        if (true === isset($mrow['swapfree']) && trim($mrow['swapfree']) != "") {
                            $machine->setSwapFree(trim($mrow['swapfree']));
                        }
                        if (true === isset($mrow['distversion']) && trim($mrow['distversion']) != "") {
                            $machine->setDistversion(trim($mrow['distversion']));
                        }
                        if (true === isset($mrow['mailer']) && trim($mrow['mailer']) != "") {
                            $machine->setMailer(trim($mrow['mailer']));
                        }
                        if (true === isset($mrow['network']) && trim($mrow['network']) != "") {
                            $machine->setNetwork(trim($mrow['network']));
                        }
                        if (true === isset($mrow['online']) && trim($mrow['online']) != "") {
                            if (trim($mrow['online']) == "online") {
                                $machine->setOnline(1);
                            } else {
                                $machine->setOnline(0);
                            }
                        }
                        if (true === isset($mrow['uptime']) && trim($mrow['uptime']) != "") {
                            $machine->setUptime(trim($mrow['uptime']));
                        }
                        if (true === isset($mrow['load']) && trim($mrow['load']) != "") {
                            $machine->setLoadAvg(trim($mrow['load']));
                        }
                        if (true === isset($mrow['f_ctime']) && trim($mrow['f_ctime']) != "") {
                            $machine->setCreatedAt(new \DateTime(trim($mrow['f_ctime'])));
                        }
                        if (true === isset($mrow['f_mtime']) && trim($mrow['f_mtime']) != "") {
                            $machine->setModifiedAt(new \DateTime(trim($mrow['f_mtime'])));
                        }
                        unset($obj);
                        if (true === isset($mrow['distribution']) && trim($mrow['distribution']) != "") {
                            $obj = $licotest->getRepository('SywFrontMainBundle:Distributions')->findOneBy(array("name" => trim($mrow['distribution'])));
                            if (true === isset($obj) && true === is_object($obj)) {
                                $obj->setMachinesNum($obj->getMachinesNum() + 1);
                                $licotest->persist($obj);
                                $machine->setDistribution($obj);
                            }
                        }
                        unset($obj);
                        if (true === isset($mrow['kernel']) && trim($mrow['kernel']) != "") {
                            $obj = $licotest->getRepository('SywFrontMainBundle:Kernels')->findOneBy(array("name" => trim($mrow['kernel'])));
                            if (true === isset($obj) && true === is_object($obj)) {
                                $obj->setMachinesNum($obj->getMachinesNum() + 1);
                                $licotest->persist($obj);
                                $machine->setKernel($obj);
                            }
                        }
                        unset($obj);
                        if (true === isset($mrow['cpu']) && trim($mrow['cpu']) != "" && intval($mrow['cpu']) >= 1) {
                            unset($line);
                            $line = $lico->fetchAll('SELECT name, herz FROM processors WHERE f_key=\'' . trim($mrow['cpu']) . '\'');
                            if (true === isset($line) && true === is_array($line) && true === isset($line[0]) && true === is_array($line[0]) && true === isset($line[0]['name']) && true === isset($line[0]['herz'])) {
                                unset($obj);
                                $obj = $licotest->getRepository('SywFrontMainBundle:Cpus')->findOneBy(array(
                                    "name" => trim($line[0]['name']),
                                    "hertz" => trim($line[0]['herz'])
                                ));
                                if (true === isset($obj) && true === is_object($obj)) {
                                    $obj->setMachinesNum($obj->getMachinesNum() + 1);
                                    $licotest->persist($obj);
                                    $machine->setCpu($obj);
                                }
                            }
                        }
                        unset($obj);
                        if (true === isset($mrow['country']) && trim($mrow['country']) != "") {
                            $obj = $licotest->getRepository('SywFrontMainBundle:Countries')->findOneBy(array("code" => strtolower(trim($mrow['country']))));
                            if (true === isset($obj) && true === is_object($obj)) {
                                $obj->setMachinesNum($obj->getMachinesNum() + 1);
                                $licotest->persist($obj);
                                $machine->setCountry($obj);
                            }
                        }
                        unset($obj);
                        if (true === isset($mrow['arch']) && trim($mrow['arch']) != "") {
                            $obj = $licotest->getRepository('SywFrontMainBundle:Architectures')->findOneBy(array("name" => trim($mrow['arch'])));
                            if (true === isset($obj) && true === is_object($obj)) {
                                $obj->setMachinesNum($obj->getMachinesNum() + 1);
                                $licotest->persist($obj);
                                $machine->setArchitecture($obj);
                            }
                        }
                        unset($obj);
                        if (true === isset($mrow['sysclass']) && trim($mrow['sysclass']) != "") {
                            $obj = $licotest->getRepository('SywFrontMainBundle:Classes')->findOneBy(array("name" => trim($mrow['sysclass'])));
                            if (true === isset($obj) && true === is_object($obj)) {
                                $obj->setMachinesNum($obj->getMachinesNum() + 1);
                                $licotest->persist($obj);
                                $machine->setClass($obj);
                            }
                        }
                        unset($obj);
                        $licotest->persist($machine);
                        $licotest->flush();

                        $mid = $machine->getId();
                    }


                    $user = null;
                    unset($user);
                    $privacy = null;
                    unset($privacy);

                }

                $licotestdb->prepare('COMMIT;')->execute();
                $licotest->clear();

                gc_collect_cycles();

                $user = null;
                unset($user);
                $userProfile = null;
                unset($userProfile);
                $privacy = null;
                unset($privacy);
                $userid = null;
                unset($userid);
                $userManager = null;
                unset($userManager);

                $z++;

                // $mypid = getmypid();
                // $files = @exec('lsof -p '.$mypid.' | wc -l');
                // file_put_contents("import.log", ">>> ".$counter." | ".$z." | ".$id." |   open files: ".$files." | Memory info: ".number_format(round((memory_get_usage()/1000), 2))." Mb   (".number_format(round((memory_get_peak_usage()/1000), 2))." Mb) \n", FILE_APPEND);
                file_put_contents(
                    "import.log",
                    ">>> " . $counter . " | " . $z . " | " . $id . " | " . $row['f_key'] . " \n",
                    FILE_APPEND
                );

                gc_collect_cycles();
            }
            file_put_contents('import.db', ($a + $itemsperloop) . " " . $counter);


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

            gc_collect_cycles();
            @exec("php app/console syw:import:lico users >>import.log 2>&1 3>&1 4>&1 &");
            exit(0);
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
