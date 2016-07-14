<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Element;

/**
 * "atom:feed" element.
 *
 * @since 1.0
 *
 * @link  https://tools.ietf.org/html/rfc4287#section-4.1.1
 */
class Feed extends Element
{
    use Meta\HasAuthors;
    use Meta\HasCategories;
    use Meta\HasContributors;
    use Meta\HasGenerator;
    use Meta\HasIcon;
    use Meta\HasId;
    use Meta\HasLinks;
    use Meta\HasLogo;
    use Meta\HasRights;
    use Meta\HasSubtitle;
    use Meta\HasTitle;
    use Meta\HasUpdated;

    /**
     * Return feed entries.
     *
     * @return Entry[]
     *
     * @since 1.0
     */
    public function getEntries()
    {
        return $this->getCachedProperty(
            'entries',
            function () {
                $result = [];
                /** @var \DOMNodeList $items */
                // No REQUIRED — no exception.
                $items = $this->query('atom:entry');
                foreach ($items as $item) {
                    $result[] = $this->getExtensions()->parseElement($this, $item);
                }

                return $result;
            }
        );
    }

    /**
     * Add new entry to feed.
     *
     * @return Entry
     *
     * @since 1.0
     */
    public function addEntry()
    {
        return $this->addChild('atom:entry', 'entries');
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
        return 'feed';
    }
}
