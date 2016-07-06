<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom;

/**
 * XML to Atom Document converter.
 *
 * @since 1.0
 *
 * @api
 * @link  https://tools.ietf.org/html/rfc4287
 */
class Atom
{
    /**
     * Atom namespace.
     *
     * @since 1.0
     */
    const NS = 'http://www.w3.org/2005/Atom';

    /**
     * XHTML namespace.
     *
     * @since 1.0
     */
    const XHTML = 'http://www.w3.org/1999/xhtml';

    /**
     * XML namespaces.
     *
     * @since 1.0
     */
    const XMLNS = 'http://www.w3.org/2000/xmlns/';
}
