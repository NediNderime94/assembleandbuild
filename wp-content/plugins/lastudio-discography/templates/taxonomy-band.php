<?php
/**
 * The Template for displaying releases in a release category. Simply includes the archive template.
 *
 * Override this template by copying it to yourtheme/lastudio-discography/taxonomy-band.php
 *
 * @author LaStudio
 * @package LaStudioDiscography/Templates
 * @version 1.0.0
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

lastudio_discography_get_template( 'archive-release.php' );