<?php

namespace Syw\Front\MainBundle\Command;

use Eko\FeedBundle\Hydrator\DefaultHydrator;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Syw\Front\MainBundle\Entity\News;

/**
 *
 */
class GetBlogFeedItemsCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('syw:import:blogfeed')
            ->setDescription('')
            ->setDefinition(array())
            ->setHelp(<<<EOT
The <info>syw:import:blogfeed</info> command imports the blog posts.

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

        $reader = $this->getContainer()->get('eko_feed.feed.reader');
        $reader->setHydrator(new DefaultHydrator());
        $items = $reader->load('http://blog.linuxcounter.net/category/lico/feed/')->populate('Syw\Front\NewsBundle\Entity\News');

        foreach ($items as $item) {
            $news = null;
            unset($news);
            $news = $db->getRepository('SywFrontNewsBundle:News')->findOneBy(array("link" => $item->getLink()));
            if (false === isset($news) || false === is_object($news)) {
                $db->persist($item);
                $db->flush();
            }
        }
    }

    /**
     * @see Command
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {

    }
}
