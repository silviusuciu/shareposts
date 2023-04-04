<?php require APPROT . '/views/inc/header.php'; ?>
    <h1><?php echo $data['title']; ?></h1>
    <p><?php echo $data['description']; ?></p>
    <p>Version: <strong><?php echo APPVERSION; ?></strong></p>

<?php

require_once '../app/models/Post.php';

$model = $data['model'];

//for ( $i = 1; $i <= 50; $i++ ) {
//    $model->create( [ 'user_id' => 15, 'title' => "Post title $i", 'body' => "Post content $i" ] );
//}

$start = microtime( true );
$result = $model->getPosts( $cache_test = [ 'active' => false ] );
$timeWithoutCache = microtime( true ) - $start;

// with cache
$start = microtime( true );
$result = $model->getPosts( $cache_test = [ 'active' => true ] );
$timeWithCache = microtime( true ) - $start;

echo "Time without cache: " . $timeWithoutCache . " seconds\n";
echo "Time with cache: " . $timeWithCache . " seconds\n";

?>

<?php require APPROT . '/views/inc/footer.php'; ?>
