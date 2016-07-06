<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom;

use Mekras\Atom\Document\Document;
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
     * @var Extension[]
     */
    private $registry = [];

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
        array_unshift($this->registry, $extension);
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
        foreach ($this->registry as $extension) {
            $doc = $extension->parseDocument($document);
            if ($doc) {
                return $doc;
            }
        }

        return null;
    }
}
