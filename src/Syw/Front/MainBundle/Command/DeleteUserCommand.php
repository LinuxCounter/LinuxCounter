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
class DeleteUserCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('syw:user:delete')
            ->setDescription('Delete a user.')
            ->setDefinition(array(
                new InputArgument('username', InputArgument::REQUIRED, 'The username')
            ))
            ->setHelp(<<<EOT
The <info>fos:user:delete</info> command deletes a user:

  <info>php app/console fos:user:delete matthieu</info>

EOT
            );
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $licotest   = $this->getContainer()->get('doctrine')->getManager();
        $licotestdb = $this->getContainer()->get('doctrine.dbal.default_connection');

        $username   = $input->getArgument('username');
        $user = $em->getRepository('SywFrontMainBundle:User')->findOneBy(array("username" => $username));

        $machines   = $licotest->getRepository('SywFrontMainBundle:Machines')
            ->findBy(array('user' => $user));

        foreach ($machines as $machine) {
            unset($obj);
            $obj = $machine->getClass();
            if (true === isset($obj) && is_object($obj)) {
                $obj->setMachinesNum($obj->getMachinesNum() - 1);
                $em->persist($obj);
            }
            $machine->setClass(null);
            unset($obj);
            $obj = $machine->getCpu();
            if (true === isset($obj) && is_object($obj)) {
                $obj->setMachinesNum($obj->getMachinesNum() - 1);
                $em->persist($obj);
            }
            $machine->setCpu(null);
            unset($obj);
            $obj = $machine->getKernel();
            if (true === isset($obj) && is_object($obj)) {
                $obj->setMachinesNum($obj->getMachinesNum() - 1);
                $em->persist($obj);
            }
            $machine->setKernel(null);
            unset($obj);
            $obj = $machine->getArchitecture();
            if (true === isset($obj) && is_object($obj)) {
                $obj->setMachinesNum($obj->getMachinesNum() - 1);
                $em->persist($obj);
            }
            $machine->setArchitecture(null);
            unset($obj);
            $obj = $machine->getCountry();
            if (true === isset($obj) && is_object($obj)) {
                $obj->setMachinesNum($obj->getMachinesNum() - 1);
                $em->persist($obj);
            }
            $machine->setCountry(null);
            unset($obj);
            $obj = $machine->getDistribution();
            if (true === isset($obj) && is_object($obj)) {
                $obj->setMachinesNum($obj->getMachinesNum() - 1);
                $em->persist($obj);
            }
            $machine->setDistribution(null);
            unset($obj);
            $obj = $machine->getPurpose();
            if (true === isset($obj) && is_object($obj)) {
                $obj->setMachinesNum($obj->getMachinesNum() - 1);
                $em->persist($obj);
            }
            $machine->setPurpose(null);
            $em->persist($machine);
            $em->flush();
            $em->remove($machine);
            $em->flush();
        }
        $profile = $user->getProfile();
        if (true === isset($profile) && true === is_object($profile)) {
            $city = $profile->getCity();
            if (true === isset($city) && true === is_object($city)) {
                $city->setUserNum($city->getUserNum() - 1);
                $country = $em->getRepository('SywFrontMainBundle:Countries')->findOneBy(array('code' => strtolower($city->getIsoCountryCode())));
                if (true === isset($country) && true === is_object($country)) {
                    $country->setUsersNum($country->getUsersNum() - 1);
                    $em->persist($country);
                }
            }
        }
        $activities = $em->getRepository('SywFrontMainBundle:Activity')->findBy(array('user' => $user));
        foreach ($activities as $activity) {
            $licotestdb->exec('DELETE FROM activity WHERE `id`=\''.$activity->getId().'\'');
        }

        $licotestdb->exec('DELETE FROM fos_user WHERE `id`=\''.$user->getId().'\'');
        // $manipulator = $this->getContainer()->get('syw.util.user_manipulator');
        // $manipulator->delete($username);

        $output->writeln(sprintf('Deleted user <comment>%s</comment>', $username));
    }

    /**
     * @see Command
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        if (!$input->getArgument('username')) {
            $username = $this->getHelper('dialog')->askAndValidate(
                $output,
                'Please choose a username:',
                function ($username) {
                    if (empty($username)) {
                        throw new \Exception('Username can not be empty');
                    }

                    return $username;
                }
            );
            $input->setArgument('username', $username);
        }
    }
}
