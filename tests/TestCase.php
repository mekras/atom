<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Tests;

use Mekras\Atom\Atom;
use Mekras\Atom\AtomExtension;
use Mekras\Atom\Extensions;
use Mekras\Atom\Node;

/**
 * NodeInterfaceTrait test case.
 */
abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * Return new fake Node instance.
     *
     * @param \DOMDocument|null $document
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|Node
     */
    protected function createFakeNode(\DOMDocument $document = null)
    {
        if (null === $document) {
            $document = $this->createDocument();
        }

        $node = $this->getMockBuilder(Node::class)->disableOriginalConstructor()
            ->setMethods(['getDomElement', 'getExtensions'])->getMock();
        $node->expects(static::any())->method('getDomElement')
            ->willReturn($document->documentElement);
        $node->expects(static::any())->method('getExtensions')
            ->willReturn($this->createExtensions());

        return $node;
    }

    /**
     * Locate fixture and return absolute path.
     *
     * @param string $path Path to fixture relative to tests root folder.
     *
     * @return \DOMDocument
     */
    protected function locateFixture($path)
    {
        $filename = __DIR__ . '/fixtures/' . ltrim($path, '/');
        if (!file_exists($filename)) {
            static::fail(sprintf('Fixture file "%s" not found', $filename));
        }

        return $filename;
    }

    /**
     * Load fixture and return DOM document.
     *
     * @param string $path Path to fixture relative to tests root folder.
     *
     * @return \DOMDocument
     */
    protected function loadXML($path)
    {
        $document = new \DOMDocument('1.0', 'utf-8');
        $document->load($this->locateFixture($path));

        return $document;
    }

    /**
     * Create new empty document
     *
     * @param string $contents     XML
     * @param string $rootNodeName default "doc"
     *
     * @return \DOMDocument
     */
    protected function createDocument($contents = '', $rootNodeName = 'doc')
    {
        $document = new \DOMDocument();

        $prefix = explode(':', $rootNodeName);
        $prefix = count($prefix) === 2 ? ':' . $prefix[0] : '';

        $xml = '<?xml version="1.0" encoding="utf-8"?>' .
            '<' . $rootNodeName . ' xmlns' . $prefix . '="' . Atom::NS . '" ' .
            'xmlns:xhtml="' . Atom::XHTML . '">' .
            $contents .
            '</' . $rootNodeName . '>';

        $document->loadXML($xml);

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
        $document = $this->createDocument();
        if ($ns) {
            return $document->createElementNS($ns, $name, $content);
        }

        return $document->createElement($name, $content);
    }

    /**
     * Create and fill Extensions instance.
     *
     * @return Extensions
     */
    protected function createExtensions()
    {
        $extensions = new Extensions();
        $extensions->register(new AtomExtension());

        return $extensions;
    }

    /**
     * Return node XML.
     *
     * @param Node $node
     *
     * @return string
     */
    protected function getXML(Node $node)
    {
        return $node->getDomElement()->ownerDocument->saveXML($node->getDomElement());
    }
}
