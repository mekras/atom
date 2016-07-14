<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Element\Meta;

use Mekras\Atom\Element\Element;
use Mekras\Atom\Element\Title;
use Mekras\Atom\Node;
use Mekras\Atom\NodeInterfaceTrait;

/**
 * Element has a title.
 *
 * @since 1.0
 *
 * @link  https://tools.ietf.org/html/rfc4287#section-4.2.14
 */
trait HasTitle
{
    use NodeInterfaceTrait;

    /**
     * Return title.
     *
     * @return Title
     *
     * @throws \Mekras\Atom\Exception\MalformedNodeException If there is no required element.
     *
     * @since 1.0
     */
    public function getTitle()
    {
        return $this->getCachedProperty(
            'title',
            function () {
                $element = $this->query('atom:title', Node::SINGLE | Node::REQUIRED);

                /** @var Element $this */
                return $this->getExtensions()->parseElement($this, $element);
            }
        );
    }

    /**
     * Add title.
     *
     * @param string $value
     * @param string $type
     *
     * @return Title
     *
     * @since 1.0
     */
    public function addTitle($value, $type = 'text')
    {
        /** @var Title $element */
        $element = $this->addChild('atom:title', 'title');
        $element->setContent($value, $type);

        return $element;
    }
}
