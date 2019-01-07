<?php

namespace TanTest\Http\Request;

use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class JsonRequest
 * @package TanTest\Http\Request
 */
class JsonRequest extends Request
{
    /**
     * JsonRequest constructor.
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
        if ($contentType !== 'application/json') {
            throw new BadRequestHttpException('Request content-type header must be \'application/json\'');
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
        $json = json_decode($content, true);
        if (!is_null($content) && null === $json) {
            throw new BadRequestHttpException('Request content must be correct JSON');
        }
        $query = new ParameterBag();
        $query->add($json);

        return $query;
    }
}