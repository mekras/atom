<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Element\Meta;

use Mekras\Atom\Element\Element;
use Mekras\Atom\Element\Id;
use Mekras\Atom\Node;
use Mekras\Atom\NodeInterfaceTrait;

/**
 * Element has an ID.
 *
 * @since 1.0
 *
 * @link  https://tools.ietf.org/html/rfc4287#section-4.2.6
 */
trait HasId
{
    use NodeInterfaceTrait;

    /**
     * Return permanent, universally unique identifier for an entry or feed.
     *
     * @return Id
     *
     * @throws \Mekras\Atom\Exception\MalformedNodeException If there is no required element.
     *
     * @since 1.0
     */
    public function getId()
    {
        return $this->getCachedProperty(
            'id',
            function () {
                /** @var Element $this */
                return $this->getExtensions()->parseElement(
                    $this,
                    $this->query('atom:id', Node::SINGLE | Node::REQUIRED)
                );
            }
        );
    }

    /**
     * Set permanent, universally unique identifier for an entry or feed.
     *
     * @param string $id IRI
     *
     * @return Id
     *
     * @since 1.0
     */
    public function addId($id)
    {
        /** @var Id $element */
        $element = $this->addChild('atom:id', 'id');
        $element->setContent($id);

        return $element;
    }
}
