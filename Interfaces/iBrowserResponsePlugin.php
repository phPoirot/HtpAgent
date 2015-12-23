<?php
namespace Poirot\HttpAgent\Interfaces;

use Poirot\Http\Interfaces\Message\iHttpResponse;

interface iBrowserResponsePlugin
{
    /**
     * Manipulate Http Response
     *
     * @param iHttpResponse $response
     */
    function withHttpResponse(iHttpResponse $response);
}
