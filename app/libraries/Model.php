<?php
class Model {
    protected $db;

    public function __construct() {
        $this->db = Database::get_instance();
    }

    public function create( $data ) {

        $keys = [];
        $values = [];

        foreach ( $data as $key => $value ) {
            $keys[] = $key;
            $values[] = ':' . $key;
        }

        $keysString = implode( ', ', $keys );
        $valuesString = implode( ', ', $values );

        $sql = 'INSERT INTO posts (' . $keysString .  ') VALUES (' . $valuesString .  ')';

        $this->db->query( $sql );

        foreach ( $data as $key => $value ) {
            $this->db->bind( ':' . $key, $value );
        }

        return $this->db->execute();
    }

    public function update( $data ) {

        $where = array_pop( $data );
        $whereKey = key( $where );
        $whereVal = $where[ $whereKey ];

        $set = array_map( static function ( $key ) { return $key . ' = :' . $key; }, array_keys( $data ) );
        $set = implode( ', ', $set );

        $sql = 'UPDATE ' . $this->name . ' SET ' . $set . ' WHERE ' . $whereKey . ' = :' . $whereKey;

        $this->db->query( $sql );
        $this->db->bind( ':' . $whereKey, $whereVal );

        foreach ( $data as $key => $value ) {
            $this->db->bind( ':' . $key, $value );
        }

        return $this->db->execute();
    }

    public function delete( $data ) {

        $key = key( $data );
        $val = $data[ $key ];

        $sql = 'DELETE FROM ' . $this->name . ' WHERE ' . $key . ' = :' . $key;

        $this->db->query( $sql );

        $this->db->bind( ':' . $key, $val );

        return $this->db->execute();
    }

    public function getById( $id ) {
        $this->db->query( 'SELECT * FROM ' . $this->name . ' WHERE id = :id' );
        $this->db->bind( ':id', $id );

        return $this->db->single();
    }
}
