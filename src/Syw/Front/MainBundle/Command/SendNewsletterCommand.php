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
use Syw\Front\MainBundle\Entity\User;
use Syw\Front\MainBundle\Entity\UserProfile;

/**
 * Class SendNewsletterEmail
 *
 * @category Command
 * @package  SywFrontMainBundle
 * @author   Christin Löhner <alex.loehner@linux.com>
 * @license  GPL v3
 * @link     https://github.com/christinloehner/linuxcounter.new
 */
class SendNewsletterCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('syw:send:newsletter')
            ->setDescription('Sends an email to all users with the text from file')
            ->setDefinition(array(
                new InputArgument('file', InputArgument::REQUIRED, 'the item to import')
            ))
            ->setHelp(<<<EOT
The <info>syw:send:newsletter</info> sends a newsletter

EOT
            );
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $file = $input->getArgument('file');




        // $output->writeln(sprintf('Mail sending disabled! Remove the exit in order to send the mail!'));
        // exit(0);




        $SUBJECT = "[LiCo] The Linux Counter Project is still alive and most popular than ever!";


        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////


        $mailbody = "";
        if (true === file_exists($file)) {
            $mailbody = file_get_contents($file);
            $mailbody = $mailbody."\r\n\r\n";
        }

        if ($mailbody == "") {
            $output->writeln(sprintf('Mailbody is empty! Mail not sent!'));
            exit(1);
        }
        if ($SUBJECT == "") {
            $output->writeln(sprintf('Subject is empty! Mail not sent!'));
            exit(1);
        }

        $db = $this->getContainer()->get('doctrine')->getManager();
        $userrepo = $db->getRepository('SywFrontMainBundle:User');
        $userprofilerepo = $db->getRepository('SywFrontMainBundle:UserProfile');

        $mails = $db->getRepository('SywFrontMainBundle:Mail')->findBy(array("newsletterAllowed" => 1));
        $numusers = count($mails);

        echo "# Emails to ".$numusers." users must be sent...\n";



        $start = 201;
        $itemsperloop = 2;
        $counter = 0;

        for ($a = $start; ($a+$itemsperloop)<$numusers; $a+=$itemsperloop) {
            unset($mails);
            $counter++;
            $mails   = $db->getRepository('SywFrontMainBundle:Mail')->findBy(
                array("newsletterAllowed" => 1),
                array(),
                $itemsperloop,
                $a
            );
            $mailer  = $this->getContainer()->get('mailer');
            $message = $mailer->createMessage()
                ->setSubject($SUBJECT)
                ->setFrom('info@linuxcounter.net')
                ->setTo('info@linuxcounter.net')
                ->setBody(
                    $mailbody,
                    'text/plain'
                );
            $mc = 0;
            foreach ($mails as $mail) {
                unset($userprofile);
                unset($user);
                $userprofile    = $userprofilerepo->findOneBy(array("user" => $mail->getUser()));
                $user           = $userrepo->findOneBy(array("id" => $mail->getUser()));
                unset($useremail);
                $useremail = $user->getEmail();

                $useremail = "alex@r3y.de";

                $tmp = explode("@", $useremail);


                if (filter_var($useremail, FILTER_VALIDATE_EMAIL) && checkdnsrr($tmp[1], 'MX')) {
                    $message->addBcc($useremail, $userprofile->getFirstName());
                    echo "> ".$a." \t ".$user->getId()." \t ".$useremail."\n";
                    $mc++;
                }
            }
            if ($mc >= 1) {
                $mailer->send($message);
                echo "# sent.\n";
                sleep(1);
            }
        }

        $output->writeln(sprintf(''.$counter.' Newsletter to '.$numusers.' emails successfully sent!'));
    }

    /**
     * @see Command
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        if (!$input->getArgument('file')) {
            $file = $this->getHelper('dialog')->askAndValidate(
                $output,
                'Please enter a file:',
                function ($file) {
                    if (empty($file)) {
                        throw new \Exception('file can not be empty');
                    }

                    return $file;
                }
            );
            $input->setArgument('file', $file);
        }
    }
}
