<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Element\Meta;

use Mekras\Atom\Element\Element;
use Mekras\Atom\Element\Logo;
use Mekras\Atom\Node;
use Mekras\Atom\NodeInterfaceTrait;

/**
 * Element has a logo.
 *
 * @since 1.0
 *
 * @link  https://tools.ietf.org/html/rfc4287#section-4.2.8
 */
trait HasLogo
{
    use NodeInterfaceTrait;

    /**
     * Return logo.
     *
     * @return Logo|null
     *
     * @since 1.0
     */
    public function getLogo()
    {
        return $this->getCachedProperty(
            'logo',
            function () {
                // No REQUIRED — no exception.
                $element = $this->query('atom:logo', Node::SINGLE);

                /** @var Element $this */
                return $element ? $this->getExtensions()->parseElement($this, $element) : null;
            }
        );
    }

    /**
     * Add logo.
     *
     * @param string $iri Logo IRI.
     *
     * @return Logo
     *
     * @since 1.0
     */
    public function addLogo($iri)
    {
        /** @var Logo $element */
        $element = $this->addChild('atom:logo', 'logo');
        $element->setUri($iri);

        return $element;
    }
}
