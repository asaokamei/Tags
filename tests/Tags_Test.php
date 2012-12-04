<?php
require_once( __DIR__ . '/../src/Tags.php' );

class Tags_Test extends \PHPUnit_Framework_TestCase
{
    /** @var Tags */
    public $tags;
    public function setUp()
    {
        $this->tags = new Tags();
    }
    // +----------------------------------------------------------------------+
    public function test_underscore_to_hyphen()
    {
        $span = (string) $this->tags->span( 'text span' )->data_type( 'dataType' );
        $this->assertContains( 'data-type="dataType"', $span );
    }
    public function test_quote_safe()
    {
        $unsafe = 'unsafe" string';
        $text = (string)  $this->tags->input()->value( $unsafe );
        $this->assertContains( htmlentities( $unsafe ), $text );
        
        $text = (string)  $this->tags->input()->value( Tags::wrap_( $unsafe ) );
        $this->assertContains( $unsafe, $text );
    }
    public function test_inline()
    {
        $text = (string)  $this->tags->p( 'this is ' . $text = (string)  $this->tags->bold( 'bold text' ) . '.' );
        $this->assertContains( '<strong>bold text</strong>.</p>', $text );
    }
    public function test_input_required()
    {
        $text = (string)  $this->tags->input()->required( true );
        $this->assertContains( '<input required="required" />', $text );
    }
    public function test_div_in_div_box()
    {
        $text = (string)  $this->tags->div()->_class( 'divClass' )->contain_(
            'this is a text',
            $this->tags->div(
                $this->tags->a( 'link1' )->href( 'do.php' )->target( '_blank' ),
                $this->tags->a( 'link2' )->href( 'do1.php' )->target( '_blank' )
            ),
            $this->tags->a( 'link3' )->href( 'do2.php' )
        );
        $lines = explode( "\n", $text );
        $this->assertContains( "<div class=\"divClass\">", $lines[0] );
        $this->assertContains( 'this is a text', $lines[1] );
        $this->assertContains( "<div>", $lines[2] );
        $this->assertContains( '<a href="do.php" target="_blank">link1</a>', trim( $lines[3] ) );
        $this->assertContains( '<a href="do1.php" target="_blank">link2</a>', trim( $lines[4] ) );
        $this->assertContains( "</div>", $lines[5] );
        $this->assertContains( "<a href=\"do2.php\">link3</a>", $lines[6] );
        $this->assertContains( "</div>", $lines[7] );
    }
    public function test_div_box()
    {
        $text = (string)  $this->tags->div();
        $this->assertContains( "<div>\n</div>", $text );
        
        $text = (string)  $this->tags->div(
            'this is a text',
            $this->tags->a( 'a link' )->href( 'do.php' )->target( '_blank' ),
            $this->tags->a( 'a link' )->href( 'do1.php' )->target( '_blank' ),
            $this->tags->a( 'a link' )->href( 'do2.php' )->target( '_blank' )
        );
        $lines = explode( "\n", $text );
        $this->assertContains( "<div>", $lines[0] );
        $this->assertContains( 'this is a text', $lines[1] );
        $this->assertContains( '<a href="do.php" target="_blank">a link</a>', trim( $lines[2] ) );
        $this->assertContains( '<a href="do1.php" target="_blank">a link</a>', trim( $lines[3] ) );
        $this->assertContains( '<a href="do2.php" target="_blank">a link</a>', trim( $lines[4] ) );
        $this->assertContains( "</div>", $lines[5] );
    }
    public function test_style()
    {
        $text = (string)  $this->tags->a( 'a link' )->href( 'do.php' )->style( 'style1' )->style( 'style2' );
        $this->assertContains( '<a href="do.php" style="style1; style2">a link</a>', $text );

        $text = (string)  $this->tags->a( 'a link' )->href( 'do.php' )->style( 'style1' )->_style( 'style2', FALSE );
        $this->assertContains( '<a href="do.php" style="style2">a link</a>', $text );

    }
    public function test_class()
    {
        $text = (string)  $this->tags->a( 'a link' )->href( 'do.php' )->_class( 'myClass' )->_class( 'myClass2' );
        $this->assertContains( '<a href="do.php" class="myClass myClass2">a link</a>', $text );

        $text = (string)  $this->tags->a( 'a link' )->href( 'do.php' )->_class( 'myClass' )->_class( 'myClass2', FALSE );
        $this->assertContains( '<a href="do.php" class="myClass2">a link</a>', $text );

    }
    public function test_anchor_link()
    {
        $text = (string) $this->tags->a( 'a link' )->href( 'do.php' )->target( '_blank' );
        $this->assertContains( '<a href="do.php" target="_blank">a link</a>', $text );
    }
    public function test_alternative_syntax()
    {
        // alternative syntax
        $tags = $this->tags;
        $text = (string)  $tags( 'a', 'a link' )->href( 'do.php' )->target( '_blank' );
        $this->assertContains( '<a href="do.php" target="_blank">a link</a>', $text );

        $text = (string)  $tags( 'a', 'a link' )->href( 'do.php' )->style( 'style1' )->style( 'style2' );
        $this->assertContains( '<a href="do.php" style="style1; style2">a link</a>', $text );
    }
}

    