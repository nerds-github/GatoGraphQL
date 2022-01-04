<?php

declare(strict_types=1);

namespace PoP\Root;

use LogicException;
use PHPUnit\Framework\TestCase;
use PoP\Root\AppLoader;
use PoP\Root\Container\ContainerBuilderFactory;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class AbstractTestCase extends TestCase
{
    private static ?ContainerInterface $container = null;

    public static function setUpBeforeClass(): void
    {
        static::initializeAppLoader(false, null, null, true);
        self::$container = ContainerBuilderFactory::getInstance();
    }

    protected static function initializeAppLoader(
        ?bool $cacheContainerConfiguration = null,
        ?string $containerNamespace = null,
        ?string $containerDirectory = null,
        bool $isDev = false
    ): void {
        $appLoader = static::getAppLoaderClass();
        $appLoader::addComponentClassesToInitialize(static::getComponentClassesToInitialize());
        $appLoader::initializeComponents($isDev);
        $appLoader::bootSystem($cacheContainerConfiguration, $containerNamespace, $containerDirectory);

        // Only after initializing the System Container,
        // we can obtain the configuration (which may depend on hooks)
        $appLoader::addComponentClassConfiguration(
            static::getComponentClassConfiguration()
        );

        $appLoader::bootApplication($cacheContainerConfiguration, $containerNamespace, $containerDirectory);
    }

    protected static function getAppLoaderClass(): string
    {
        return AppLoader::class;
    }

    /**
     * @return string[]
     */
    protected static function getComponentClassesToInitialize(): array
    {
        return [
            static::getComponentClass(),
        ];
    }

    /**
     * Add configuration for the Component classes
     *
     * @return array<string, mixed> [key]: Component class, [value]: Configuration
     */
    protected static function getComponentClassConfiguration(): array
    {
        return [];
    }

    /**
     * Package's Component class, of type ComponentInterface.
     * By standard, it is "NamespaceOwner\Project\Component::class"
     */
    protected static function getComponentClass(): string
    {
        $class = \get_called_class();
        $parts = \explode('\\', $class);
        if (\count($parts) < 3) {
            throw new LogicException(
                sprintf(
                    'Could not deduce the package Component class from "%s". Must override function "%s"?',
                    $class,
                    __FUNCTION__
                )
            );
        }
        return $parts[0] . '\\' . $parts[1] . '\\Component';
    }

    public static function tearDownAfterClass(): void
    {
        $appLoader = static::getAppLoaderClass();
        $appLoader::reset();
    }

    protected function getService(string $service): mixed
    {
        return self::$container->get($service);
    }
}
