<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Element\Meta;

use Mekras\Atom\Element\Element;
use Mekras\Atom\Element\Icon;
use Mekras\Atom\Node;
use Mekras\Atom\NodeInterfaceTrait;

/**
 * Element has an icon.
 *
 * @since 1.0
 *
 * @link  https://tools.ietf.org/html/rfc4287#section-4.2.5
 */
trait HasIcon
{
    use NodeInterfaceTrait;

    /**
     * Return icon.
     *
     * @return Icon|null
     *
     * @since 1.0
     */
    public function getIcon()
    {
        return $this->getCachedProperty(
            'icon',
            function () {
                // No REQUIRED — no exception.
                $element = $this->query('atom:icon', Node::SINGLE);

                /** @var Element $this */
                return $element ? $this->getExtensions()->parseElement($this, $element) : null;
            }
        );
    }

    /**
     * Add icon.
     *
     * @param string $iri Icon IRI.
     *
     * @return Icon
     *
     * @since 1.0
     */
    public function addIcon($iri)
    {
        /** @var Icon $element */
        $element = $this->addChild('atom:icon', 'icon');
        $element->setUri($iri);

        return $element;
    }
}
