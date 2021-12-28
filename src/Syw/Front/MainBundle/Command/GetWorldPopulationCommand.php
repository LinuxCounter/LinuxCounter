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

/**
 * Class GetWorldPopulationCommand
 *
 * @category Command
 * @package  SywFrontMainBundle
 * @author   Christin Löhner <alex.loehner@linux.com>
 * @license  GPL v3
 * @link     https://github.com/christinloehner/linuxcounter.new
 */
class GetWorldPopulationCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('syw:get:worldpopulation')
            ->setDescription('Gets the current world population')
            ->setDefinition(array())
            ->setHelp(<<<EOT
The <info>syw:get:worldpopulation</info> gets the current world population

EOT
            );
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $iutotal = 3097795850;
        $iudate = "04/04/2015";
        $iurate = 6.875;

        $saveto = "population.db";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://www.prb.org/");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, '3');
        $html = trim(curl_exec($ch));
        curl_close($ch);

        $pop  = preg_replace("`.*var startingPop = parseInt\('([^']+)'\);.*`is", "\\1", $html);
        $pop  = (float)$pop;
        $date = preg_replace("`.*var startingDate = new Date\('([^']+)'\);.*`is", "\\1", $html);
        $rate = preg_replace("`.*var ratePerSecond = parseFloat\('([^']+)'\);.*`is", "\\1", $html);
        $rate  = (float)$rate;
        $popstr = "$pop|$date|$rate";
        $iustr  = "$iutotal|$iudate|$iurate";
        $oldcontent = file($saveto);
        if (true === isset($oldcontent) && true === is_array($oldcontent) && count($oldcontent) >= 2) {
            $oldpop = trim($oldcontent[0]);
            if ($oldpop != $popstr) {
                @unlink($saveto);
                $fp = fopen($saveto, "w");
                fwrite($fp, $popstr."\n".$iustr);
                fclose($fp);
                chmod($saveto, 0640);
            }
        } else {
            @unlink($saveto);
            $fp = fopen($saveto, "w");
            fwrite($fp, $popstr."\n".$iustr);
            fclose($fp);
            chmod($saveto, 0640);
        }


        $output->writeln(sprintf('World population received and stored.'));
    }

    /**
     * @see Command
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {

    }
}
