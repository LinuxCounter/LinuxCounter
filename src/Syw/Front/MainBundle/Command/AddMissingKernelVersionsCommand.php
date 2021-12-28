<?php

namespace Syw\Front\MainBundle\Command;

use Eko\FeedBundle\Hydrator\DefaultHydrator;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Syw\Front\MainBundle\Entity\Kernels;

/**
 *
 */
class AddMissingKernelVersionsCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('syw:add:missing:kernels')
            ->setDescription('')
            ->setDefinition(array())
            ->setHelp(<<<EOT
The <info>syw:add:missing:kernels</info> command adds missing kernel versions.

EOT
            );
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em         = $this->getContainer()->get('doctrine')->getManager();

        $kernelarchive = "https://www.kernel.org/pub/linux/kernel/";
        $newversion = false;

        $src = $this->getSource($kernelarchive);
        $matches = array();
        preg_match_all("`\<a href=\"(v[0-9]+\.[^\"]+)\/\"\>([^\<]+)\<\/a\>`", $src, $matches);

        foreach ($matches[1] as $vers1) {
            $url = $kernelarchive."".$vers1."/";
            $src2 = $this->getSource($url);

            $matches2 = array();
            preg_match_all("`\<a href=\"linux-([0-9\.]+)\.tar\.sign\"\>([^\<]+)\<\/a\>`", $src2, $matches2);

            foreach ($matches2[1] as $var) {
                $version = preg_replace("`^([^\.-]+)\.([^\.-]+\.?[^\.-]*).*$`i", "$1.$2", trim($var));
                $version = trim($version);

                $obj = $em->getRepository('SywFrontMainBundle:Kernels')->findOneBy(array('name' => $version));
                if (false === isset($obj) || false === is_object($obj) || $obj == null) {
                    unset($kernel);
                    $kernel = new Kernels();
                    $kernel->setName($version);
                    $kernel->setMachinesNum(0);
                    $em->persist($kernel);
                    $em->flush();
                }
            }

        }
    }

    public function checkStatus($url)
    {
        $handle = curl_init($url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_NOBODY, true);
        $response = curl_exec($handle);
        $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        if (intval($httpCode) >= 200 && intval($httpCode) <= 299) {
            return true;
        }
        return false;
    }

    public function getSource($url)
    {
        $c = curl_init($url);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        $html = curl_exec($c);
        if (curl_error($c)) {
            die(curl_error($c));
        }
        curl_close($c);
        return $html;
    }

    /**
     * @see Command
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {

    }
}
