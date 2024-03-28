<?php
/**
 * Plugin Name: WooCommerce Warehouse
 * Plugin URI: https://www.livechat.com/marketplace/apps/woocommerce
 * Description: Woocommerce Warehouse is a plugin that allows you to manage your warehouse and stock.
 * Version: 2.2.19
 * Author: Warehouse
 * Author URI: https://www.Warehouse.com
 * Text Domain: wp-live-chat-software-for-wordpress
 * Domain Path: /languages
 *
 * Copyright: © 2022 LiveChat.
 * License: GNU General Public License v3.0
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 */



if ( ! function_exists( 'warehouse_is_woo_plugin_active' ) ) {
    /**
     * Checks if WooCommerce plugin is active.
     *
     * @return bool
     */
    function warehouse_is_woo_plugin_active() {
        return in_array( 'woocommerce/woocommerce.php', get_option( 'active_plugins', array() ), true );
    }
}

define( 'WooWarehouse__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

if ( warehouse_is_woo_plugin_active() == false) {
    return;
}
require_once ( WooWarehouse__PLUGIN_DIR . 'class-wc-warehouse.php' );
require_once ( WooWarehouse__PLUGIN_DIR . 'ww-warehouse-functions.php' );
require_once ( WooWarehouse__PLUGIN_DIR . 'class-ww-warehouse-data-store-interface.php' );
require_once ( WooWarehouse__PLUGIN_DIR . 'class-ww-warehouse-data-store.php' );
require_once ( WooWarehouse__PLUGIN_DIR . 'class-ww-data-store.php' );
require_once ( WooWarehouse__PLUGIN_DIR . 'class-ww-admin-warehouse-table-list.php' );
require_once ( WooWarehouse__PLUGIN_DIR . 'warehouse.php' );




