<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom;

use Mekras\Atom\Document\Document;
use Mekras\Atom\Element\Element;
use Mekras\Atom\Extension\DocumentExtension;
use Mekras\Atom\Extension\ElementExtension;
use Mekras\Atom\Extension\Extension;
use Mekras\Atom\Extension\NamespaceExtension;

/**
 * Extension registry.
 *
 * @api
 *
 * @since 1.0
 */
class Extensions
{
    /**
     * Additional document types.
     *
     * @var DocumentExtension[][]|ElementExtension[][]|NamespaceExtension[][]
     */
    private $registry;

    /**
     * Extensions constructor.
     */
    public function __construct()
    {
        $this->registry = [
            DocumentExtension::class => [],
            ElementExtension::class => [],
            NamespaceExtension::class => []
        ];
    }

    /**
     * Register extension
     *
     * New extensions are placed in top of the list.
     *
     * @param Extension $extension
     *
     * @since 1.0
     */
    public function register(Extension $extension)
    {
        if ($extension instanceof DocumentExtension) {
            array_unshift($this->registry[DocumentExtension::class], $extension);
        }
        if ($extension instanceof ElementExtension) {
            array_unshift($this->registry[ElementExtension::class], $extension);
        }
        if ($extension instanceof NamespaceExtension) {
            $this->registry[NamespaceExtension::class][] = $extension;
        }
    }

    /**
     * Create Atom document from XML DOM document.
     *
     * @param \DOMDocument $document
     *
     * @return Document|null
     *
     * @ throws \InvalidArgumentException If $document root node has invalid name.
     *
     * @since 1.0
     */
    public function parseDocument(\DOMDocument $document)
    {
        foreach ($this->registry[DocumentExtension::class] as $extension) {
            $doc = $extension->parseDocument($this, $document);
            if ($doc) {
                return $doc;
            }
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
        foreach ($this->registry[ElementExtension::class] as $extension) {
            $node = $extension->parseElement($parent, $element);
            if ($node) {
                return $node;
            }
        }

        return null;
    }

    /**
     * Create new Atom document.
     *
     * @param string $name Element name.
     *
     * @return Document|null
     *
     * @since 1.0
     */
    public function createDocument($name)
    {
        foreach ($this->registry[DocumentExtension::class] as $extension) {
            $node = $extension->createDocument($this, $name);
            if ($node) {
                return $node;
            }
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
        foreach ($this->registry[ElementExtension::class] as $extension) {
            $node = $extension->createElement($parent, $name);
            if ($node) {
                return $node;
            }
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
        $result = [];
        foreach ($this->registry[NamespaceExtension::class] as $extension) {
            foreach ($extension->getNamespaces() as $prefix => $namespace) {
                $result[$prefix] = $namespace;
            }
        }

        return $result;
    }
}
