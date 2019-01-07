<?php

namespace TanTest\Http\Request;

use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Throwable;

/**
 * Class XmlRequest
 * @package TanTest\Http\Request
 */
class XmlRequest extends Request
{
    /**
     * XmlRequest constructor.
     * @param array $query
     * @param array $request
     * @param array $attributes
     * @param array $cookies
     * @param array $files
     * @param array $server
     * @param null $content
     */
    public function __construct(array $query = array(), array $request = array(), array $attributes = array(), array $cookies = array(), array $files = array(), array $server = array(), $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);

        $contentType = $this->headers->get('content-type');
        if ($contentType !== 'application/xml') {
            throw new BadRequestHttpException('Request content-type header must be \'application/xml\'');
        }
        $content = $this->getContent();
        $this->query = $this->parseContent($content);
    }

    /**
     * @param string $content
     * @return ParameterBag
     */
    protected function parseContent(string $content): ParameterBag
    {
        try {
            $xmlElement = new \SimpleXMLElement($content);
        } catch (Throwable $e) {
            throw new BadRequestHttpException('Request content must be correct XML');
        }
        $query = new ParameterBag();
        $query->add((array)$xmlElement);

        return $query;
    }
}