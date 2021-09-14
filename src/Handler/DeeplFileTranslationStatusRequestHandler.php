<?php

declare(strict_types=1);

namespace Scn\DeeplApiConnector\Handler;

use Scn\DeeplApiConnector\Model\FileSubmissionInterface;

final class DeeplFileTranslationStatusRequestHandler implements DeeplRequestHandlerInterface
{
    const API_ENDPOINT = 'https://api.deepl.com/v2/document/%s';

    private $authKey;

    private $fileSubmission;

    public function __construct(string $authKey, FileSubmissionInterface $fileSubmission)
    {
        $this->authKey = $authKey;
        $this->fileSubmission = $fileSubmission;
    }

    public function getMethod(): string
    {
        return DeeplRequestHandlerInterface::METHOD_GET;
    }

    public function getPath(): string
    {
        $apiEndpoint = getenv('DEEPL_FILE_TRANSLATION_STATUS_API_ENDPOINT') ?? static::API_ENDPOINT;
        return sprintf($apiEndpoint, $this->fileSubmission->getDocumentId());
    }

    public function getBody(): array
    {
        return [
            'form_params' => array_filter(
                [
                    'auth_key' => $this->authKey,
                    'document_key' => $this->fileSubmission->getDocumentKey(),
                ]
            ),
        ];
    }
}
