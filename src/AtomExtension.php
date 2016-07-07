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
use Mekras\Atom\Element\Element;
use Mekras\Atom\Element\Entry;
use Mekras\Atom\Element\Feed;
use Mekras\Atom\Element\Title;
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
     * Create Atom document from XML DOM document.
     *
     * @param Extensions   $extensions Extension registry.
     * @param \DOMDocument $document   Source document.
     *
     * @return Document|null
     *
     * @throws \InvalidArgumentException
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
                return new EntryDocument($extensions, $document);
                break;
            case 'feed':
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
     * @throws \InvalidArgumentException
     *
     * @since 1.0
     */
    public function createDocument(Extensions $extensions, $name)
    {
        switch ($name) {
            case 'atom:entry':
                return new EntryDocument($extensions);
                break;
            case 'atom:feed':
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
     * @throws \InvalidArgumentException
     *
     * @since 1.0
     */
    public function parseElement(Node $parent, \DOMElement $element)
    {
        if (Atom::NS !== $element->namespaceURI) {
            return null;
        }

        switch ($element->localName) {
            case 'author':
                return new Author($parent, $element);
                break;
            case 'category':
                return new Category($parent, $element);
                break;
            case 'content':
                return new Content($parent, $element);
                break;
            case 'entry':
                return new Entry($parent, $element);
                break;
            case 'feed':
                return new Feed($parent, $element);
                break;
            case 'title':
                return new Title($parent, $element);
                break;
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
     * @throws \InvalidArgumentException
     *
     * @since 1.0
     */
    public function createElement(Node $parent, $name)
    {
        switch ($name) {
            case 'atom:author':
                return new Author($parent);
                break;
            case 'atom:category':
                return new Category($parent);
                break;
            case 'atom:content':
                return new Content($parent);
                break;
            case 'atom:entry':
                return new Entry($parent);
                break;
            case 'atom:feed':
                return new Feed($parent);
                break;
            case 'atom:title':
                return new Title($parent);
                break;
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
