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

## Example

You'll find example code in the `example/` directory.

To generate 100 XUIDs, run the following command:

```
php example/generate.php
```

Example output:
```
y9G-jWmYQcW5HyxiU_Pnew: cbd1be8d-6998-41c5-b91f-2c6253f3e77b
IOnEowPFR-G74hEBtTSJVQ: 20e9c4a3-03c5-47e1-bbe2-1101b5348955
Jgn4-Hs3STyNMC_ectX4kA: 2609f8f8-7b37-493c-8d30-2fde72d5f890
-rO6xKQFQCGPozxJf35lGw: fab3bac4-a405-4021-8fa3-3c497f7e651b
c6l3fR3mThSlL1OlNYgCvg: 73a9777d-1de6-4e14-a52f-53a5358802be
3PK9eo00T92z6oSsFNCY-A: dcf2bd7a-8d34-4fdd-b3ea-84ac14d098f8
vCMyGdkGT-m6e6m4BKcfgA: bc233219-d906-4fe9-ba7b-a9b804a71f80
JJ_1Ndd3S9SwG9urLr5NTQ: 249ff535-d777-4bd4-b01b-dbab2ebe4d4d
KSn-sn-cToydyfvjLZHhBA: 2929feb2-7f9c-4e8c-9dc9-fbe32d91e104
fi_nfoXrQ_GoYrzT4oZqRw: 7e2fe77e-85eb-43f1-a862-bcd3e2866a47
1vKKRSlHQICMj5X5iktHZA: d6f28a45-2947-4080-8c8f-95f98a4b4764
yWJ5VPsISbS46anoEO2HVQ: c9627954-fb08-49b4-b8e9-a9e810ed8755
...etc
```

## PHPUnit tests

```
vendor/bin/phpunit test/
```


## Brought to you by the LinkORB Engineering team

<img src="http://www.linkorb.com/d/meta/tier1/images/linkorbengineering-logo.png" width="200px" /><br />
Check out our other projects at [engineering.linkorb.com](http://engineering.linkorb.com).

Btw, we're hiring!
