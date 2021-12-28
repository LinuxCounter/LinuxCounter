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
class CreateUserCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('syw:user:create')
            ->setDescription('Create a user.')
            ->setDefinition(array(
                new InputArgument('username', InputArgument::REQUIRED, 'The username'),
                new InputArgument('email', InputArgument::REQUIRED, 'The email'),
                new InputArgument('password', InputArgument::REQUIRED, 'The password'),
                new InputArgument('locale', InputArgument::REQUIRED, 'The locale'),
                new InputOption('super-admin', null, InputOption::VALUE_NONE, 'Set the user as super admin'),
                new InputOption('inactive', null, InputOption::VALUE_NONE, 'Set the user as inactive'),
            ))
            ->setHelp(<<<EOT
The <info>fos:user:create</info> command creates a user:

  <info>php app/console fos:user:create matthieu</info>

This interactive shell will ask you for an email, a password and the locale.

You can alternatively specify the email, password and locale as the second, third and fourth arguments:

  <info>php app/console fos:user:create matthieu matthieu@example.com mypassword de</info>

You can create a super admin via the super-admin flag:

  <info>php app/console fos:user:create admin --super-admin</info>

You can create an inactive user (will not be able to log in):

  <info>php app/console fos:user:create thibault --inactive</info>

EOT
            );
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $db = $this->getContainer()->get('doctrine')->getManager();

        $username   = $input->getArgument('username');
        $email      = $input->getArgument('email');
        $password   = $input->getArgument('password');
        $locale     = $input->getArgument('locale');
        $inactive   = $input->getOption('inactive');
        $superadmin = $input->getOption('super-admin');

        $manipulator = $this->getContainer()->get('syw.util.user_manipulator');
        $manipulator->create($username, $password, $email, $locale, !$inactive, $superadmin);

        $licotestdb = $this->getContainer()->get('doctrine.dbal.default_connection');
        $licotestdb->query("UPDATE fos_user SET id='".$username."' WHERE username='".$username."'");
        $db->flush();

        $user = $db->getRepository('SywFrontMainBundle:User')->findOneBy(array("username" => $username, "email" => $email));

        $userProfile = new \Syw\Front\MainBundle\Entity\UserProfile();
        $userProfile->setUser($user);
        $userProfile->setCreatedAt(new \DateTime());
        $db->persist($userProfile);
        $db->flush();

        $mailpref = new \Syw\Front\MainBundle\Entity\Mail();
        $mailpref->setUser($user);
        $mailpref->setNewsletterAllowed(1);
        $mailpref->setAdminAllowed(1);
        $mailpref->setOtherUsersAllowed(1);
        $mailpref->setModifiedAt(new \DateTime());
        $db->persist($mailpref);
        $db->flush();

        $user->setProfile($userProfile);
        $user->setMailPref($mailpref);
        $db->flush();

        $obj = new \Syw\Front\MainBundle\Entity\Privacy();
        $obj->setUser($user);
        $obj->setSecretProfile(0);
        $obj->setSecretCounterData(0);
        $obj->setSecretMachines(0);
        $obj->setSecretContactInfo(0);
        $obj->setSecretSocialInfo(0);
        $obj->setShowRealName(0);
        $obj->setShowEmail(0);
        $obj->setShowLocation(1);
        $obj->setShowHostnames(1);
        $obj->setShowKernel(1);
        $obj->setShowDistribution(1);
        $obj->setShowVersions(1);
        $db->persist($obj);
        $db->flush();

        $output->writeln(sprintf('Created user <comment>%s</comment>', $username));
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

        if (!$input->getArgument('email')) {
            $email = $this->getHelper('dialog')->askAndValidate(
                $output,
                'Please choose an email:',
                function ($email) {
                    if (empty($email)) {
                        throw new \Exception('Email can not be empty');
                    }

                    return $email;
                }
            );
            $input->setArgument('email', $email);
        }

        if (!$input->getArgument('password')) {
            $password = $this->getHelper('dialog')->askHiddenResponseAndValidate(
                $output,
                'Please choose a password:',
                function ($password) {
                    if (empty($password)) {
                        throw new \Exception('Password can not be empty');
                    }

                    return $password;
                }
            );
            $input->setArgument('password', $password);
        }

        if (!$input->getArgument('locale')) {
            $locale = $this->getHelper('dialog')->askAndValidate(
                $output,
                'Please choose a locale:',
                function ($locale) {
                    if (empty($locale)) {
                        throw new \Exception('Locale can not be empty');
                    }

                    return $locale;
                }
            );
            $input->setArgument('locale', $locale);
        }
    }
}
