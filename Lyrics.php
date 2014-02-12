<?php
/**
 * Lyrics - Adds a <lyrics> tag to automatically turn line breaks into <br/>
 * tags so lyrics display as intended.
 *
 * @file
 * @ingroup Extensions
 * @version 1.0
 * @author Richard Cook <cook879@shoutwiki.com>
 * @copyright Copyright © 2014 Richard Cook
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 3.0 or later
 */

// Check we're in MediaWiki
if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This is not a valid entry point.\n" );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['parserhook'][] = array(
	'name' => 'Lyrics',
	'version' => '1.0',
	'author' => '[http://www.shoutwiki.com/wiki/User:Cook879 Richard Cook]',
	'url' => 'http://www.shoutwiki.com/wiki/Help:Lyrics',
	'description' => 'Adds a <code>&lt;lyrics&gt;</code> tag to allow simple lyrics formatting'
);

// Create lyrics tag
$wgHooks['ParserFirstCallInit'][] = 'wfLyricsSetup';

function wfLyricsSetup( Parser $parser ) {
	// Pair up the tag and the function
	$parser->setHook( 'lyrics', 'wfLyricsRender' );
	return true;
}

function wfLyricsRender( $text, array $args, Parser $parser, PPFrame $frame ) {
	// For security reasons, user input needs to be put through here
	$text = htmlspecialchars( $text );

	// Replace new lines with <br/>
	$text = str_replace( "\n", '<br/>', $text );

	// Parse the wikitext
	$output = $parser->recursiveTagParse( $text, $frame );

	// Return the generated output to the page
	return $output;
}
