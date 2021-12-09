<?php

declare(strict_types=1);

namespace PoPSchema\CustomPostMeta\TypeAPIs;

use InvalidArgumentException;
use PoPSchema\Meta\TypeAPIs\MetaTypeAPIInterface;

interface CustomPostMetaTypeAPIInterface extends MetaTypeAPIInterface
{
    /**
     * If the allow/denylist validation fails, throw an exception.
     * If the key is allowed but non-existent, return `null`.
     * Otherwise, return the value.
     *
     * @throws InvalidArgumentException
     */
    public function getCustomPostMeta(string | int $customPostID, string $key, bool $single = false): mixed;
}
