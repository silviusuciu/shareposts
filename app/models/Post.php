<?php
class Post extends Model {
    protected $name = 'posts';

    // Select all posts
    public function getPosts( $cache_test = [] ) {
        $cacheKey = 'posts';
        $cache = Cache::get_instance();

        $result = $cache->get( $cacheKey );
        if ( ! empty( $result ) && ( empty( $cache_test ) || $cache_test['active'] === true )  ) {
            return $result;
        }

        $sql = '
        SELECT posts.id as postId,
               posts.created_at as postCreated,
               posts.title,
               posts.body,
               users.id as userId,
               users.created_at as userCreated,
               users.name
        FROM posts
            INNER JOIN users ON posts.user_id = users.id
        ORDER BY posts.created_at DESC';

        $this->db->query( $sql );
        $result = $this->db->resultSet();

        $cache->set( $cacheKey, $result, 60 );

        return $result;
    }
}
