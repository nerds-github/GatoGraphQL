<?php

declare(strict_types=1);

namespace PoPSitesWassup\EverythingElseMutations\SchemaServices\MutationResolverBridges;

use PoP\ComponentModel\MutationResolverBridges\AbstractComponentMutationResolverBridge;
use PoP\ComponentModel\MutationResolvers\MutationResolverInterface;
use PoP\ComponentModel\State\ApplicationState;
use PoPSitesWassup\EverythingElseMutations\SchemaServices\MutationResolvers\FileUploadPictureMutationResolver;

class FileUploadPictureMutationResolverBridge extends AbstractComponentMutationResolverBridge
{
    private ?FileUploadPictureMutationResolver $fileUploadPictureMutationResolver = null;
    
    final public function setFileUploadPictureMutationResolver(FileUploadPictureMutationResolver $fileUploadPictureMutationResolver): void
    {
        $this->fileUploadPictureMutationResolver = $fileUploadPictureMutationResolver;
    }
    final protected function getFileUploadPictureMutationResolver(): FileUploadPictureMutationResolver
    {
        return $this->fileUploadPictureMutationResolver ??= $this->instanceManager->getInstance(FileUploadPictureMutationResolver::class);
    }
    
    public function getMutationResolver(): MutationResolverInterface
    {
        return $this->getFileUploadPictureMutationResolver();
    }
    protected function onlyExecuteWhenDoingPost(): bool
    {
        return false;
    }

    public function getFormData(): array
    {
        $vars = ApplicationState::getVars();
        return [
            'user_id' => \PoP\Root\App::getState('current-user-id'),
        ];
    }
    /**
     * @return array<string, mixed>|null
     */
    public function executeMutation(array &$data_properties): ?array
    {
        parent::executeMutation($data_properties);
        return null;
    }
}
