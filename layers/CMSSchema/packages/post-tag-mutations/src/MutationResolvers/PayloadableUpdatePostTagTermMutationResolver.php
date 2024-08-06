<?php

declare(strict_types=1);

namespace PoPCMSSchema\PostTagMutations\MutationResolvers;

use PoPCMSSchema\TagMutations\MutationResolvers\PayloadableUpdateTagTermMutationResolverTrait;

class PayloadableUpdatePostTagTermMutationResolver extends AbstractMutatePostTagTermMutationResolver
{
    use PayloadableUpdateTagTermMutationResolverTrait;
}
