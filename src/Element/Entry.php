<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Element;

/**
 * Atom Entry.
 *
 * @since 1.0
 *
 * @link  https://tools.ietf.org/html/rfc4287#section-4.1.2
 */
class Entry extends Element
{
    use Meta\Author;
    use Meta\Categories;
    use Meta\Id;
    use Meta\SelfLink;
    use Meta\Title;
    use Meta\Updated;

    /**
     * Return the preferred URI for retrieving Atom Feed Documents representing this Atom feed.
     *
     * @return Content
     * @throws \InvalidArgumentException
     *
     * @link  https://tools.ietf.org/html/rfc4287#section-4.1.1
     *
     * @since 1.0
     */
    public function getContent()
    {
        return $this->getCachedProperty(
            'content',
            function () {
                $element = $this->query('atom:content', self::SINGLE);
                if (null === $element) {
                    $element = $this->getDomElement()->ownerDocument
                        ->createElementNS($this->ns(), 'content');
                    $this->getDomElement()->appendChild($element);
                }

                return $this->getExtensions()->parseElement($element);
            }
        );
    }

    /*
      & atomContributor*
      & atomLink*
      & atomPublished?
      & atomRights?
      & atomSource?
      & atomSummary?
      & extensionElement
     */

    /**
     * Return node name.
     *
     * @return string
     *
     * @since 1.0
     */
    protected function getNodeName()
    {
        return 'entry';
    }
}
