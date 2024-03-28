<?php

global $hide_save_button;

$hide_save_button = true;

add_filter( 'woocommerce_settings_tabs_array', 'my_custom_settings_tabs', 1, 1 );

add_filter( 'woocommerce_ww_warehouse_data_store', 'warehouse_data_store', 1, 1 );

function warehouse_data_store($object_type) {
    return $object_type;
}

function my_custom_settings_tabs( $settings_tabs ) {
    $settings_tabs[ 'warehouse' ] = __( 'Warehouse');
    // 添加键和值到数组末尾
    return $settings_tabs;
}
add_action('admin_init', 'add_warehouse_settings');
add_action( 'woocommerce_settings_warehouse', 'outputWareHouse');
add_action( 'woocommerce_settings_page_init', 'warehouse_screen_option' );


function add_warehouse_settings() {
    // Save.
    // phpcs:ignore WordPress.Security.NonceVerification.Missing
    if ( isset( $_POST['save'] ) && isset( $_POST['webhook_id'] ) ) {
        saveWarehouse();
    }

    // Delete webhook.
    // phpcs:ignore WordPress.Security.NonceVerification.Recommended
    if ( isset( $_GET['delete'] ) ) {
        deleteWarhouse();
    }
}

function saveWarehouse() {
    // phpcs:ignore WordPress.Security.NonceVerification.Recommended
    $warehouse_id = absint( $_POST['webhook_id'] );
    $warehouse    = new WC_Warehouse( $warehouse_id );

    $warehouse->set_name( wc_clean( wp_unslash( $_POST['webhook_name'] ) ) );
    $warehouse->set_status( wc_clean( wp_unslash( $_POST['webhook_status'] ) ) );
    $warehouse->set_topic( wc_clean( wp_unslash( $_POST['topic'] ) ) );

    $warehouse->save();

    // Redirect to the edit screen.
    wp_safe_redirect( admin_url( 'admin.php?page=wc-settings&tab=warehouse&edit-warehouse=' . $warehouse->get_id() ) );
    exit;
}


function deleteWarhouse() {
    check_admin_referer( 'delete-warehouse' );

    // phpcs:ignore WordPress.Security.NonceVerification.Recommended
    if ( isset( $_GET['delete'] ) ) {
        // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        $webhook_id = absint( $_GET['delete'] );


        if ( $webhook_id ) {
            bulkDeleteWarehouse( array( $webhook_id ) );
        }
    }
}

function bulkDeleteWarehouse($webhooks) {

    foreach ( $webhooks as $webhook_id ) {
        $webhook = new WC_Warehouse( (int) $webhook_id );
        $webhook->delete( true );
    }

    $qty = count( $webhooks );
    // phpcs:ignore WordPress.Security.NonceVerification.Recommended
    $status = isset( $_GET['status'] ) ? '&status=' . sanitize_text_field( wp_unslash( $_GET['status'] ) ) : '';

    // Redirect to webhooks page.
    wp_safe_redirect( admin_url( 'admin.php?page=wc-settings&tab=warehouse' . $status . '&deleted=' . $qty ) );
    exit();
}



function warehouse_screen_option() {
    global $warehouse_table_list;

    $warehouse_table_list = new WW_Admin_Webhooks_Table_List();

    $option = 'per_page';
    $args   = array(
        'label'   => __( 'Warehouse', 'woocommerce' ),
        'default' => 10,
        'option'  => 'woocommerce_warehouse_per_page',
    );

    add_screen_option( $option, $args );
}

function outputWareHouse() {
    // We can't use "get_settings_for_section" here
    // for compatibility with derived classes overriding "get_settings".
    //$settings = getWarehousesettings( $current_section );

    // phpcs:ignore WordPress.Security.NonceVerification.Recommended
    if ( isset( $_GET['edit-warehouse'] ) ) {
        // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        $warehouse_id = absint( $_GET['edit-warehouse'] );
        $warehouse    = new WC_Warehouse( $warehouse_id );

        include __DIR__ . '/html-warehouse-edit.php';
        return;
    }


    //var_dump($settings);exit;

    getWarehousesettings();
}

function getWarehousesettings() {
    global $warehouse_table_list;


    echo '<h2 class="wc-table-list-header">' . esc_html__( 'Warehouse', 'woocommerce' ) . ' <a href="' . esc_url( admin_url( 'admin.php?page=wc-settings&tab=warehouse&edit-warehouse=0' ) ) . '" class="page-title-action">' . esc_html__( 'Add Warehouse', '' ) . '</a></h2>';

    // Get the webhooks count.

    $data_store   = WW_Data_Store::load( 'warehouse' );
    $num_webhooks = $data_store->get_count_webhooks_by_status();


    $count        = array_sum( $num_webhooks );


    if ( 0 < $count ) {
        $warehouse_table_list->process_bulk_action();
        $warehouse_table_list->prepare_items();

        echo '<input type="hidden" name="page" value="wc-settings" />';
        echo '<input type="hidden" name="tab" value="warehouse" />';

        $warehouse_table_list->views();
        $warehouse_table_list->search_box( __( 'Search Warehouse', 'woocommerce' ), 'webhook' );
        $warehouse_table_list->display();

    } else {
        echo '<div class="woocommerce-BlankState woocommerce-BlankState--webhooks">';
?>
        <h2 class="woocommerce-BlankState-message"><?php esc_html_e( 'Webhooks are event notifications sent to URLs of your choice. They can be used to integrate with third-party services which support them.', '' ); ?></h2>
        <a class="woocommerce-BlankState-cta button-primary button" href="<?php echo esc_url( admin_url( 'admin.php?page=wc-settings&tab=warehouse&edit-webhook=0' ) ); ?>"><?php esc_html_e( 'Create a new Warehouse', '' ); ?></a>
        <style type="text/css">#posts-filter .wp-list-table, #posts-filter .tablenav.top, .tablenav.bottom .actions { display: none; }</style>

<?php
    }
}

