<?php
/**
 * Atom Protocol support
 *
 * @author  Михаил Красильников <m.krasilnikov@yandex.ru>
 * @license MIT
 */
namespace Mekras\Atom\Tests\Construct;

use Mekras\Atom\Construct\Person;

/**
 * Tests for Mekras\Atom\Construct\Person
 *
 * @covers Mekras\Atom\Construct\Person
 * @covers Mekras\Atom\Node
 */
class PersonTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     */
    public function testBasics()
    {
        $doc = new \DOMDocument();
        $doc->loadXML(
            '<?xml version="1.0" encoding="utf-8"?>' .
            '<person xmlns="http://www.w3.org/2005/Atom">' .
            '<name>Foo</name><email> foo@example.com</email><uri>http://example.com/ </uri>' .
            '</person>'
        );

        $person = new Person($doc->documentElement);
        static::assertEquals('Foo', $person->getName());
        static::assertEquals('Foo', (string) $person);
        static::assertEquals('foo@example.com', $person->getEmail());
        static::assertEquals('http://example.com/', $person->getUri());
    }
}
