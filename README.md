Tags
====

(yet-another) PHP class for generating HTML tags.

example of usage
----------------

####construction of Tags object

```PHP
$tags = new Tags();
```

no dependencies at all... do not pass any arguments!

####generating a link.

```PHP
echo $tags->a( 'link' )->href( 'tags.php' );
// <a href="tags.php">link</a>
```

####nested/structured tags: ul > li

```PHP
$ul = $tags->ul(
  $tags->li( 'list #1' ),
  $tags->li( $tags->img()->src( 'img.gif' ) ),
  'just a text'
);
echo $ul;
/*
<ul>
    <li>list #1</li>
    <li><img src="img.gif" /></li>
    just a text
</ul>
*/
```

one object for a tag.

please note that img tag has no ending tags.
tags, such as img, input, br, has no body.

see more examples in examples.php.


License
-------

The MIT License (MIT)