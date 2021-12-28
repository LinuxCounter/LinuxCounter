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
class ModifyUserCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('syw:user:modify')
            ->setDescription('Delete a user.')
            ->setDefinition(array(
                new InputArgument('number', InputArgument::REQUIRED, 'A counter number'),
                new InputArgument('action', InputArgument::REQUIRED, 'Either "search" or a setFunction name from User entity.'),
                new InputArgument('value', InputArgument::OPTIONAL, 'Only when action is a setFunction name, then this is the value for the field to set')
            ))
            ->setHelp(<<<EOT
The <info>syw:user:modify</info> command modifies a user:

  <info>php app/console syw:user:modify {userid} search</info>
  <info>php app/console syw:user:modify {userid} setEmail foo@bar.com</info>

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

        $userid   = $input->getArgument('number');
        $action   = $input->getArgument('action');

        if ($action == "search") {
            $user = $em->getRepository('SywFrontMainBundle:User')->findOneBy(array("id" => $userid));
            if (true === isset($user) && is_object($user)) {
                $output->writeln(sprintf('User with ID <comment>%s</comment> found.', $userid));
                $output->writeln(sprintf('Email          : <comment>%s</comment>', $user->getEmail()));
                $output->writeln(sprintf('Username       : <comment>%s</comment>', $user->getUsername()));
                $output->writeln(sprintf('Last Login     : <comment>%s</comment>', $user->getLastLogin()->format('Y-m-d H:i:s')));
            }
        } else if ($action == "setEmail") {
            $user = $em->getRepository('SywFrontMainBundle:User')->findOneBy(array("id" => $userid));
            if (true === isset($user) && is_object($user)) {
                $value   = $input->getArgument('value');
                $user->$action($value);
                $em->persist($user);
                $em->flush();
                $getaction = preg_replace("`^s(.*)`", "g$1", $action);
                $output->writeln(sprintf('User with ID <comment>%s</comment> successfully modified! The new value is <comment>%s</comment>', $userid, $user->$getaction()));
                echo "\n";
                $array = array();
                exec('php app/console --no-ansi syw:user:modify '.$userid.' search', $array);
                $output = "";
                foreach ($array as $key => $val) {
                    $output .= "    ".$val."\n";
                }
                echo $output;
                $empfaenger = "$value";
                $betreff = 'Your Email for your LinuxCounter account has changed';
                $nachricht = "
Hello!

The email address of your Linux Counter account has changed.
Your new account data:

".$output."

You now may use the password reset form to get a new password for your account:
    https://www.linuxcounter.net/resetting/request

Best regards
The Linux Counter Project

";
                $header = 'From: info@linuxcounter.net' . "\r\n" .
                    'Reply-To: info@linuxcounter.net' . "\r\n" .
                    'Bcc: info@linuxcounter.net' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();

                mail("$empfaenger", "$betreff", "$nachricht", "$header");
                echo "\nEmail sent to user.\n";

            } else {
                $output->writeln(sprintf('User with ID <comment>%s</comment> NOT found!', $userid));
            }
        }
    }

    /**
     * @see Command
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        if (!$input->getArgument('number')) {
            $number = $this->getHelper('dialog')->askAndValidate(
                $output,
                'Please set a number:',
                function ($number) {
                    if (empty($number)) {
                        throw new \Exception('Number can not be empty');
                    }

                    return $number;
                }
            );
            $input->setArgument('number', $number);
        }
        if (!$input->getArgument('action')) {
            $action = $this->getHelper('dialog')->askAndValidate(
                $output,
                'Please choose a action:',
                function ($action) {
                    if (empty($action)) {
                        throw new \Exception('action can not be empty');
                    }

                    return $action;
                }
            );
            $input->setArgument('action', $action);
        }
    }
}