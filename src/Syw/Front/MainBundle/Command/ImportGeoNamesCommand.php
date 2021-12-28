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
class ImportGeoNamesCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('syw:import:geonames')
            ->setDescription('Creates the statistics for registrations')
            ->setDefinition(array())
            ->setHelp(<<<EOT
The <info>syw:import:geonames</info> command imports allCountries from geonames.

EOT
            );
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $licotestdb = $this->getContainer()->get('doctrine.dbal.default_connection');

        chdir('/tmp');

        @unlink('/tmp/allCountries.zip');
        @unlink('/tmp/allCountries.txt');
        $this->downloadFile('http://download.geonames.org/export/dump/allCountries.zip', '/tmp/allCountries.zip');
        @exec('/usr/bin/unzip ./allCountries.zip');

        $licotestdb->query("LOAD DATA LOCAL INFILE '/tmp/allCountries.txt' REPLACE
            INTO TABLE allCountries
            FIELDS TERMINATED BY '\\t' ENCLOSED BY '' ESCAPED BY '\\\\' LINES TERMINATED BY '\\n' STARTING BY ''");

    }

    public function downloadFile($file_source, $file_target)
    {
        set_time_limit(0);
        $rh = fopen($file_source, 'rb');
        $wh = fopen($file_target, 'w+b');
        if (!$rh || !$wh) {
            return false;
        }
        while (!feof($rh)) {
            if (fwrite($wh, fread($rh, 4096)) === false) {
                return false;
            }
            echo '.';
            flush();
        }
        fclose($rh);
        fclose($wh);
        return true;
    }

    /**
     * @see Command
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {

    }
}
