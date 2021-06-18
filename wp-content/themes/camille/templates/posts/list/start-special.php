<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$loopCssClass       = array('la-loop','showposts-loop', 'list-special', 'showposts-list');

printf(
    '<div class="%1$s"><div class="lists-special-one">',
    esc_attr(implode(' ', $loopCssClass))
);