<?php
/*
Plugin Name: Compartir Demo Plugin
Description: Este plugin es un ejemplo de creación de plugin para el postgrado ID3 con el cual se puede compartir un post en las redes sociales
Author: Javier Arques
Version: 1.0
*/



/*
 *  share_demo_plugin_content
 *  Contenido que se mostrará en el post
 *  se engancha al hook 'the_content'
 *
 */
function share_demo_plugin_content( $content ) {

    $share_text = get_option('share_demo_plugin_text') ? get_option('share_demo_plugin_text'): __('¿Te ha gustado?, compártelo', 'share-demo-plugin');
    $via = get_option('share_demo_plugin_via') ? '&via=' . get_option('share_demo_plugin_via'): '';

    $title = urlencode( get_the_title());
    $permalink = get_permalink( get_the_ID());

    $fb_url = 'http://www.facebook.com/sharer.php?u=' . $permalink . '&t=' . $title;
    $twitter_url = 'https://twitter.com/share?url=' . $permalink . '&text='. $title .$via;
    $gplus_url = 'https://plus.google.com/share?url=' . $permalink;
    $linkein_url = 'https://www.linkedin.com/cws/share?url=' . $permalink . '&title=' . $title . '&original_referer=' . $permalink . '&token=&isFramed=false&lang=es_ES&_ts=' . get_the_time();

    $html =
        '<div class="share-demo-plugin">'.
            '<h3 class="share-demo-plugin-title">'. $share_text . '</h3>'.
            '<ul class="share-demo-plugin-buttons">'.
                '<li><a href="'.$fb_url.'" class="btn btn-small share-demo-plugin-button"><i class="facebook"></i> Facebook</a></li>'.
                '<li><a href="'.$twitter_url.'" class="btn btn-small share-demo-plugin-button"><i class="twitter"></i> Twitter</a></li>'.
                '<li><a href="'.$gplus_url.'" class="btn btn-small share-demo-plugin-button"><i class="google"></i> Google+</a></li>'.
                '<li><a href="'.$linkein_url.'" class="btn btn-small share-demo-plugin-button"><i class="linkedin"></i> Linkedin</a></li>'.
            '</ul>'.
        '</div>';


    return $content . $html;
}

add_filter('the_content', 'share_demo_plugin_content');



/***************************************************************
 *  ADMIN OPTIONS
 ***************************************************************/

function share_demo_plugin_options_page() {

    if ( isset ( $_POST['share_demo_plugin_text']))
        update_option('share_demo_plugin_text', $_POST['share_demo_plugin_text']);

    if ( isset ( $_POST['share_demo_plugin_via']))
        update_option('share_demo_plugin_via', $_POST['share_demo_plugin_via']);

    ?>
    <div class="wrap">
        <h2><?php _e( 'Compartir plugin demo', 'share-demo-plugin' ); ?></h2>
        <p><?php _e( 'Opciones del plugin.', 'share-demo-plugin' ); ?></p>
        <form method="POST" action="">
            <table class="form-table">
                <tbody>
                <tr>
                    <th scope="row"><label for="share_demo_plugin_text"><?php _e('Texto compartir', 'share-demo-plugin')?></label></th>
                    <td>
                        <input name="share_demo_plugin_text" id="share_demo_plugin_text" value="<?php echo get_option('share_demo_plugin_text')?>">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="share_demo_plugin_via"><?php _e('Cuenta de twitter', 'share-demo-plugin')?></label></th>
                    <td>
                        <input name="share_demo_plugin_via" id="share_demo_plugin_via" value="<?php echo get_option('share_demo_plugin_via')?>">
                    </td>
                </tr>
                </tbody>
            </table>
            <input type="submit" class="button-primary" value="<?php _e( 'Save Options', 'share-demo-plugin' ); ?>" />
        </form>
    </div>
<?php
}

function share_demo_plugin_menu() {
    add_submenu_page( 'options-general.php', __( 'Plugin Demo', 'share-demo-plugin' ), __( 'Plugin Demo', 'share-demo-plugin' ), 'administrator', 'share_demo_plugin', 'share_demo_plugin_options_page' );
}
add_action( 'admin_menu', 'share_demo_plugin_menu' );



/***************************************************************
 *  FRONT ENQUEUE
 ***************************************************************/

/**
 * Proper way to enqueue scripts and styles
 */
function share_demo_plugin_enqueues() {

    if ( is_single()) {
        wp_enqueue_style( 'share-demo-plugin-styles', plugins_url('share-demo-plugin') . '/css/style.css' );
        wp_enqueue_script( 'share-demo-plugin-script', plugins_url('share-demo-plugin') . '/js/share-demo-plugin.js', array(), '1.0.0', true );
    }
}

add_action( 'wp_enqueue_scripts', 'share_demo_plugin_enqueues' );

