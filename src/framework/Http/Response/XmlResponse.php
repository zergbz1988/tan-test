<?php

namespace TanTest\Http\Response;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class JsonResponse
 * @package App\Http
 */
class XmlResponse extends Response
{
    public function __construct(array $content = [], int $status = 200)
    {
        parent::__construct($content, $status, []);
        $this->headers->set('Content-Type', 'application/xml');
    }

    /**
     * @param mixed $content
     * @return Response
     */
    public function setContent($content)
    {
        $xml = new \SimpleXMLElement('<Response/>');
        $this->arrayToXml($content, $xml);
        return parent::setContent($xml->asXML());
    }

    /**
     * @param array $content
     * @param \SimpleXMLElement $xmlData
     */
    private function arrayToXml(array $content, \SimpleXMLElement &$xmlData)
    {
        foreach ($content as $key => $value) {
            if (is_numeric($key)) {
                $key = 'item_' . $key;
            }
            if (is_array($value)) {
                $subNode = $xmlData->addChild(ucfirst($key));
                $this->arrayToXml($value, $subNode);
            } else {
                $xmlData->addChild(ucfirst($key), htmlspecialchars("$value"));
            }
        }
    }
}