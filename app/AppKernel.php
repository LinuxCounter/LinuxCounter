<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Vitre\PhpConsoleBundle\VitrePhpConsoleBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),
            new Syw\Front\MainBundle\SywFrontMainBundle(),
            new Syw\Front\NewsBundle\SywFrontNewsBundle(),
            new Syw\Front\ApiBundle\SywFrontApiBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new Asm\TranslationLoaderBundle\AsmTranslationLoaderBundle(),
            new Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle(),
            new JavierEguiluz\Bundle\EasyAdminBundle\EasyAdminBundle(),
            new Ornicar\GravatarBundle\OrnicarGravatarBundle(),
            new Mopa\Bundle\BootstrapBundle\MopaBootstrapBundle(),
            new Shtumi\UsefulBundle\ShtumiUsefulBundle(),
            new FOS\RestBundle\FOSRestBundle(),
            new JMS\SerializerBundle\JMSSerializerBundle(),
            new Ob\HighchartsBundle\ObHighchartsBundle(),
            new Whisnet\IrcBotBundle\WhisnetIrcBotBundle(),
            new BladeTester\LightNewsBundle\BladeTesterLightNewsBundle(),
            new Redmonster\AnnouncementBundle\RedmonsterAnnouncementBundle(),
            new Eko\FeedBundle\EkoFeedBundle(),
            new EWZ\Bundle\RecaptchaBundle\EWZRecaptchaBundle(),
            new Aequasi\Bundle\CacheBundle\AequasiCacheBundle(),
            new Syw\Front\ManagerBundle\ManagerBundle(),
            new Syw\Front\ToolBoxBundle\ToolBoxBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__ . '/config/config_' . $this->getEnvironment() . '.yml');
    }

    protected function initializeContainer()
    {
        parent::initializeContainer();
        if (PHP_SAPI == 'cli') {
            $this->getContainer()->enterScope('request');
            $this->getContainer()->set('request', new \Symfony\Component\HttpFoundation\Request(), 'request');
        }
    }
}
