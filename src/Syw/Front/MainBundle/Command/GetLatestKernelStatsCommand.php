<?php

namespace Syw\Front\MainBundle\Command;

use Eko\FeedBundle\Hydrator\DefaultHydrator;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Syw\Front\MainBundle\Entity\StatsKernelBadWords;
use Syw\Front\MainBundle\Entity\StatsKernelGoodWords;
use Syw\Front\MainBundle\Entity\StatsKernelLinesOfCode;

/**
 *
 */
class GetLatestKernelStatsCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('syw:get:latest:kernel')
            ->setDescription('')
            ->setDefinition(array())
            ->setHelp(<<<EOT
The <info>syw:get:latest:kernel</info> command gets the latest kernel and generates the statistics.

EOT
            );
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $kerneldir = "/usr/local/kernels";
        $kernelarchive = "https://www.kernel.org/pub/linux/kernel/";
        $newversion = false;

        $em = $this->getContainer()->get('doctrine')->getManager();
        $qb = $em->createQueryBuilder();

        $last = $em->getRepository('SywFrontMainBundle:StatsKernelLinesOfCode')->findOneBy(array(), array('id' => 'DESC'), 1, 0);

        $nextversions = array();
        $lastversion = trim($last->getVersion());
        $lastparts = explode(".", $lastversion);
        if (count($lastparts) == 3) {
            $nextversions[] = $lastparts[0].".".$lastparts[1].".".($lastparts[2]+1);
            $nextversions[] = $lastparts[0].".".($lastparts[1]+1);
            $nextversions[] = $lastparts[0].".".($lastparts[1]+1).".0";
            $nextversions[] = ($lastparts[0]+1).".0";
            $nextversions[] = ($lastparts[0]+1).".0.0";
            $nextversions[] = $lastparts[0].".".$lastparts[1].".".($lastparts[2]+2);
            $nextversions[] = $lastparts[0].".".($lastparts[1]+2);
            $nextversions[] = $lastparts[0].".".($lastparts[1]+2).".0";
            $nextversions[] = ($lastparts[0]+2).".0";
            $nextversions[] = ($lastparts[0]+2).".0.0";
        } elseif (count($lastparts) == 2) {
            $nextversions[] = $lastparts[0].".".$lastparts[1].".0";
            $nextversions[] = $lastparts[0].".".$lastparts[1].".1";
            $nextversions[] = $lastparts[0].".".$lastparts[1].".2";
            $nextversions[] = $lastparts[0].".".($lastparts[1]+1);
            $nextversions[] = $lastparts[0].".".($lastparts[1]+1).".0";
        }

        $downloadurl = "";
        $downloaddir = "";
        foreach ($nextversions as $nextversion) {
            unset($parts);
            unset($trys);
            $parts = explode(".", $nextversion);
            $trys[0] = "v".$parts[0].".".$parts[1];
            $trys[1] = "v".$parts[0].".x";

            foreach ($trys as $try) {
                $url = $kernelarchive.$try;
                $headers = get_headers($url, 1);
                if (trim($headers[0]) == "HTTP/1.1 200 OK" || trim($headers[0]) == "HTTP/1.1 301 Moved Permanently") {
                    $downloaddir = $url;
                    break 2;
                }
            }
        }

        if ($downloaddir != "") {
            echo "\n".$downloaddir."\n";
            $downloadfile = "";
            foreach ($nextversions as $nextversion) {
                $url = $downloaddir."/linux-".$nextversion.".tar.gz";
                $handle = curl_init($url);
                curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($handle, CURLOPT_NOBODY, true);
                $response = curl_exec($handle);
                $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
                if ($httpCode == 200) {
                    $downloadfile = "linux-".$nextversion.".tar.gz";
                    break;
                }
                curl_close($handle);
            }
            if ($downloadfile == "") {
                foreach ($nextversions as $nextversion) {
                    $url = $downloaddir."/linux-".$nextversion.".tar.bz2";
                    $handle = curl_init($url);
                    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($handle, CURLOPT_NOBODY, true);
                    $response = curl_exec($handle);
                    $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
                    if ($httpCode == 200) {
                        $downloadfile = "linux-".$nextversion.".tar.gz";
                        break;
                    }
                    curl_close($handle);
                }
            }

            if ($downloadfile != "") {
                $downloadurl = $downloaddir."/".$downloadfile;
            }
        }

        if ($downloadurl != "") {
            chdir($kerneldir);

            $targetfile = $downloadfile;
            $targetpath = $kerneldir.'/'.$downloadfile;

            set_time_limit(0);
            $result = $this->downloadFile($downloadurl, $targetpath);
            if (!$result) {
                throw new Exception('Download error...');
                exit(1);
            }

            if (preg_match("`.*tar\.bz2$`", $targetfile)) {
                $error = exec("/bin/tar -xvjf ".$targetfile." 2>&1 3>&1 4>&1", $errarr);
            } else {
                $error = exec("/bin/tar -xvzf ".$targetfile." 2>&1 3>&1 4>&1", $errarr);
            }

            $filedir = "";
            $fd = opendir(".");
            while ($thisdir = readdir($fd)) {
                if (true === is_dir($thisdir) && $thisdir != "." && $thisdir != "..") {
                    $filedir = $thisdir;
                    break;
                }
            }
            if ($filedir != "") {
                $filedir = $kerneldir."/".$filedir;
                echo "\n".$filedir."\n";
                $version = preg_replace("`^linux-([0-9]+\.[0-9]*\.?[0-9]*)\.tar\.[bgz2]+$`", "$1", $targetfile);
                echo "version:   ".$version."\n";
                # $loc = exec('cloc "'.$filedir.'" --csv | grep -A 50 "files,language,blank" | grep -v "files,language,blank" | cut -d "," -f 5 | awk \'{s+=$1} END {print s}\'');

                $loc = exec('output=$( cloc "'.$filedir.'" --csv | grep -A 50 "files,language,blank" | grep -v "files,language,blank" ) ; sum1=$( echo "$output" | cut -d "," -f 5 | awk \'{s+=$1} END {print s}\' ) ; sum2=$( echo "$output" | cut -d "," -f 4 | awk \'{s+=$1} END {print s}\' ) ; echo -e "$sum1\n$sum2" | awk \'{s+=$1} END {print s}\'');

                echo "LOC:       ".$loc."\n";

                if (intval($loc) <= 100000) {
                    @exec("/bin/rm -fr ".$filedir." 2>&1 3>&1 4>&1");
                    throw new Exception('Lines of Code detection error...');
                    exit(1);
                }

                if (intval($loc) >= 100001) {
                    $fuck = exec('/bin/grep -roh fuck '.$filedir.' | /usr/bin/wc -w');
                    echo "\"fuck\":    ".$fuck."\n";

                    $shit = exec('/bin/grep -roh shit '.$filedir.' | /usr/bin/wc -w');
                    echo "\"shit\":    ".$shit."\n";

                    $crap = exec('/bin/grep -roh crap '.$filedir.' | /usr/bin/wc -w');
                    echo "\"crap\":    ".$crap."\n";

                    $bastard = exec('/bin/grep -roh bastard '.$filedir.' | /usr/bin/wc -w');
                    echo "\"bastard\": ".$bastard."\n";

                    $piss = exec('/bin/grep -roh piss '.$filedir.' | /usr/bin/wc -w');
                    echo "\"piss\":    ".$piss."\n";

                    $fire = exec('/bin/grep -roh fire '.$filedir.' | /usr/bin/wc -w');
                    echo "\"fire\":    ".$fire."\n";

                    $asshole = exec('/bin/grep -roh asshole '.$filedir.' | /usr/bin/wc -w');
                    echo "\"asshole\": ".$asshole."\n";

                    $love = exec('/bin/grep -roh love '.$filedir.' | /usr/bin/wc -w');
                    echo "\"love\":    ".$love."\n";

                    $good = exec('/bin/grep -roh good '.$filedir.' | /usr/bin/wc -w');
                    echo "\"good\":    ".$good."\n";

                    $nice = exec('/bin/grep -roh nice '.$filedir.' | /usr/bin/wc -w');
                    echo "\"nice\":    ".$nice."\n";

                    $sweet = exec('/bin/grep -roh sweet '.$filedir.' | /usr/bin/wc -w');
                    echo "\"sweet\":   ".$sweet."\n";

                    $kiss = exec('/bin/grep -roh kiss '.$filedir.' | /usr/bin/wc -w');
                    echo "\"kiss\":    ".$kiss."\n";

                    $dbloc = new StatsKernelLinesOfCode();
                    $dbloc->setVersion($version);
                    $dbloc->setNum($loc);
                    $em->persist($dbloc);
                    $em->flush();

                    $bw = new StatsKernelBadWords();
                    $bw->setVersion($version);
                    $bw->setFuck($fuck);
                    $bw->setShit($shit);
                    $bw->setCrap($crap);
                    $bw->setBastard($bastard);
                    $bw->setPiss($piss);
                    $bw->setFire($fire);
                    $bw->setAsshole($asshole);
                    $em->persist($bw);
                    $em->flush();

                    $gw = new StatsKernelGoodWords();
                    $gw->setVersion($version);
                    $gw->setLove($love);
                    $gw->setGood($good);
                    $gw->setNice($nice);
                    $gw->setSweet($sweet);
                    $gw->setKiss($kiss);
                    $em->persist($gw);
                    $em->flush();

                    $newversion = true;

                }
                @exec("/bin/rm -fr ".$filedir." 2>&1 3>&1 4>&1");
            }
            @exec("/bin/rm -fr ".$targetpath." 2>&1 3>&1 4>&1");

            chdir(str_replace("/src/Syw/Front/MainBundle/Command", "", dirname(__FILE__)));
        }


        if ($newversion === true) {
            #
            #
            #
            #
            include('/srv/blog.linuxcounter.net/web/wp-load.php');
            date_default_timezone_set('Europe/Berlin');

            $postcontent = "The new Linux Kernel Version ".$version." is available for download!

Visit the Linux Kernel Archive here:
  <a href=\"$kernelarchive\">".$kernelarchive."</a>

Get the new Linux Kernel directly through this link:
  <a href=\"$downloadurl\">".$downloadurl."</a>

<b>NEW:</b>
See the latest FUN statistics for this Kernel version here:
  <a href=\"https://www.linuxcounter.net/statistics/kernel\">https://www.linuxcounter.net/statistics/kernel</a>

See how many lines of code this new version has, how many bad words or how many good words are included in the code of this new version!

";

            $myPost = array(
                'post_title' => 'New Linux Kernel Version '.$version.' available for download!',
                'post_content' => $postcontent,
                'post_status' => 'publish',
                'post_type' => 'post',
                'post_author' => 1,
                'comment_status' => 'open',
                'ping_status' => 'open',
                'post_category' => array(2, 21, 22),
            );

            //-- Create the new post
            $newPostID = wp_insert_post($myPost);

        } else {
            echo "No new version available.\n";
        }

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
