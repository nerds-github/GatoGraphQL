<?php

declare(strict_types=1);

namespace GraphQLAPI\GraphQLAPI\Services\MenuPages;

use GraphQLAPI\GraphQLAPI\App;
use GraphQLAPI\GraphQLAPI\Constants\RequestParams;
use GraphQLAPI\GraphQLAPI\ContentProcessors\ContentParserOptions;
use GraphQLAPI\GraphQLAPI\ContentProcessors\NoDocsFolderPluginMarkdownContentRetrieverTrait;
use GraphQLAPI\GraphQLAPI\Services\MenuPages\AbstractDocsMenuPage;
use GraphQLAPI\GraphQLAPI\Services\MenuPages\OpenInModalTriggerMenuPageTrait;

class RecipesMenuPage extends AbstractDocsMenuPage
{
    use OpenInModalTriggerMenuPageTrait;
    use NoDocsFolderPluginMarkdownContentRetrieverTrait;

    public function getMenuPageSlug(): string
    {
        return 'recipes';
    }

    protected function useTabpanelForContent(): bool
    {
        return false;
    }

    protected function getContentToPrint(): string
    {
        $recipeEntries = [
            [
                'intro',
                'Intro',
            ],
            [
                'fetching-data-to-build-headless-sites',
                'Fetching data to build headless sites',
            ],
            [
                'exposing-a-secure-public-api',
                'Exposing a secure public API',
            ],
            [
                'searching-data-by-meta-queries',
                'Searching data by meta queries',
            ],
            [
                'complementing-wp-cli',
                'Complementing WP-CLI',
            ],
            [
                'inserting-a-gutenberg-block-in-all-posts',
                'Inserting a Gutenberg block in all posts',
                true,
            ],
            [
                'removing-a-gutenberg-block-from-all-posts',
                'Removing a Gutenberg block from all posts',
                true,
            ],
            [
                'converting-content-to-gutenberg-blocks',
                'Converting content to Gutenberg blocks',
                true,
            ],
            [
                'executing-admin-tasks',
                'Executing admin tasks',
                true,
            ],
            [
                'site-migrations',
                'Site migrations',
                true,
            ],
            [
                'automating-tasks',
                'Automating tasks',
                true,
            ],
            [
                'checking-and-fixing-content-when-published',
                'Checking and fixing content when published',
                true,
            ],
            [
                'bulk-editing-content',
                'Bulk editing content',
                true,
            ],
            [
                'interacting-with-3rd-party-service-apis',
                'Interacting with 3rd-party service APIs',
                true,
            ],
            [
                'filtering-data-from-an-external-api',
                'Filtering data from an external API',
                true,
            ],
            [
                'transforming-data-from-an-external-api',
                'Transforming data from an external API',
                true,
            ],
            [
                'combining-user-data-from-different-systems',
                'Combining user data from different systems',
                true,
            ],
            [
                'importing-a-post-from-another-site',
                'Importing a post from another site',
                true,
            ],
            [
                'importing-multiple-posts-at-once-from-another-site',
                'Importing multiple posts at once from another site',
                true,
            ],
            [
                'synchronizing-content-across-wordpress-sites',
                'Synchronizing content across WordPress sites',
                true,
            ],
            [
                'retrieving-and-downloading-github-artifacts',
                'Retrieving and downloading GitHub Artifacts',
                true,
            ],
            [
                'reverting-mutations-in-case-of-error',
                'Reverting mutations in case of error',
                true,
            ],
            [
                'using-the-graphql-server-without-wordpress',
                'Using the GraphQL server without WordPress',
                true,
            ],            
        ];
        // By default, focus on the first recipe
        $activeRecipeName = $recipeEntries[0][0];
        // If passing a tab, focus on that one, if the module exists
        $tab = App::query(RequestParams::TAB);
        if ($tab !== null) {
            $recipeNames = array_map(
                fn (array $recipeEntry) => $recipeEntry[0],
                $recipeEntries
            );
            if (in_array($tab, $recipeNames)) {
                $activeRecipeName = $tab;
            }
        }
        $class = 'wrap vertical-tabs graphql-api-tabpanel';

        $markdownContent = sprintf(
            <<<HTML
            <div id="%s" class="%s">
                <h1>%s</h1>
                <div class="nav-tab-container">
                    <!-- Tabs -->
                    <h2 class="nav-tab-wrapper">
            HTML,
            'graphql-api-recipes',
            $class,
            \__('GraphQL API - Recipes: Use Cases, Best Practices, and Useful Queries', 'graphql-api')
        );

        foreach ($recipeEntries as $recipeEntry) {
            $recipeEntryName = $recipeEntry[0];
            $recipeEntryTitle = $recipeEntry[1];
            $recipeEntryIsPRO = $recipeEntry[2] ?? false;

            $markdownContent .= sprintf(
                '<a href="#%s" class="nav-tab %s">%s</a>',
                $recipeEntryName,
                $recipeEntryName === $activeRecipeName ? 'nav-tab-active' : '',
                $this->getRecipeTitleForNavbar($recipeEntryTitle, $recipeEntryIsPRO)
            );
        }

        $markdownContent .= <<<HTML
                    </h2>
                    <div class="nav-tab-content">
        HTML;

        foreach ($recipeEntries as $recipeEntry) {
            $recipeEntryName = $recipeEntry[0];
            $recipeEntryTitle = $recipeEntry[1];
            $recipeEntryIsPRO = $recipeEntry[2] ?? false;

            $recipeEntryRelativePathDir = ($recipeEntryIsPRO ? 'docs-pro' : 'docs') . '/recipes';
            $recipeContent = $this->getMarkdownContent(
                $recipeEntryName,
                $recipeEntryRelativePathDir,
                [
                    ContentParserOptions::TAB_CONTENT => false,
                ]
            ) ?? sprintf(
                '<p>%s</p>',
                sprintf(
                    \__('Oops, there was a problem loading recipe "%s"', 'graphql-api'),
                    $recipeEntryTitle
                )
            );

            // Hide the title from the content, as it's already shown below
            $recipeContent = str_replace(
                '<h1>',
                '<h1 style="display: none;">',
                $recipeContent
            );

            $markdownContent .= sprintf(
                <<<HTML
                    <div id="%s" class="%s" style="%s">
                        <h2>%s</h2><hr/>
                        %s
                    </div>
                HTML,
                $recipeEntryName,
                'tab-content',
                sprintf(
                    'display: %s;',
                    $recipeEntryName === $activeRecipeName ? 'block' : 'none'
                ),
                $recipeEntryTitle,
                $this->getRecipeContent($recipeContent, $recipeEntryIsPRO)
            );
        }

        $markdownContent .= <<<HTML
                </div> <!-- class="nav-tab-content" -->
            </div> <!-- class="nav-tab-container" -->
        </div>
        HTML;
        return $markdownContent;
    }

    protected function getRecipeTitleForNavbar(
        string $recipeEntryTitle,
        bool $recipeEntryIsPRO,
    ): string {
        return $recipeEntryTitle;
    }

    protected function getRecipeContent(
        string $recipeContent,
        bool $recipeEntryIsPRO,
    ): string {
        return $recipeContent;
    }

    /**
     * Enqueue the required assets and initialize the localized scripts
     */
    protected function enqueueAssets(): void
    {
        parent::enqueueAssets();

        $this->enqueueTabpanelAssets();
    }
}
