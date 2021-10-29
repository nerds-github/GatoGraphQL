<?php

declare(strict_types=1);

namespace GraphQLAPI\GraphQLAPI\Services\EndpointExecuters;

use GraphQLAPI\GraphQLAPI\Constants\RequestParams;
use GraphQLAPI\GraphQLAPI\ModuleResolvers\ClientFunctionalityModuleResolver;
use GraphQLAPI\GraphQLAPI\Services\Clients\CustomEndpointVoyagerClient;
use GraphQLAPI\GraphQLAPI\Services\EndpointAnnotators\ClientEndpointAnnotatorInterface;
use GraphQLAPI\GraphQLAPI\Services\EndpointAnnotators\VoyagerClientEndpointAnnotator;
use GraphQLByPoP\GraphQLClientsForWP\Clients\AbstractClient;
use Symfony\Contracts\Service\Attribute\Required;

class VoyagerClientEndpointExecuter extends AbstractClientEndpointExecuter implements CustomEndpointExecuterServiceTagInterface
{
    protected ?CustomEndpointVoyagerClient $customEndpointVoyagerClient = null;
    protected ?VoyagerClientEndpointAnnotator $voyagerClientEndpointExecuter = null;

    #[Required]
    final public function autowireVoyagerClientEndpointExecuter(
        CustomEndpointVoyagerClient $customEndpointVoyagerClient,
        VoyagerClientEndpointAnnotator $voyagerClientEndpointExecuter,
    ): void {
        $this->customEndpointVoyagerClient = $customEndpointVoyagerClient;
        $this->voyagerClientEndpointExecuter = $voyagerClientEndpointExecuter;
    }

    public function getEnablingModule(): ?string
    {
        return ClientFunctionalityModuleResolver::INTERACTIVE_SCHEMA_FOR_CUSTOM_ENDPOINTS;
    }

    protected function getView(): string
    {
        return RequestParams::VIEW_SCHEMA;
    }

    protected function getClient(): AbstractClient
    {
        return $this->getCustomEndpointVoyagerClient();
    }

    protected function getClientEndpointAnnotator(): ClientEndpointAnnotatorInterface
    {
        return $this->getVoyagerClientEndpointExecuter();
    }
}
