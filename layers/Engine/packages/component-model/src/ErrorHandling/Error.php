<?php

declare(strict_types=1);

namespace PoP\ComponentModel\ErrorHandling;

use PoP\Translation\Facades\TranslationAPIFacade;

class Error
{
    protected string $code;
    protected ?string $message;
    /**
     * @var array<string, mixed>
     */
    protected array $data;
    /**
     * @var Error[]
     */
    protected array $nestedErrors;
    
    public function __construct(
        string $code,
        ?string $message = null,
        ?array $data = null,
        ?array $nestedErrors = null
    ) {
        $this->code = $code;
        $this->message = $message;
        $this->data = $data ?? [];
        $this->nestedErrors = $nestedErrors ?? [];
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function getMessageWithCode(): string
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        return $this->message !== null ?
            sprintf(
                $translationAPI->__('[%1$s] %2$s', 'component-model'),
                $this->code,
                $this->message
            )
            : sprintf(
                $translationAPI->__('Error code: %s', 'component-model'),
                $this->code
            );
    }

    /**
     * @return array<string, mixed>
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @return Error[]
     */
    public function getNestedErrors(): array
    {
        return $this->nestedErrors;
    }

    public function addData($data, $code = null)
    {
        if (!$code) {
            $code = $this->getErrorCode();
        }

        $this->error_data[$code] = $data;
    }

    public function remove($code)
    {
        unset($this->errors[$code]);
        unset($this->error_data[$code]);
    }
}
