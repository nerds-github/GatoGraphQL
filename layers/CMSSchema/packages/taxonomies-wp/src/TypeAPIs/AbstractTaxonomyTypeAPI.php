<?php

declare(strict_types=1);

namespace PoPCMSSchema\TaxonomiesWP\TypeAPIs;

use PoP\Root\App;
use PoP\Root\Services\BasicServiceTrait;
use PoPCMSSchema\SchemaCommons\DataLoading\ReturnTypes;
use PoPCMSSchema\Taxonomies\Constants\TaxonomyOrderBy;
use PoPSchema\SchemaCommons\Constants\QueryOptions;
use WP_Error;
use WP_Term;

use function get_term;
use function esc_sql;

abstract class AbstractTaxonomyTypeAPI
{
    use BasicServiceTrait;
    
    public const HOOK_QUERY = __CLASS__ . ':query';
    public final const HOOK_ORDERBY_QUERY_ARG_VALUE = __CLASS__ . ':orderby-query-arg-value';

    /**
     * @return array<string,mixed>
     * @param array<string,mixed> $query
     * @param array<string,mixed> $options
     */
    protected function convertTaxonomiesQuery(array $query, array $options = []): array
    {
        if ($return_type = $options[QueryOptions::RETURN_TYPE] ?? null) {
            if ($return_type === ReturnTypes::IDS) {
                $query['fields'] = 'ids';
            } elseif ($return_type === ReturnTypes::NAMES) {
                $query['fields'] = 'names';
            }
        }

        if (isset($query['hide-empty'])) {
            $query['hide_empty'] = $query['hide-empty'];
            unset($query['hide-empty']);
        } else {
            // By default: do not hide empty categories
            $query['hide_empty'] = false;
        }

        // Convert the parameters
        if (isset($query['include']) && is_array($query['include'])) {
            // It can be an array or a string
            $query['include'] = implode(',', $query['include']);
        }
        if (isset($query['exclude-ids'])) {
            $query['exclude'] = $query['exclude-ids'];
            unset($query['exclude-ids']);
        }
        if (isset($query['order'])) {
            $query['order'] = esc_sql($query['order']);
        }
        if (isset($query['orderby'])) {
            // This param can either be a string or an array. Eg:
            // $query['orderby'] => array('date' => 'DESC', 'title' => 'ASC');
            $query['orderby'] = esc_sql($this->getOrderByQueryArgValue($query['orderby']));
        }
        if (isset($query['offset'])) {
            // Same param name, so do nothing
        }
        if (isset($query['limit'])) {
            $limit = (int) $query['limit'];
            // To bring all results, get_categories/get_tags needs "number => 0" instead of -1
            $query['number'] = ($limit == -1) ? 0 : $limit;
            unset($query['limit']);
        }
        if (isset($query['search'])) {
            // Same param name, so do nothing
        }
        if (isset($query['slugs'])) {
            $query['slug'] = $query['slugs'];
            unset($query['slugs']);
        }
        if (isset($query['slug'])) {
            // Same param name, so do nothing
        }
        if (isset($query['parent-id'])) {
            $query['parent'] = $query['parent-id'];
            unset($query['parent-id']);
        }

        return App::applyFilters(
            self::HOOK_QUERY,
            $query,
            $options
        );
    }

    protected function getOrderByQueryArgValue(string $orderBy): string
    {
        $orderBy = match ($orderBy) {
            TaxonomyOrderBy::NAME => 'name',
            TaxonomyOrderBy::SLUG => 'slug',
            TaxonomyOrderBy::ID => 'term_id',
            TaxonomyOrderBy::PARENT => 'parent',
            TaxonomyOrderBy::COUNT => 'count',
            TaxonomyOrderBy::NONE => 'none',
            TaxonomyOrderBy::INCLUDE => 'include',
            TaxonomyOrderBy::SLUG__IN => 'slug__in',
            TaxonomyOrderBy::DESCRIPTION => 'description',
            default => $orderBy,
        };
        return App::applyFilters(
            self::HOOK_ORDERBY_QUERY_ARG_VALUE,
            $orderBy
        );
    }
    protected function getTerm(string|int $termObjectID, string $taxonomy = ''): ?WP_Term
    {
        $term = get_term((int)$termObjectID, $taxonomy);
        if ($term instanceof WP_Error) {
            return null;
        }
        /** @var WP_Term */
        return $term;
    }
}
