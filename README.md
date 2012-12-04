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

see more examples in examples.php.


