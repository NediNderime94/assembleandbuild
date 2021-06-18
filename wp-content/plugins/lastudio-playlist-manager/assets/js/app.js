/**
 * LaStudio Playilst Manager custom functions
 */

var LPM = function ( $ ) {

	'use strict';

	return {

		init : function () {

			var _this = this;

			this.setLPMBarPlayerHtmlClass();
			this.cuePlaylists();

			$( window ).resize( function() {

				_this.resetTimerail();
				_this.sizeClasses();
			} );
		},

		/**
		 * LPM bar
		 */
		setLPMBarPlayerHtmlClass : function () {
			if( $( 'body' ).hasClass( 'is-lpm-bar-player' ) ) {
				$( 'html' ).addClass( 'lpm-bar' );
			}
		},

		/**
		 * Fire cue playlists
		 */
		cuePlaylists : function () {

			$( '.lpm-playlist' ).each( function() {

				var $playlist = $( this ),
					data = {},
					$data = $playlist.closest( '.lpm-playlist-container' ).find( '.lpm-playlist-data' );

				if ( $data.length ) {
					data = $.parseJSON( $data.first().html() );
				}

				$playlist.cuePlaylist( {
					startVolume: 1,
					audioVolume: "vertical",
					pauseOtherPlayers: data.pauseOtherPlayers,
					cueBackgroundUrl: data.thumbnail || '',
					cueEmbedLink: data.embed_link || '',
					cuePermalink: data.permalink || '',
					cueResponsiveProgress: true,
					defaultAudioHeight: 0,
					cuePlaylistLoop: false,
					cuePlaylistTracks: data.tracks || [],
					cueSkin: data.skin || 'lpm-theme-default',
					cueSelectors: {
						playlist: '.lpm-playlist',
						track: '.lpm-track',
						tracklist: '.lpm-tracks'
					},

					features: data.cueFeatures
				} );
			} );
		},

		/**
		 * Reset time bar
		 */
		resetTimerail : function () {
			$( '.lpm-playlist' ).each( function() {
				$( this ).find( '.mejs-time-rail, .mejs-time-slider' ).css( 'width', '' );
			} );
		},

		/**
		 * Change the player appearence depending on window's width
		 */
		sizeClasses : function () {

			$( '.lpm-playlist' ).each( function() {
				var width = $( this ).width();

				if ( 500 > width && 380 < width  ) {
					$( this ).addClass( 'lpm-playlist-500' );
					$( this ).removeClass( 'lpm-playlist-380' );

				} else if ( 380 > width ) {
					$( this ).removeClass( 'lpm-playlist-500' );
					$( this ).addClass( 'lpm-playlist-380' );
				} else {
					$( this ).removeClass( 'lpm-playlist-500' );
					$( this ).removeClass( 'lpm-playlist-380' );
				}
			} );
		}
	};

}( jQuery );


;( function( $ ) {

	'use strict';

	$( document ).ready( function() {

		LPM.init();
	} );


} )( jQuery );