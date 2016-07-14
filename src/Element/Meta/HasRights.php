<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Element\Meta;

use Mekras\Atom\Element\Element;
use Mekras\Atom\Element\Rights;
use Mekras\Atom\Node;
use Mekras\Atom\NodeInterfaceTrait;

/**
 * Element has a rights info.
 *
 * @since 1.0
 *
 * @link  https://tools.ietf.org/html/rfc4287#section-4.2.10
 */
trait HasRights
{
    use NodeInterfaceTrait;

    /**
     * Return rights.
     *
     * @return Rights|null
     *
     * @since 1.0
     */
    public function getRights()
    {
        return $this->getCachedProperty(
            'rights',
            function () {
                // No REQUIRED — no exception.
                $element = $this->query('atom:rights', Node::SINGLE);

                /** @var Element $this */
                return $element ? $this->getExtensions()->parseElement($this, $element) : null;
            }
        );
    }

    /**
     * Add rights.
     *
     * @param string $value
     * @param string $type
     *
     * @return Rights
     *
     * @since 1.0
     */
    public function addRights($value, $type = 'text')
    {
        /** @var Rights $element */
        $element = $this->addChild('atom:rights', 'rights');
        $element->setContent($value, $type);

        return $element;
    }
}
