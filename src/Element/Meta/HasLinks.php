<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Element\Meta;

use Mekras\Atom\Element\Element;
use Mekras\Atom\Element\Link;
use Mekras\Atom\NodeInterfaceTrait;

/**
 * Element has a links.
 *
 * @since 1.0
 *
 * @link  https://tools.ietf.org/html/rfc4287#section-4.2.7
 */
trait HasLinks
{
    use NodeInterfaceTrait;

    /**
     * Return links.
     *
     * @param string|null $relation If specified, return only links with this relation type.
     *
     * @return Link[]
     *
     * @since 1.0
     */
    public function getLinks($relation = null)
    {
        $links = $this->getAllLinks();
        if (null === $relation) {
            return $links;
        }
        foreach ($links as $key => $link) {
            if ($link->getRelation() !== $relation) {
                unset($links[$key]);
            }
        }

        return $links;
    }

    /**
     * Add new link
     *
     * @param string      $uri      Link IRI.
     * @param string|null $relation Optional relation type.
     *
     * @return Link
     *
     * @since 1.0
     */
    public function addLink($uri, $relation = null)
    {
        /** @var Link $link */
        $link = $this->addChild('atom:link', 'links');
        $link->setUri($uri);
        if ($relation) {
            $link->setRelation($relation);
        }

        return $link;
    }

    /**
     * Return single link.
     *
     * @param string $relation Return first link with this relation type.
     *
     * @return Link|null
     *
     * @since 1.0
     */
    public function getLink($relation)
    {
        $links = $this->getAllLinks();
        foreach ($links as $link) {
            if ($link->getRelation() === $relation) {
                return $link;
            }
        }

        return null;
    }

    /**
     * Return all element links.
     *
     * @return Link[]
     */
    private function getAllLinks()
    {
        return $this->getCachedProperty(
            'links',
            function () {
                $result = [];
                // No REQUIRED — no exception.
                $nodes = $this->query('atom:link');
                foreach ($nodes as $node) {
                    /** @var Element $this */
                    $result[] = $this->getExtensions()->parseElement($this, $node);
                }

                return $result;
            }
        );
    }
}
