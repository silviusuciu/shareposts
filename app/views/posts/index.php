<?php require APPROT . '/views/inc/header.php'; ?>

    <?php flash('post_message'); ?>
    <div class="row">
        <div class="col-md-6">
            <h1>Posts</h1>
        </div>
        <div class="col-md-6 text-end">
            <a href="<?php echo URLROOT; ?>/posts/add" class="btn btn-primary">
                <i class="fa fa-pencil mr-1"></i>
                Add Post
            </a>
        </div>
    </div>
    <?php
//    var_dump( $data['posts'] );
    foreach ( $data['posts'] as $post ) : ?>
        <div class="card card-body mb-3">
            <h4 class="card-title"><?php echo $post->title; ?></h4>
            <div class="bg-light p-2 mb-3">
                Written by <?php echo $post->name; ?> on <?php echo $post->postCreated; ?>
            </div>
            <p class="card-text"><?php echo $post->body; ?></p>
            <a href="<?php echo URLROOT; ?>/posts/show/<?php echo $post->postId; ?>" class="btn btn-dark">More</a>
        </div>
    <?php endforeach; ?>

<?php require APPROT . '/views/inc/footer.php'; ?>