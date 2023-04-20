<?php

declare(strict_types=1);

namespace GraphQLAPI\GraphQLAPI\Constants;

class AdminGraphQLEndpointGroups
{
    /**
     * This one is an empty string, as to express that if passing no param
     * then the default one is used
     */
    public final const DEFAULT = '';
    public final const PLUGIN_OWN_USE = 'pluginOwnUse';
    public final const PUBLIC_PERSISTED_QUERY = 'publicPersistedQuery';
    public final const PRIVATE_PERSISTED_QUERY = 'privatePersistedQuery';
}
