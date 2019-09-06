<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/06
 */

namespace JTL\SCX\Channel\DependencyInjection;


use Symfony\Bridge\ProxyManager\LazyProxy\Instantiator\RuntimeInstantiator;
use Symfony\Bridge\ProxyManager\LazyProxy\PhpDumper\ProxyDumper;
use Symfony\Component\Config\ConfigCache;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Dumper\PhpDumper;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class ContainerCreator
{
    /**
     * @var bool
     */
    private $isDev;

    /**
     * ContainerCreator constructor.
     * @param bool $isDev
     */
    public function __construct(bool $isDev)
    {
        $this->isDev = $isDev;
    }

    /**
     * @param string $rootDirectory
     * @param string $serviceConfig
     * @param string $cacheFile
     * @return ContainerInterface
     * @throws \Exception
     */
    public function createInstance(
        string $rootDirectory,
        string $serviceConfig,
        string $seriveConfig2,
        string $cacheFile
    ): ContainerInterface {
        $containerConfigCache = new ConfigCache(
            $cacheFile,
            $this->isDev
        );

        if (!$containerConfigCache->isFresh()) {
            $containerBuilder = new ContainerBuilder();
            $containerBuilder->setProxyInstantiator(new RuntimeInstantiator());
            $loader = new YamlFileLoader($containerBuilder, new FileLocator($rootDirectory));
            $loader->load($serviceConfig);
            $loader->load($seriveConfig2);

            $containerBuilder->compile();

            $proxyDumper = new ProxyDumper();
            $dumper = new PhpDumper($containerBuilder);
            $dumper->setProxyDumper($proxyDumper);

            $containerConfigCache->write(
                $dumper->dump(['class' => 'CachedContainer']),
                $containerBuilder->getResources()
            );
        }

        require_once $cacheFile;

        /** @var ContainerInterface $container */
        return new \CachedContainer();
    }
}