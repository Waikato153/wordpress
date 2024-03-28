<?php
/**
 * Admin View: Edit Webhooks
 *
 * @package WooCommerce\Admin\Webhooks\Views
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<input type="hidden" name="webhook_id" value="<?php echo esc_attr( $warehouse->get_id() ); ?>" />
<input type="hidden" name="save" value="1" />


<div id="webhook-options" class="settings-panel">
	<h2><?php esc_html_e( 'Warehouse data', '' ); ?></h2>
	<table class="form-table">
		<tbody>
			<tr valign="top">
				<th scope="row" class="titledesc">
					<label for="webhook_name">
						<?php esc_html_e( 'Name', '' ); ?>
						<?php
						/* translators: %s: date */
						echo wc_help_tip( sprintf( __( 'Friendly name for identifying this Warehouse, defaults to Warehouse created on %s.', '' ), (new DateTime('now'))->format( _x( 'M d, Y @ h:i A', 'Warehouse created on date parsed by DateTime::format', 'woocommerce' ) ) ) ); // @codingStandardsIgnoreLine
						?>
					</label>
				</th>
				<td class="forminp form-required">
					<input name="webhook_name" id="webhook_name" type="text" class="input-text regular-input" value="<?php echo esc_attr( $warehouse->get_name() ); ?>" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row" class="titledesc">
					<label for="webhook_status">
						<?php esc_html_e( 'Status', 'woocommerce' ); ?>
						<?php echo wc_help_tip( __( 'The options are &quot;Active&quot; (delivers payload), &quot;Paused&quot; (does not deliver), or &quot;Disabled&quot; (does not deliver due delivery failures).', 'woocommerce' ) ); ?>
					</label>
				</th>
				<td class="forminp">
					<select name="webhook_status" id="webhook_status" class="wc-enhanced-select">
						<?php
						$statuses       = wc_get_warehouse_statuses();
						$current_status = $warehouse->get_status();

						foreach ( $statuses as $status_slug => $status_name ) :
							?>
							<option value="<?php echo esc_attr( $status_slug ); ?>" <?php selected( $current_status, $status_slug, true ); ?>><?php echo esc_html( $status_name ); ?></option>
						<?php endforeach; ?>
					</select>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row" class="titledesc">
					<label for="webhook_topic">
						<?php esc_html_e( 'Address', 'woocommerce' ); ?>
						<?php echo wc_help_tip( __( 'Enter the warehouse\'s address.', '' ) ); ?>
					</label>
				</th>
                <td class="forminp form-required">
                    <input name="topic" id="webhook_action_event" type="text" class="input-text regular-input" value="<?php echo esc_attr( $warehouse->get_topic() ); ?>" />
                </td>
			</tr>

		</tbody>
	</table>

	<?php
	/**
	 * Fires within the webhook editor, after the Webhook Data fields have rendered.
	 *
	 * @param WC_Webhook $warehouse
	 */
	do_action( 'woocommerce_warehouse_options', $warehouse );
	?>
</div>

<div id="webhook-actions" class="settings-panel">
	<h2><?php esc_html_e( 'Warehouse actions', '' ); ?></h2>
	<table class="form-table">
		<tbody>
			<?php if ( $warehouse->get_date_created() && '0000-00-00 00:00:00' !== $warehouse->get_date_created()->date( 'Y-m-d H:i:s' ) ) : ?>
				<?php if ( is_null( $warehouse->get_date_modified() ) ) : ?>
					<tr valign="top">
						<th scope="row" class="titledesc">
							<?php esc_html_e( 'Created at', 'woocommerce' ); ?>
						</th>
						<td class="forminp">
							<?php echo esc_html( date_i18n( __( 'M j, Y @ G:i', 'woocommerce' ), strtotime( $warehouse->get_date_created()->date( 'Y-m-d H:i:s' ) ) ) ); ?>
						</td>
					</tr>
				<?php else : ?>
				<tr valign="top">
						<th scope="row" class="titledesc">
							<?php esc_html_e( 'Created at', 'woocommerce' ); ?>
						</th>
						<td class="forminp">
							<?php echo esc_html( date_i18n( __( 'M j, Y @ G:i', 'woocommerce' ), strtotime( $warehouse->get_date_created()->date( 'Y-m-d H:i:s' ) ) ) ); ?>
						</td>
					</tr>
				<tr valign="top">
						<th scope="row" class="titledesc">
							<?php esc_html_e( 'Updated at', 'woocommerce' ); ?>
						</th>
						<td class="forminp">
							<?php echo esc_html( date_i18n( __( 'M j, Y @ G:i', 'woocommerce' ), strtotime( $warehouse->get_date_modified()->date( 'Y-m-d H:i:s' ) ) ) ); ?>
						</td>
					</tr>
				<?php endif; ?>
			<?php endif; ?>
			<tr valign="top">
				<td colspan="2" scope="row" style="padding-left: 0;">
					<p class="submit">
						<button type="submit" class="button button-primary button-large" name="save" id="publishWarehouse" accesskey="p"><?php esc_html_e( 'Save warehouse', '' ); ?></button>
						<?php
						if ( $warehouse->get_id() ) :
							$delete_url = wp_nonce_url(
								add_query_arg(
									array(
										'delete' => $warehouse->get_id(),
									),
									admin_url( 'admin.php?page=wc-settings&tab=warehouse' )
								),
								'delete-warehouse'
							);
							?>
							<a style="color: #a00; text-decoration: none; margin-left: 10px;" href="<?php echo esc_url( $delete_url ); ?>"><?php esc_html_e( 'Delete permanently', 'woocommerce' ); ?></a>
						<?php endif; ?>
					</p>
				</td>
			</tr>
		</tbody>
	</table>
</div>

<script type="text/javascript">
	jQuery( function ( $ ) {
		$( '#webhook-options' ).find( '#webhook_topic' ).on( 'change', function() {
			var current            = $( this ).val(),
				action_event_field = $( '#webhook-options' ).find( '#webhook-action-event-wrap' );

			action_event_field.hide();

			if ( 'action' === current ) {
				action_event_field.show();
			}
		}).trigger( 'change' );


        $( '#publishWarehouse' ).on( 'click', function( e ) {
            e.preventDefault();
            if (validateForm($('#mainform')) == true) {
                $('#mainform').submit();
            }
        });

	});
</script>
