<?php

declare(strict_types=1);

namespace GraphQLAPI\GraphQLAPI\ContentProcessors;

use GraphQLAPI\GraphQLAPI\Exception\ContentNotExistsException;

trait MarkdownContentRetrieverTrait
{
    abstract protected function getMarkdownContentParser(): MarkdownContentParserInterface;

    /**
     * @param array<string,mixed> $options
     */
    protected function getMarkdownContent(
        string $markdownFilename,
        string $relativePathDir = '',
        array $options = []
    ): ?string {
        // Inject the place to look for the documentation
        $this->getMarkdownContentParser()->setBaseDir($this->getBaseDir());
        $this->getMarkdownContentParser()->setBaseURL($this->getBaseURL());
        $this->getMarkdownContentParser()->setDocsFolder($this->getDocsFolder());
        $this->getMarkdownContentParser()->setGithubRepoDocsPathURL($this->getGithubRepoDocsPathURL());
        try {
            return $this->getMarkdownContentParser()->getContent(
                $markdownFilename,
                'md',
                $relativePathDir,
                $options
            );
        } catch (ContentNotExistsException) {
            return null;
        }
    }

    /**
     * Get the dir where to look for the documentation.
     */
    abstract protected function getBaseDir(): string;

    /**
     * Get the URL where to look for the documentation.
     */
    abstract protected function getBaseURL(): string;

    /**
     * Get the folder under which the docs are stored
     */
    abstract protected function getDocsFolder(): string;

    /**
     * Get the GitHub repo URL, to retrieve images for PROD.
     */
    abstract protected function getGithubRepoDocsPathURL(): string;
}
