/**
 *  Share Demo Plugin script
 *  Open new window with share links
 */

(function( window, document, undefined ){

    var openNewWindow = function( event ) {
        window.open( this.href, 'window','width=550,height=450');
        event.preventDefault();
    };

    var buttons = document.body.querySelectorAll('a.share-demo-plugin-button');

    if ( buttons.length > 0 ) {
        for ( var i=0; i< buttons.length; i++) {
            buttons[i].addEventListener("click", openNewWindow, false);
        }
    }

})( window, document);
