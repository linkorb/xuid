XUID Library
============

XUIDs are URL-friendly compressed UUIDs

## Why XUIDs?

A UUID v4 is a great choice as a primary key for your database tables.

But, they are quite long to use in URLs and databases : 32 alphanumeric characters and four hyphens

A XUID is a UUID, converted into a 128-bit value, converted into a base64 string, then converted into url-safe base64.

This gives you a 24 character string, safe to use in URLs.

It also safely decodes into a full UUID string again.

## Benefits

* Takes less space in database fields
* Shorter URLs
* Un-guessable primary keys in URLs

## Usage

```php
use Xuid\Xuid;

$xuid = new Xuid();

$in = $xuid->getUuid(); // ffe25f31-907e-46c0-b2f8-8bbfedb9082b

$tmp = $xuid->encode($in); // _-JfMZB-RsCy-Iu_7bkIKw

$out = $xuid->decode($tmp); // ffe25f31-907e-46c0-b2f8-8bbfedb9082b

$tmp = $xuid->getXuid();

$newXuid = $xuid->getXuid();
if (!$xuid->isValidXuid($newXuid)) {
    // this Xuid is valid
}
```

All methods can be called statically as well:

```php
use Xuid\Xuid;

$x = Xuid::getXuid();
$u = Xuid::decode($x);
```

## PHPUnit tests

```
vendor/bin/phpunit test/
```

## Brought to you by the LinkORB Engineering team

<img src="http://www.linkorb.com/d/meta/tier1/images/linkorbengineering-logo.png" width="200px" /><br />
Check out our other projects at [engineering.linkorb.com](http://engineering.linkorb.com).

Btw, we're hiring!
