<?php

declare(strict_types=1);

namespace GraphQLAPI\GraphQLAPI\ContentProcessors;

use GraphQLAPI\GraphQLAPI\App;
use GraphQLAPI\GraphQLAPI\PluginSkeleton\ExtensionInterface;
use GraphQLAPI\GraphQLAPI\PluginStaticHelpers;

trait ExtensionMarkdownContentRetrieverTrait
{
    /**
     * @phpstan-return class-string<ExtensionInterface>
     */
    abstract protected function getExtensionClass(): string;

    /**
     * Get the dir where to look for the documentation.
     */
    protected function getBaseDir(): string
    {
        return App::getExtension($this->getExtensionClass())->getPluginDir();
    }

    /**
     * Get the URL where to look for the documentation.
     */
    protected function getBaseURL(): string
    {
        return App::getExtension($this->getExtensionClass())->getPluginURL();
    }

    /**
     * Get the URL where to look for the documentation.
     */
    protected function getDocsFolder(): string
    {
        return 'docs';
    }

    /**
     * Get the GitHub repo URL, to retrieve images for PROD.
     */
    protected function getGithubRepoDocsPathURL(): string
    {
        return PluginStaticHelpers::getGitHubRepoDocsPathURL();
    }
}
