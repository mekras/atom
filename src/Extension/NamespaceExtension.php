<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Extension;

/**
 * Namespace extension interface.
 *
 * @since 1.0
 */
interface NamespaceExtension extends Extension
{
    /**
     * Return additional XML namespaces.
     *
     * @return string[] prefix => namespace.
     *
     * @since 1.0
     */
    public function getNamespaces();
}
