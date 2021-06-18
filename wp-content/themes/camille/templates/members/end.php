<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/*
 * Template loop-end
 */
global $camille_member_loop_index, $camille_loop;
$camille_member_loop_index = '';
$loop_style = isset($camille_loop['loop_style']) ? $camille_loop['loop_style'] : 1;
?>
</div>
<!-- .team-member-loop -->
