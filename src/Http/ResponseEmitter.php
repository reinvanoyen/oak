<?php

namespace Oak\Http;

use Oak\Contracts\Http\ResponseEmitterInterface;
use Psr\Http\Message\ResponseInterface;

class ResponseEmitter implements ResponseEmitterInterface
{
    /**
     * Emits a response to the browser
     *
     * @param ResponseInterface $response
     */
    public function emit(ResponseInterface $response)
    {
        if (! headers_sent()) {

            // Status
            header(sprintf(
                'HTTP/%s %s %s',
                $response->getProtocolVersion(),
                $response->getStatusCode(),
                $response->getReasonPhrase()
            ));

            // Headers
            foreach ($response->getHeaders() as $name => $values) {
                foreach ($values as $value) {
                    header(sprintf('%s: %s', $name, $value), false);
                }
            }
        }

        echo $response->getBody()->getContents();
    }
}