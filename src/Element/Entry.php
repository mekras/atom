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
    use Meta\HasContent;
    use Meta\HasContributors;
    use Meta\HasId;
    use Meta\HasLinks;
    use Meta\HasPublished;
    use Meta\HasRights;
    use Meta\HasSummary;
    use Meta\HasTitle;
    use Meta\HasUpdated;

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
