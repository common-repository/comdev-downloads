jQuery( document ).ready( function( $ ) {
	setTimeout( function() {
		const codyButton = $( '.copy_button' );
		if ( codyButton.length ) {
			console.log( 'Button' );
			codyButton.click( function( e ) {
				e.preventDefault();
				const shortCodeText = $( '.short-code-text input' ).val();

				console.log( 'CLICK' );

				copyToClipboard( shortCodeText );
				$( this ).addClass( 'button-success' );
				$( this ).text( 'Copied' );
			} );
		}
	}, 300 );

	const bodyDownloadList = $( '.post-type-download_list' );
	if ( bodyDownloadList.length ) {
		bodyDownloadList.find( '#toplevel_page_comdev-files' ).removeClass( 'wp-not-current-submenu' ).addClass( 'wp-has-current-submenu' ).addClass( 'wp-menu-open' );
		bodyDownloadList.find( '#toplevel_page_comdev-files a:first' ).removeClass( 'wp-has-current-submenu' ).addClass( 'wp-has-current-submenu' ).addClass( 'wp-menu-open' );
	}

	const bodyDownloadItem = $( '.post-type-download_items ' );
	if ( bodyDownloadItem.length ) {
		bodyDownloadItem.find( '#toplevel_page_comdev-files' ).removeClass( 'wp-not-current-submenu' ).addClass( 'wp-has-current-submenu' ).addClass( 'wp-menu-open' );
		bodyDownloadItem.find( '#toplevel_page_comdev-files a:first' ).removeClass( 'wp-has-current-submenu' ).addClass( 'wp-has-current-submenu' ).addClass( 'wp-menu-open' );
	}

	function copyToClipboard( text ) {
		let textarea = document.createElement( 'textarea' );
		textarea.value = text;
		document.body.appendChild( textarea );
		textarea.select();
		document.execCommand( 'copy' );
		document.body.removeChild( textarea );
	}
} );

( function( $ ) {
	'use strict';

	var progressbar = $( '#progressbar' ),
		bar = progressbar.find( '.uk-progress-bar' ),
		settings = {

			action: '/', // upload url

			allow: '*.(jpg|jpeg|gif|png|pdf|zip|gzip)', // allow only images

			loadstart: function() {
				bar.css( 'width', '0%' ).text( '0%' );
				progressbar.removeClass( 'uk-hidden' );
			},

			progress: function( percent ) {
				percent = Math.ceil( percent );
				bar.css( 'width', percent + '%' ).text( percent + '%' );
			},

			allcomplete: function( response ) {

				bar.css( 'width', '100%' ).text( '100%' );

				setTimeout( function() {
					progressbar.addClass( 'uk-hidden' );
				}, 250 );

				alert( 'Upload Completed' );
			}
		};

	// var select = UIkit.uploadSelect( $( '#upload-select' ), settings ),
	// 	drop = UIkit.uploadDrop( $( '#upload-drop' ), settings );

} )( jQuery );

