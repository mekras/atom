<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Extension;

use Mekras\Atom\Document\Document;
use Mekras\Atom\Extensions;

/**
 * Document extension interface.
 *
 * @since 1.0
 */
interface DocumentExtension extends Extension
{
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
    public function parseDocument(Extensions $extensions, \DOMDocument $document);

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
    public function createDocument(Extensions $extensions, $name);
}
