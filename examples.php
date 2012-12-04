<?php
require_once( __DIR__ . '/src/Tags.php' );

// +--------------------------------------------+
//  construction.

$tags = new Tags();

// +--------------------------------------------+
//  simple case for anchor link.

echo $tags->a( 'link' )->href( 'tags.php' );
// <a href="tags.php">link</a>

// +--------------------------------------------+
//  structured ul > li.

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

// +--------------------------------------------+
//  select > optgroup > option structure.

$lang = array(
//  array( value, option name, optgroup ), ...
    array( 'zhi',  'chinese',   'asia'   ),
    array( 'jpn',  'japanese',  'asia'   ),
    array( 'kor',  'korean',    'asia'   ),
    array( 'eng',  'english'             ),
    array( 'fra',  'french',    'europe' ),
    array( 'ger',  'german',    'europe' ),
    array( 'spa',  'spanish',   'europe' ),
);
$select = $tags->select()->name( 'language' );
$groups = array();
foreach( $lang as $item ) // loop on languages.
{
    $option = $tags->option( $item[1] )->value( $item[0] );
    if( isset( $item[2] ) ) // has an optgroup.
    {
        if( !isset( $groups[ $item[2] ] ) ) { // create new optgroup.
            $groups[ $item[2] ] = $tags->optgroup()->label( $item[2] );
            $select->contain_( $groups[ $item[2] ] );
        }
        $groups[ $item[2] ]->contain_( $option );
    }
    else {
        $select->contain_( $option );
    }
}
echo $select;
/*
<select name="language">
  <optgroup label="asia">
    <option value="zhi">chinese</option>
    <option value="jpn">japanese</option>
    <option value="kor">korean</option>
  </optgroup>
  <option value="eng">english</option>
  <optgroup label="europe">
    <option value="fra">french</option>
    <option value="ger">german</option>
    <option value="spa">spanish</option>
  </optgroup>
</select>
 */

// +--------------------------------------------+
//  input and with array.

$input = $tags->input()->type( 'check' )->name( 'checkMe' )->value( 'Yeap' );
echo $input;
$input->walk( function( $tags ) {
    if( isset( $tags->attributes['name'] ) ) $tags->attributes['name'].='[]';
} );
echo $input . "\n";
/*
<input type="check" name="radioMe" value="Yeap" />
<input type="check" name="radioMe[]" value="Yeap" />
 */

// +--------------------------------------------+
//  live and dead tag.
echo $tags->span( 'this is ', $tags->strong( 'strong' ), ' word. ' ) . "\n";
echo $tags->span( 'this is '. $tags->strong( 'strong' ). ' word. ' ) . "\n";
// <span>this is <strong>strong</strong> word. </span>
// <span>this is <strong>strong</strong> word. </span>

// +--------------------------------------------+
//  not so clean output.

echo $tags->div(
    $tags->ul(
        $tags->li( 'list' )
    )
);

/*
<div><ul><li>list</li></ul>
</div>
 */