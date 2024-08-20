<?php
/**
 * Plugin Name: Hello React
 */
function hello_react_admin_menu(){
    add_menu_page(
        __('Hello React','hello-react'),
        __('Hello React','hello-react'),
        'manage_options',
        'hello-react',
        'hello_react_admin_menu_callback',
        'dashicons-edit-large',
    );
}
add_action('admin_menu','hello_react_admin_menu');

function hello_react_admin_menu_callback(){
    echo '<div id="root"></div>';
}

function hello_react_enqueue_scripts( $admin_page ){
    if( $admin_page !== 'toplevel_page_hello-react'){
        return;
    }

    $asset_file = plugin_dir_path( __FILE__ ) . 'build/index.asset.php';

    if ( ! file_exists( $asset_file ) ) {
        return;
    }

    $asset = include $asset_file;

    wp_enqueue_script(
        'hello-react-script',
        plugins_url( 'build/index.js', __FILE__ ),
        $asset['dependencies'],
        $asset['version'],
        array(
            'in_footer' => true,
        )
    );

    $css_handle = is_rtl() ? 'hello-react-style-rtl' : 'hello-react-style';
    $css_file = is_rtl() ? 'build/index-rtl.css' : 'build/index.css';
    wp_enqueue_style(
        $css_handle,
        plugins_url( $css_file, __FILE__ ),
        array_filter(
            $asset['dependencies'],
            function ( $style ) {
                return wp_style_is( $style, 'registered' );
            }
        ),
        $asset['version'],
    );
}
add_action( 'admin_enqueue_scripts', 'hello_react_enqueue_scripts' );