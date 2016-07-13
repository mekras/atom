<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Element;

/**
 * "atom:entry" element.
 *
 * @since 1.0
 *
 * @link  https://tools.ietf.org/html/rfc4287#section-4.1.2
 */
class Entry extends Element
{
    use Meta\HasAuthors;
    use Meta\HasCategories;
    use Meta\HasContributors;
    use Meta\HasId;
    use Meta\HasLinks;
    use Meta\HasPublished;
    use Meta\HasRights;
    use Meta\HasSummary;
    use Meta\HasTitle;
    use Meta\HasUpdated;

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
                    return $this->getExtensions()->createElement($this, 'atom:content');
                }

                return $this->getExtensions()->parseElement($this, $element);
            }
        );
    }

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
