# Creating documents

With `DocumentFactory::createDocument()` — you can create new documents from scratch. Supported
document types are:

- `atom:entry` — entry document;
- `atom:feed` — feed document.

**Please note**, that there is no document validation.

Common steps are:

1. Create document factory.
2. Create empty document via `DocumentFactory::createDocument` method.
3. Get empty entry or feed via `EntryDocument::getEntry` or `FeedDocument::getFeed` respectively.
4. Add necessary elements via `add...` methods.

## Creating Entry documents

```php
use Mekras\Atom\DocumentFactory;

$factory = new DocumentFactory;

$document = $factory->createDocument('atom::entry');

$entry = $document->getEntry();
$entry->addId('urn:entry:0001');
$entry->addAuthor('Author ')
    ->setEmail('foo@example.com')
    ->setUri('http://example.com/');
$entry->addCategory('tag')
    ->setLabel('Tag label')
    ->setScheme('http://example.com/scheme');
$entry->addLink('http://example.com/1.html', 'alternate')
    ->setType('text/html')
    ->setLanguage('ru');
$entry->addPublished(new \DateTime('2003-12-13 18:30:03'));
$entry->addUpdated(new \DateTime('2003-12-13 18:30:03'));
$entry->addTitle('Entry Title');
$entry->addContent('<h1>Entry content</h1>', 'html');

echo (string) $document;
```
## Creating Feed documents

```php
use Mekras\Atom\DocumentFactory;

$factory = new DocumentFactory;

$document = $factory->createDocument('atom:feed');

$feed = $document->getFeed();
$feed->addAuthor('Feed Author')
    ->setEmail('foo@example.com')
    ->setUri('http://example.com/foo');
$feed->addCategory('tag1')
    ->setScheme('http://example.com/scheme')
    ->setLabel('TAG 1');
$feed->addContributor('Contributor')
    ->setEmail('bar@example.com')
    ->setUri('http://example.com/bar');
$feed->addGenerator('Generator')
    ->setUri('http://example.com/generator')
    ->setVersion('1.0');
$feed->addIcon('http://example.com/feed-icon.png');
$feed->addId('urn:feed:1');
$feed->addLink('http://example.com/feed', 'self')->setType('text/xml');
$feed->addLink('http://example.com/feed/')->setType('text/html');
$feed->addLogo('http://example.com/feed-logo.png');
$feed->addRights('© Copyright by Foo');
$feed->addSubtitle('Sub title');
$feed->addTitle('Feed Title');
$feed->addUpdated(new \DateTime('2003-12-13 18:30:02', new \DateTimeZone('+1:00')));

$feed->addEntry()->addId('urn:entry:3');
$feed->addEntry()->addId('urn:entry:2');
$feed->addEntry()->addId('urn:entry:1');

echo (string) $document;
```

## Additional notes

### link[rel=self]

You not need to manually set type for links with "self" relation. Following lines are equivalent:

```php
$feed->addLink('http://example.com/atom', 'self')->setType('application/atom+xml');
$feed->addLink('http://example.com/atom', 'self');
```
