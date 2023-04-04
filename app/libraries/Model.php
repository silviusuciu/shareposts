<?php
class Model {
    protected $db;

    public function __construct() {
        $this->db = Database::get_instance();
    }

    public function create( $data ) {

        $columns = implode( ', ', array_keys( $data ) );
        $values = ':' . implode( ', :', array_keys( $data ) );

        $query = "INSERT INTO $this->name ( $columns ) VALUES ( $values )";

        $this->db->query( $query );

        foreach ( $data as $key => $value ) {
            $this->db->bind( ":$key", $value );
        }

        return $this->db->execute();
    }

    // read
    public function getByParam( $param, $check_only = false, $cache_ttl = 60 ) {

        $key = key( $param );
        $val = $param[ $key ];

        $query = "SELECT * FROM $this->name WHERE $key = :$key";

        $this->db->query( $query );
        $this->db->bind( ":$key", $val );

        $result = $this->db->single();

        // Check row
        if ( $check_only ) {
            return $this->db->rowCount() > 0;
        }

        return $result;
    }

    public function update( $data ) {

        $where = array_pop( $data );
        $key = key( $where );
        $val = $where[ $key ];

        $set = implode( ', ', array_map( static function ( $key ) {
            return "$key = :$key";
        }, array_keys( $data ) ) );

        $query = "UPDATE $this->name SET $set WHERE $key = :$key";

        $this->db->query( $query );
        $this->db->bind( ":$key", $val );

        foreach ( $data as $key => $value ) {
            $this->db->bind( ":$key", $value );
        }

        return $this->db->execute();
    }

    public function delete( $data ) {

        $key = key( $data );
        $val = $data[ $key ];

        $query = "DELETE FROM $this->name WHERE $key = :$key";

        $this->db->query( $query );

        $this->db->bind( ":$key", $val );

        return $this->db->execute();
    }
}
