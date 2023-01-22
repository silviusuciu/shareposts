<?php require APPROT . '/views/inc/header.php'; ?>

<a href="<?php echo URLROOT; ?>/posts" class="btn btn-light"><i class="fa fa-backward"></i> Back</a>
    <div class="card card-body bg-light mt-3">
        <h2>Edit post</h2>
        <p>Edit a post with this form</p>
        <form action="<?php echo URLROOT; ?>/posts/edit/<?php echo $data['id']; ?>" method="post">
            <div class="form-group mb-3">
                <label class="mb-1" for="title">Title: <sup>*</sup></label>
                <input type="text" name="title" class="form-control form-control-lg <?php echo ( !empty( $data['title_err'] ) ) ? 'is-invalid' : ''; ?>" value="<?php echo $data['title'] ?>">
                <span class="invalid-feedback"><?php echo $data['title_err'] ?></span>
            </div>
            <div class="form-group mb-3">
                <label class="mb-1" for="body">Body: <sup>*</sup></label>
                <textarea name="body" class="form-control form-control-lg <?php echo ( !empty( $data['body_err'] ) ) ? 'is-invalid' : ''; ?>"><?php echo $data['body'] ?></textarea>
                <span class="invalid-feedback"><?php echo $data['body_err'] ?></span>
            </div>
            <input type="submit" class="btn btn-success" value="Submit">
        </form>
    </div>

<?php require APPROT . '/views/inc/footer.php'; ?>
