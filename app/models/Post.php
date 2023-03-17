<?php
class Post extends Model {
    protected $name = 'posts';

    // Select all posts
    public function getPosts() {
        $sql = 'SELECT *,
       posts.id as postId,
       users.id as userId,
       posts.created_at as postCreated,
       users.created_at as userCreated
       FROM posts
       INNER JOIN users
       ON posts.user_id = users.id
       ORDER BY posts.created_at DESC';
        $this->db->query( $sql );
//        $this->db->bind( ':user_id', $_SESSION['user_id'] );

        return $this->db->resultSet();
    }
}
