<?php

\PoP\Root\App::addFilter('RequestUtils:current_url:remove_params', 'popCdnRemoveUrlparams');
function popCdnRemoveUrlparams($remove_params)
{
    $remove_params[] = GD_URLPARAM_CDNTHUMBPRINT;

    return $remove_params;
}
