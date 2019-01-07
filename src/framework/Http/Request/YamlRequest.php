<?php

namespace TanTest\Http\Request;

use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;
use Throwable;

/**
 * Class YamlRequest
 * @package TanTest\Http\Request
 */
class YamlRequest extends Request
{
    /**
     * YamlRequest constructor.
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
        if ($contentType !== 'application/x-yaml') {
            throw new BadRequestHttpException('Request content-type header must be \'application/x-yaml\'');
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
            $yaml = Yaml::parse($content);
        } catch (ParseException $e) {
            throw new BadRequestHttpException('Request content must be correct YAML');
        }
        $query = new ParameterBag();
        $query->add($yaml);
        return $query;
    }
}