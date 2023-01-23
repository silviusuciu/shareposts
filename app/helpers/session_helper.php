<?php

session_start();

// Flash message helper
// EXAMPLE - flash('register_success', 'You are now registered', 'alert alert-danger');
// DISPLAY IN VIEW - <?php echo flash('register_success');
function flash( $name = '', $message = '', $class = 'alert alert-success' ) {
    if ( ! empty( $name ) ) { // we always call the function with a name
        if ( ! empty( $message ) && empty( $_SESSION[$name] ) ) {
            // the part where we set the flash
            // the unsets are just to be sure
            if ( ! empty( $_SESSION[$name] ) ) {
                unset( $_SESSION[$name] );
            }
            if ( ! empty( $_SESSION[$name . '_class'] ) ) {
                unset( $_SESSION[$name . '_class'] );
            }

            $_SESSION[$name] = $message;
            $_SESSION[$name . '_class'] = $class;
        } elseif ( empty( $message ) && ! empty( $_SESSION[$name] ) ) {
            // the part where we show the flash
            $class = ! empty( $_SESSION[$name . '_class'] ) ? $_SESSION[$name . '_class'] : '';
            echo '<div class="' . $class . '" id="msg-flash">' . $_SESSION[$name] . '</div>';
            unset( $_SESSION[$name] );
            unset( $_SESSION[$name . '_class'] );
        }
    }

    return false;
}

function isLoggedIn() {
    if ( isset( $_SESSION['user_id'] ) ) {
        return true;
    } else {
        return false;
    }
}
