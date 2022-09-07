<?php

declare(strict_types=1);

namespace PoP\ComponentModel;

use PoP\Definitions\Configuration\Request as DefinitionsRequest;

class Environment
{
    public final const ENABLE_COMPONENT_MODEL_CACHE = 'ENABLE_COMPONENT_MODEL_CACHE';
    public final const USE_COMPONENT_MODEL_CACHE = 'USE_COMPONENT_MODEL_CACHE';
    public final const NAMESPACE_TYPES_AND_INTERFACES = 'NAMESPACE_TYPES_AND_INTERFACES';
    public final const ENABLE_MUTATIONS = 'ENABLE_MUTATIONS';
    public final const EXPOSE_SENSITIVE_DATA_IN_SCHEMA = 'EXPOSE_SENSITIVE_DATA_IN_SCHEMA';
    public final const VALIDATE_FIELD_TYPE_RESPONSE_WITH_SCHEMA_DEFINITION = 'VALIDATE_FIELD_TYPE_RESPONSE_WITH_SCHEMA_DEFINITION';
    public final const SET_FIELD_AS_NULL_IF_DIRECTIVE_FAILED = 'SET_FIELD_AS_NULL_IF_DIRECTIVE_FAILED';
    public final const CONVERT_INPUT_VALUE_FROM_SINGLE_TO_LIST = 'CONVERT_INPUT_VALUE_FROM_SINGLE_TO_LIST';
    public final const ENABLE_UNION_TYPE_IMPLEMENTING_INTERFACE_TYPE = 'ENABLE_UNION_TYPE_IMPLEMENTING_INTERFACE_TYPE';
    public final const SKIP_EXPOSING_DANGEROUSLY_NON_SPECIFIC_SCALAR_TYPE_IN_SCHEMA = 'SKIP_EXPOSING_DANGEROUSLY_NON_SPECIFIC_SCALAR_TYPE_IN_SCHEMA';
    public final const ENABLE_MODIFYING_ENGINE_BEHAVIOR_VIA_REQUEST = 'ENABLE_MODIFYING_ENGINE_BEHAVIOR_VIA_REQUEST';
    public final const ENABLE_FEEDBACK_CATEGORY_EXTENSIONS = 'ENABLE_FEEDBACK_CATEGORY_EXTENSIONS';
    public final const LOG_EXCEPTION_ERROR_MESSAGES_AND_TRACES = 'LOG_EXCEPTION_ERROR_MESSAGES_AND_TRACES';
    public final const SEND_EXCEPTION_ERROR_MESSAGES = 'SEND_EXCEPTION_ERROR_MESSAGES';
    public final const SEND_EXCEPTION_TRACES = 'SEND_EXCEPTION_TRACES';
    public final const EXPOSE_SELF_FIELD_IN_GRAPHQL_SCHEMA = 'EXPOSE_SELF_FIELD_IN_GRAPHQL_SCHEMA';

    /**
     * Indicate if to enable to restrict a field and directive by version,
     * using the same semantic versioning constraint rules used by Composer
     *
     * @see https://getcomposer.org/doc/articles/versions.md Composer's semver constraint rules
     */
    public static function enableSemanticVersionConstraints(): bool
    {
        return getenv('ENABLE_SEMANTIC_VERSION_CONSTRAINTS') !== false ? strtolower(getenv('ENABLE_SEMANTIC_VERSION_CONSTRAINTS')) === "true" : false;
    }

    // public static function failIfSubcomponentTypeResolverUndefined()
    // {
    //     return getenv('FAIL_IF_SUBCOMPONENT_TYPERESOLVER_IS_UNDEFINED') !== false ? strtolower(getenv('FAIL_IF_SUBCOMPONENT_TYPERESOLVER_IS_UNDEFINED')) === "true" : false;
    // }

    public static function enableExtraRoutesByParams(): bool
    {
        return getenv('ENABLE_EXTRA_ROUTES_BY_PARAMS') !== false ? strtolower(getenv('ENABLE_EXTRA_ROUTES_BY_PARAMS')) === "true" : false;
    }

    /**
     * Use 'components' or 'm' in the JS context. Used to compress the file size in PROD
     */
    public static function compactResponseJsonKeys(): bool
    {
        // Do not compact if not mangled
        if (!DefinitionsRequest::isMangled()) {
            return false;
        }

        return getenv('COMPACT_RESPONSE_JSON_KEYS') !== false ? strtolower(getenv('COMPACT_RESPONSE_JSON_KEYS')) === "true" : false;
    }
}
