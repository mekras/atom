# [Atom Syndication Format](https://tools.ietf.org/html/rfc4287) support library

[![Latest Stable Version](https://poser.pugx.org/mekras/atom/v/stable.png)](https://packagist.org/packages/mekras/atom)
[![License](https://poser.pugx.org/mekras/atom/license.png)](https://packagist.org/packages/mekras/atom)
[![Build Status](https://travis-ci.org/mekras/atom.svg?branch=master)](https://travis-ci.org/mekras/atom)
[![Coverage Status](https://coveralls.io/repos/mekras/atom/badge.svg?branch=master&service=github)](https://coveralls.io/github/mekras/atom?branch=master)

## Purpose

This library is designed to work with the [Atom](https://tools.ietf.org/html/rfc4287) documents in
an object-oriented style. It does not contain the functionality to download or display documents.

## Parsing documents

[DocumentFactory](src/DocumentFactory.php) class is responsible for parsing documents. There are two
methods:

- `parseDocument` — takes an instance of the [DOMDocument](http://php.net/domdocument) as argument
and return one of the [Document](src/Document/Document.php) subclasses;
- `parseXML` — takes string with XML as argument then uses `parseDocument`.

```php
use Mekras\Atom\DocumentFactory;
use Mekras\Atom\Document\EntryDocument;
use Mekras\Atom\Document\FeedDocument;
use Mekras\Atom\Exception\AtomException;

$factory = new DocumentFactory;

$xml = file_get_contents('http://example.com/atom');
try {
    $document = $factory->parseXML($xml);
} catch (AtomException $e) {
    die($e->getMessage());
}

if ($document instanceof FeedDocument) {
    $feed = $document->getFeed();
    //...
} elseif ($document instanceof EntryDocument) {
    $entry = $document->getEntry();
    //...
}

```

## Creating Entry documents

```php
use Mekras\Atom\Document\EntryDocument;

$document = new EntryDocument();
$entry = $document->getEntry();
$entry->setId('urn:foo:entry:0001');
$entry->setTitle('Entry Title');
$entry->addAuthor('Author 1', 'foo@example.com');
$entry->addAuthor('Author 2', null, 'http://example.com/');
$entry->getContent()->setValue('<h1>Entry content</h1>', 'html');
$entry->addCategory('tag1')->setLabel('Tag label')->setScheme('http://example.com/scheme');

echo (string) $document;
```
## Creating Feed documents

```php
use Mekras\Atom\Document\FeedDocument;

$document = new FeedDocument();
$feed = $document->getFeed();
$feed->setId('urn:foo:feed:0001');
$feed->setTitle('Feed Title');
$feed->addAuthor('Feed Author')->setEmail('foo@example.com')->setUri('http://example.com/');
$feed->addCategory('tag1')->setScheme('http://example.com/scheme')->setLabel('TAG 1');

$entry = $feed->addEntry();
$entry->setId('urn:foo:entry:0001');
$entry->setTitle('Entry Title');
//...

echo (string) $document;
```

## Extending

Atom parsing can be extended via `DocumentFactory::registerDocumentType()`.

**FooDocuments.php**

```php
use Mekras\Atom\Document\Document;
use Mekras\Atom\Extension\DocumentType;

class FooDocuments implements DocumentType
{
    public function createDocument(\DOMDocument $document)
    {
        if ('Foo NS' === $document->documentElement->namespaceURI) {
            switch ($document->documentElement->localName) {
                case 'foo':
                    return new FooDocument($document);
            }
        }

        return null;
    }
}
```

**main.php**

```php
use Mekras\Atom\DocumentFactory;

$factory = new DocumentFactory;
$factory->registerDocumentType(new FooDocuments());
//...
```