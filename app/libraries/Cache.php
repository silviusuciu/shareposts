<?php

class Cache {
    private static $instance;
    private static $cache_dir = 'cache';

    public static function get_instance() {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public static function set( $key, $value, $ttl ) {
        if ( ! is_dir( self::$cache_dir ) ) {
            mkdir( self::$cache_dir );
        }
        $filename = self::$cache_dir . '/' . $key;
        $cached_time = time() + $ttl;
        $data = $cached_time . serialize( $value );
        file_put_contents( $filename, $data );
    }

    public static function get( $key ) {
        $filename = self::$cache_dir . '/' . $key;
        if ( ! file_exists( $filename ) ) {
            return false;
        }
        $data = file_get_contents( $filename );
        $cached_time = substr( $data, 0, 10 );
        $data = substr( $data, 10 );
        if ( time() > $cached_time ) {
            unlink( $filename ); // deletes a file
            return false;
        }
        return unserialize( $data );
    }

    public static function delete( $key ) {
        $filename = self::$cache_dir . '/' . $key;
        if ( file_exists( $filename ) ) {
            unlink( $filename );
        }
    }
}
