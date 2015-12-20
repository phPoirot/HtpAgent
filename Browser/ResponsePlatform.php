<?php
namespace Poirot\HttpAgent\Browser;

use Poirot\ApiClient\Response;
use Poirot\Http\Interfaces\iHeader;
use Poirot\Http\Message\HttpResponse;
use Poirot\Http\Plugins\Response\Status as ResposeStatusPlugin;
use Poirot\Stream\Interfaces\iStreamable;

class ResponsePlatform extends Response
{
    /**
     * Construct
     *
     * @param HttpResponse $response
     */
    function __construct(HttpResponse $response)
    {
        $this->origin = $response;

        $this->setRawBody($response->getBody());

        /** @var iHeader $h */
        foreach($response->getHeaders() as $h)
            $this->meta()->set($h->label(), $h);

        $statusPlugin = new ResposeStatusPlugin(['message_object' => $response]);
        if (!$statusPlugin->isSuccess())
            $this->setException(new \RuntimeException($response->getStatReason(), $response->getStatCode()));
    }


    // ...

    /**
     * Set Response Origin Content
     *
     * @param iStreamable|string $content Content Body
     *
     * @return $this
     */
    function setRawBody($content)
    {
        $this->origin->setBody($content);
        return $this;
    }

    /**
     * Get Response Origin Body Content
     *
     * @return iStreamable|string
     */
    function getRawBody()
    {
        return $this->origin->getBody();
    }


    // ...

    /**
     * @override ide completion
     * @param callable|null $proc
     * @return HttpResponse
     */
    function getResult(callable $proc = null)
    {
        return parent::getResult($proc);
    }
}