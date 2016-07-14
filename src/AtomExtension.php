<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom;

use Mekras\Atom\Document\Document;
use Mekras\Atom\Document\EntryDocument;
use Mekras\Atom\Document\FeedDocument;
use Mekras\Atom\Element\Author;
use Mekras\Atom\Element\Category;
use Mekras\Atom\Element\Content;
use Mekras\Atom\Element\Contributor;
use Mekras\Atom\Element\Element;
use Mekras\Atom\Element\Entry;
use Mekras\Atom\Element\Feed;
use Mekras\Atom\Element\Generator;
use Mekras\Atom\Element\Icon;
use Mekras\Atom\Element\Id;
use Mekras\Atom\Element\Link;
use Mekras\Atom\Element\Logo;
use Mekras\Atom\Element\Published;
use Mekras\Atom\Element\Rights;
use Mekras\Atom\Element\Subtitle;
use Mekras\Atom\Element\Summary;
use Mekras\Atom\Element\Title;
use Mekras\Atom\Element\Updated;
use Mekras\Atom\Extension\DocumentExtension;
use Mekras\Atom\Extension\ElementExtension;
use Mekras\Atom\Extension\NamespaceExtension;

/**
 * Atom "extension".
 *
 * @since 1.0
 */
class AtomExtension implements DocumentExtension, ElementExtension, NamespaceExtension
{
    /**
     * Element name to class map.
     *
     * @var string[]
     */
    private $elementMap;

    /**
     * AtomExtension constructor.
     *
     * @since 1.0
     */
    public function __construct()
    {
        $this->elementMap = [
            'atom:author' => Author::class,
            'atom:category' => Category::class,
            'atom:content' => Content::class,
            'atom:contributor' => Contributor::class,
            'atom:entry' => Entry::class,
            'atom:feed' => Feed::class,
            'atom:generator' => Generator::class,
            'atom:icon' => Icon::class,
            'atom:id' => Id::class,
            'atom:link' => Link::class,
            'atom:logo' => Logo::class,
            'atom:published' => Published::class,
            'atom:rights' => Rights::class,
            'atom:subtitle' => Subtitle::class,
            'atom:summary' => Summary::class,
            'atom:title' => Title::class,
            'atom:updated' => Updated::class
        ];
    }

    /**
     * Create Atom document from XML DOM document.
     *
     * @param Extensions   $extensions Extension registry.
     * @param \DOMDocument $document   Source document.
     *
     * @return Document|null
     *
     * @since 1.0
     */
    public function parseDocument(Extensions $extensions, \DOMDocument $document)
    {
        if (Atom::NS !== $document->documentElement->namespaceURI) {
            return null;
        }

        switch ($document->documentElement->localName) {
            case 'entry':
                // Node name already checked
                return new EntryDocument($extensions, $document);
                break;
            case 'feed':
                // Node name already checked
                return new FeedDocument($extensions, $document);
                break;
        }

        return null;
    }

    /**
     * Create new Atom document.
     *
     * @param Extensions $extensions Extension registry.
     * @param string     $name       Element name.
     *
     * @return Document|null
     *
     * @since 1.0
     */
    public function createDocument(Extensions $extensions, $name)
    {
        switch ($name) {
            case 'atom:entry':
                // No document — no exception.
                return new EntryDocument($extensions);
                break;
            case 'atom:feed':
                // No document — no exception.
                return new FeedDocument($extensions);
                break;
        }

        return null;
    }

    /**
     * Create Atom node from XML DOM element.
     *
     * @param Node        $parent  Parent node.
     * @param \DOMElement $element DOM element.
     *
     * @return Element|null
     *
     * @since 1.0
     */
    public function parseElement(Node $parent, \DOMElement $element)
    {
        if (Atom::NS !== $element->namespaceURI) {
            return null;
        }

        $name = 'atom:' . $element->localName;
        if (array_key_exists($name, $this->elementMap)) {
            $class = $this->elementMap[$name];

            return new $class($parent, $element);
        }

        return null;
    }

    /**
     * Create new Atom node.
     *
     * @param Node   $parent Parent node.
     * @param string $name   Element name.
     *
     * @return Element|null
     *
     * @since 1.0
     */
    public function createElement(Node $parent, $name)
    {
        if (array_key_exists($name, $this->elementMap)) {
            $class = $this->elementMap[$name];

            return new $class($parent);
        }

        return null;
    }

    /**
     * Return additional XML namespaces.
     *
     * @return string[] prefix => namespace.
     *
     * @since 1.0
     */
    public function getNamespaces()
    {
        return [
            'atom' => Atom::NS,
            'xhtml' => Atom::XHTML
        ];
    }
}
