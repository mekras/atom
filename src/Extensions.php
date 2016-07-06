<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom;

use Mekras\Atom\Document\Document;
use Mekras\Atom\Extension\DocumentExtension;
use Mekras\Atom\Extension\Extension;

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
     * @var DocumentExtension[][]
     */
    private $registry = [
        DocumentExtension::class => []
    ];

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
    }

    /**
     * Create Atom document from XML DOM document.
     *
     * @param \DOMDocument $document
     *
     * @return Document
     *
     * @throws \InvalidArgumentException
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
}
