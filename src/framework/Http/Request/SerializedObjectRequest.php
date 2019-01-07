<?php

namespace TanTest\Http\Request;

use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;
use Throwable;

/**
 * Class SerializedObjectRequest
 * @package TanTest\Http\Request
 */
class SerializedObjectRequest extends Request
{
    /**
     * SerializedObjectRequest constructor.
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
        if ($contentType !== 'text/plain') {
            throw new BadRequestHttpException('Request content-type header must be \'text/plain\'');
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
            $object = unserialize($content);
        } catch (Throwable $e) {
            throw new BadRequestHttpException('Request content must be correct Serialized Object');
        }
        $query = new ParameterBag();
        $query->add($object);
        return $query;
    }
}