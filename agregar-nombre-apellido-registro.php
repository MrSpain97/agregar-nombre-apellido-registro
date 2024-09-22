<?php
/*
Plugin Name: Agregar Nombre y Apellido al Registro de WooCommerce
Plugin URI: #
Description: Este plugin agrega campos de Nombre y Apellido al formulario de registro de WooCommerce.
Version: 1.0
Author: Tu David Revilla
Author URI: #
License: GPL2
*/

// Evitar acceso directo al archivo
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Añadir los campos de nombre y apellido al formulario de registro
function agregar_campos_registro_nombre_apellido() {
    ?>
    <p class="form-row form-row-first">
        <label for="reg_billing_first_name"><?php _e( 'Nombre', 'woocommerce' ); ?> <span class="required">*</span></label>
        <input type="text" class="input-text" name="billing_first_name" id="reg_billing_first_name" value="<?php if ( ! empty( $_POST['billing_first_name'] ) ) echo esc_attr( $_POST['billing_first_name'] ); ?>" />
    </p>

    <p class="form-row form-row-last">
        <label for="reg_billing_last_name"><?php _e( 'Apellido', 'woocommerce' ); ?> <span class="required">*</span></label>
        <input type="text" class="input-text" name="billing_last_name" id="reg_billing_last_name" value="<?php if ( ! empty( $_POST['billing_last_name'] ) ) echo esc_attr( $_POST['billing_last_name'] ); ?>" />
    </p>
    <div class="clear"></div>
    <?php
}
add_action( 'woocommerce_register_form_start', 'agregar_campos_registro_nombre_apellido' );

// Validar los campos de nombre y apellido en el formulario de registro
function validar_campos_registro_nombre_apellido( $username, $email, $validation_errors ) {
    if ( isset( $_POST['billing_first_name'] ) && empty( $_POST['billing_first_name'] ) ) {
        $validation_errors->add( 'billing_first_name_error', __( 'El nombre es un campo obligatorio.', 'woocommerce' ) );
    }

    if ( isset( $_POST['billing_last_name'] ) && empty( $_POST['billing_last_name'] ) ) {
        $validation_errors->add( 'billing_last_name_error', __( 'El apellido es un campo obligatorio.', 'woocommerce' ) );
    }

    return $validation_errors;
}
add_action( 'woocommerce_register_post', 'validar_campos_registro_nombre_apellido', 10, 3 );

// Guardar los campos de nombre y apellido en los datos del usuario
function guardar_campos_registro_nombre_apellido( $customer_id ) {
    if ( isset( $_POST['billing_first_name'] ) ) {
        update_user_meta( $customer_id, 'first_name', sanitize_text_field( $_POST['billing_first_name'] ) );
        update_user_meta( $customer_id, 'billing_first_name', sanitize_text_field( $_POST['billing_first_name'] ) );
    }

    if ( isset( $_POST['billing_last_name'] ) ) {
        update_user_meta( $customer_id, 'last_name', sanitize_text_field( $_POST['billing_last_name'] ) );
        update_user_meta( $customer_id, 'billing_last_name', sanitize_text_field( $_POST['billing_last_name'] ) );
    }
}
add_action( 'woocommerce_created_customer', 'guardar_campos_registro_nombre_apellido' );
