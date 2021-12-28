<?php

namespace Syw\Front\MainBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use FOS\UserBundle\Model\User;
use Syw\Front\MainBundle\Entity\Allcountries;

/**
 *
 */
class CorrectCountriesAndCitiesCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('syw:correct:allcountries')
            ->setDescription('Re-adds the profile id to the user table')
            ->setDefinition(array(
                new InputArgument('item', InputArgument::REQUIRED, 'the item to import')
            ))
            ->setHelp(<<<EOT
The <info>syw:correct:allcountries</info> command corrects the countries and cities from the allCountries file from geonames.org.

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

        $importlogfile = "import.correct.allcountries";


        if ($item == "start") {
            @exec("php app/console syw:correct:allcountries continue >>".$importlogfile.".log 2>&1 3>&1 4>&1 &");
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
                $nums     = $licotestdb->fetchAll('SELECT COUNT(geonameid) AS num FROM allCountries WHERE feature_code IN (\'PCLI\', \'PPL\', \'PPLF\', \'PPLS\', \'PPLL\')');
                $numusers = $nums[0]['num'];
                $start    = 0; // $numusers;
                $counter  = 0;
            }
            $itemsperloop = 10;
            $z = 0;
            $a = $start;

            $qb = $licotest->createQueryBuilder("c");
            $qb->select('c')
                ->from("SywFrontMainBundle:Allcountries", "c")
                ->where("c.featureCode = 'PCLI'")
                ->orwhere("c.featureCode = 'PPL'")
                ->orwhere("c.featureCode = 'PPLF'")
                ->orwhere("c.featureCode = 'PPLS'")
                ->orwhere("c.featureCode = 'PPLL'")
                ->addOrderBy('c.geonameid', 'ASC')
                ->setFirstResult($a)
                ->setMaxResults($itemsperloop);
            $allcountries = $qb->getQuery()->getResult();
            foreach ($allcountries as $allcountry) {
                $counter++;

                echo $allcountry->getName()."\n";



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
            @exec("php app/console syw:correct:allcountries start >>".$importlogfile.".log 2>&1 3>&1 4>&1 &");
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
