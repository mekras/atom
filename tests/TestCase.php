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
     * Return new fake Node instance.
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|Node
     */
    protected function createFakeNode()
    {
        $doc = $this->createDocument();

        $node = $this->getMockBuilder(Node::class)->disableOriginalConstructor()
            ->setMethods(['getDomElement', 'getExtensions'])->getMock();
        $node->expects(static::any())->method('getDomElement')
            ->willReturn($doc->documentElement);
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
    protected function loadFixture($path)
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
        $document->loadXML(
            '<?xml version="1.0" encoding="utf-8"?>' .
            '<' . $rootNodeName . ' xmlns="http://www.w3.org/2005/Atom" ' .
            'xmlns:xhtml="' . Atom::XHTML . '">' .
            $contents .
            '</' . $rootNodeName . '>'
        );

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
