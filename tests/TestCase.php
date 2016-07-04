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
            '<' . $rootNodeName . ' xmlns="http://www.w3.org/2005/Atom">' .
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
