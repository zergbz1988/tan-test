<?php

namespace TanTest\Http\Response;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class JsonResponse
 * @package App\Http
 */
class HtmlResponse extends Response
{
    public function __construct(array $content = [], int $status = 200)
    {
        parent::__construct($content, $status, []);
        $this->headers->set('Content-Type', 'text/html');
    }

    /**
     * @param mixed $content
     * @return Response
     */
    public function setContent($content)
    {
        $xml = new \SimpleXMLElement('<dl/>');
        $this->arrayToXml($content, $xml);
        $dom = new \DOMDocument();
        $dom->loadXML($xml->asXML());
        return parent::setContent($dom->saveHTML());
    }

    /**
     * @param array $content
     * @param \SimpleXMLElement $xmlData
     */
    private function arrayToXml(array $content, \SimpleXMLElement &$xmlData)
    {
        foreach ($content as $key => $value) {
            if (is_numeric($key)) {
                $key = 'item-' . $key;
            }
            if (is_array($value)) {
                $xmlData->addChild('dt', $key);
                $dd = $xmlData->addChild('dd');
                $dl = $dd->addChild('dl');
                $this->arrayToXml($value, $dl);
            } else {
                $xmlData->addChild('dt', $key);
                $xmlData->addChild('dd', htmlspecialchars("$value"));
            }
        }
    }
}