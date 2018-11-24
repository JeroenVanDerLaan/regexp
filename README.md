# Regexp Facade

A simple object oriented facade for PHP's built in PCRE regular expression functions.

```php
<?php
$matcher = new Matcher();
$regexp = new Regexp("(exam)ple");

$match = $matcher->match($regexp, "An example string");
$match->getSubject(); //"An example string"
$match->getMatch(); //"example"
$match->getOffset(); //3
$match->getGroups()[0]->getMatch(); //"exam"
```

## Table of Contents

* [Install](#install)
* [Description](#description)
* [Usage](#usage)
  + [Matching](#matching)
  + [Replacing](#replacing)
  + [Unreplacing](#unreplacing)
  + [Subtitution](#subtitution)

## Install
```
composer require jeroenvanderlaan/regexp
```

## Description

This library is intended to make regular expressions in PHP easier to work with. It makes pattern matching code a little more readable, and allows for object oriented benefits like dependency injection and improved testability.

I initially wrote this library in order to quickly develop multiple pattern matching tools for personal use. It allowed me to quickly write isolated tests, and reuse the majority of the codebase to implement similar, but slightly different command line utilities. With an added benefit of being able to circumvent complicated recursive pattern matching by means of temporary token substitution.

That said, this library is not optimized for performance, and should not be used in large scale production applications.
Use it during development if you prefer, but make sure to wrap an interface around it,
and replace this library with a more performant implementation of your own once you go to production.

## Usage

### Matching

The matcher can match the first occurance of your regular expression, or match all occurances.

```php
<?php
$matcher = new Matcher();
$regexp = new Regexp("foo|bar");

$match = $matcher->match($regexp, "foobar");
$match->getSubject(); //"foobar"
$match->getMatch(); //"foo"
$match->getOffset(); //0

$matches = $matcher->matchAll($regexp, "foobar");
$match = array_pop($matches);
$match->getSubject(); //foobar
$match->getMatch(); //bar
$match->getOffset(); //3
```

### Replacing

The replacer replaces all occurances of your regular expression using a replacement callback

```php
<?php
$replacer = new Replacer();
$regexp = new Regexp("foo|bar");
$callback = function (string $match) {
	return strrev($match);
};

$replaced = $replacer->replace($regexp, "foobar", $callback);
(string) $replaced; //oofrab
```

The replacer returns an object that, besides the replaced string, contains a reference to the original string, and an array of ```Replacement``` objects.

```php
<?php
$replaced->getReplacedString(); //oofrab
$replaced->getOriginalString(); //foobar
$replacements = $replaced->getReplacements();
$replacements[0]->getMatch(); //foo
$replacements[0]->getReplacement(); //oof
$replacements[1]->getMatch(); //bar
$replacements[1]->getReplacement(); //rab
```

### Unreplacing

The ```Replacement``` objects allow you to undo string replacement.

```php
<?php
$unreplacer = new Unreplacer();
$unreplacer->unreplace("rab", ...$replacements); //returns "bar"
$unreplacer->unreplace("oofrabbaz", ...$replacements); //returns foobarbaz
```

### Subtitution

The substitutor allows for replacing non alpha numeric characters with a (temporary) random string.

This is useful if you want to match recursively, but are too lazy to write the complicated regular expression.

```php
<?php
$substitutor = new Substitutor();
$regexp = new Regexp("\<\>");
$substituted = $substitutor->substitute($regexp, "<foo></foo>"); //substitutes all "<" and ">"
$matcher->match($regexp, (string) $substituted); //returns null
```

You can undo substitution just like with replacement.

```php
<?php
$substitutes = $substituted->getReplacements();
$unreplacer = new Unreplacer();
$unreplaced = $unreplacer->unreplace((string) $substituted, ...$substitutes);
//unreplaced is now "<foo></foo>"
```