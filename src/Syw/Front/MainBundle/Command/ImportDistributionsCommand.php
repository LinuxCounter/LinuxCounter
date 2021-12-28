<?php

namespace Syw\Front\MainBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use FOS\UserBundle\Model\User;
use Syw\Front\MainBundle\Entity\Distributions;

/**
 *
 */
class ImportDistributionsCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('syw:import:distributions')
            ->setDescription('')
            ->setDefinition(array())
            ->setHelp(<<<EOT
The <info>syw:import:distributions</info> command imports the distributions.

EOT
            );
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $db = $this->getContainer()->get('doctrine')->getManager();
        $qb = $this->getContainer()->get('doctrine.dbal.default_connection');

        $importlogfile = "import.distributions";
        $filetoimport  = "distributions.html";

        $content = file_get_contents($filetoimport);

        $matches = array();
        preg_match_all("`\s*\<p\>\s*(\<li\>\s*.*\s*\<\/li\>)\s*\<\/p\>\s*`isU", $content, $matches);

        foreach ($matches[1] as $match) {
            $url         = preg_replace("`.*\<b\>\s*\<a\s*href=\"([^\"]+)\"[^\>]*\>\s*([^\<]+)\s*\<\/a\>\s*\<\/b\>\s*.*`s", "$1", trim($match));
            $name        = preg_replace("`.*\<b\>\s*\<a\s*href=\"([^\"]+)\"[^\>]*\>\s*([^\<]+)\s*\<\/a\>\s*\<\/b\>\s*.*`s", "$2", trim($match));
            $description = preg_replace("`.*\<\/a\>.?\<br\>\s*([^\<]+)\s*\<\/li\>.*`sU", "$1", trim($match));
            $url         = trim(str_replace("\n", " ", $url));
            $name        = trim(str_replace("\n", " ", $name));

            if (strlen($name) >= 150 || strlen($url) >= 150) {
                // something went wrong... the source seems to be not correctly formatted.
                $url  = preg_replace("`.*\<b\>\s*\<a\s*href=\"([^\"]+)\"[^\>]*\>\s*\<\/a\>\s*([^\<]+)\s*\<\/b\>\s*.*`s", "$1", trim($match));
                $name = preg_replace("`.*\<b\>\s*\<a\s*href=\"([^\"]+)\"[^\>]*\>\s*\<\/a\>\s*([^\<]+)\s*\<\/b\>\s*.*`s", "$2", trim($match));
                $url  = trim(str_replace("\n", " ", $url));
                $name = trim(str_replace("\n", " ", $name));
            }
            if (preg_match("`\>$`", trim($description))) {
                $description = strip_tags($description);
            }

            $name        = trim(html_entity_decode($name));
            $description = trim(html_entity_decode($description));

            $pattern = str_replace("-linux", "", strtolower(trim($name)));
            $pattern = str_replace("linux-", "", $pattern);
            $pattern = str_replace("linux", "", $pattern);
            $pattern = str_replace("-", " ", $pattern);
            $pattern = str_replace("_", " ", $pattern);
            $pattern = str_replace(" ", "%", $pattern);
            $pattern = "%" . $pattern . "%";
            $pattern = str_replace("%%", "%", $pattern);

            echo "> " . $name . " <  (" . $pattern . ") \n";
            $rows = null;
            unset($rows);
            $rows = $qb->fetchAll("SELECT d.id, d.name FROM distributions d WHERE LOWER(d.name) LIKE '" . addslashes($pattern) . "'");

            if (false === isset($rows) || count($rows) <= 0) {
                $distribution = null;
                unset($distribution);
                $distribution = new Distributions();
                $distribution->setName($name);
                $distribution->setUrl(trim($url));
                $distribution->setDescription($description);
                $distribution->setMachinesNum(0);
                $db->persist($distribution);
                $db->flush();
            } else {
                $found = false;
                foreach ($rows as $row) {
                    $thisid   = $row['id'];
                    $thisname = $row['name'];

                    if ((strtolower($thisname) == strtolower($name)) ||
                        (strtolower(str_replace(" ", "", $thisname)) == strtolower(str_replace(" ", "", $name)))) {
                        $distribution = null;
                        unset($distribution);
                        $distribution = $db->getRepository('SywFrontMainBundle:Distributions')->findOneBy(array("id" => $thisid));
                        $distribution->setDescription($description);
                        $distribution->setUrl($url);
                        $db->persist($distribution);
                        $db->flush();
                        $found = true;
                        break;
                    }
                }

                if ($found === false) {
                    foreach ($rows as $row) {
                        $thisid   = $row['id'];
                        $thisname = $row['name'];
                        $thisparts = explode(" ", strtolower($thisname));
                        $parts     = explode(" ", strtolower($name));
                        $diff = $this->arrayDiff($thisparts, $parts);
                        if (count($diff) == 1) {
                            $distribution = null;
                            unset($distribution);
                            $distribution = $db->getRepository('SywFrontMainBundle:Distributions')->findOneBy(array("id" => $thisid));
                            $distribution->setDescription($description);
                            $distribution->setUrl($url);
                            $db->persist($distribution);
                            $db->flush();
                            $found = true;
                            break;
                        }
                    }
                }

                if ($found === false) {
                    $distribution = null;
                    unset($distribution);
                    $distribution = new Distributions();
                    $distribution->setName($name);
                    $distribution->setUrl(trim($url));
                    $distribution->setDescription($description);
                    $distribution->setMachinesNum(0);
                    $db->persist($distribution);
                    $db->flush();
                }
            }

            echo "======================================== \n";
        }
    }

    public function arrayDiff($ary_1, $ary_2)
    {
        // compare the value of 2 array
        // get differences that in ary_1 but not in ary_2
        // get difference that in ary_2 but not in ary_1
        // return the unique difference between value of 2 array
        $diff = array();

        // get differences that in ary_1 but not in ary_2
        foreach ($ary_1 as $v1) {
            $flag = 0;
            foreach ($ary_2 as $v2) {
                $flag |= ($v1 == $v2);
                if ($flag) {
                    break;
                }
            }
            if (!$flag) {
                array_push($diff, $v1);
            }
        }

        // get difference that in ary_2 but not in ary_1
        foreach ($ary_2 as $v2) {
            $flag = 0;
            foreach ($ary_1 as $v1) {
                $flag |= ($v1 == $v2);
                if ($flag) {
                    break;
                }
            }
            if (!$flag && !in_array($v2, $diff)) {
                array_push($diff, $v2);
            }
        }

        return $diff;
    }

    /**
     * @see Command
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {

    }
}
