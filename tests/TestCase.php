<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Tests;

use Mekras\Atom\Atom;

/**
 * Base test case.
 */
abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * Create new empty document
     *
     * @param string $rootNodeName
     *
     * @return \DOMDocument
     */
    protected function createDocument($rootNodeName = 'doc')
    {
        $document = new \DOMDocument('1.0', 'utf-8');
        $element = $document->createElementNS(Atom::NS, $rootNodeName);
        $document->appendChild($element);

        return $document;
    }

    /**
     * Create new foreign DOM element
     *
     * @param string      $name
     * @param string|null $ns
     * @param string|null $content
     *
     * @return \DOMElement
     */
    protected function createElement($name, $ns = null, $content = null)
    {
        $doc = new \DOMDocument('1.0', 'utf-8');
        if ($ns) {
            return $doc->createElementNS($ns, $name, $content);
        }

        return $doc->createElement($name, $content);
    }
}
