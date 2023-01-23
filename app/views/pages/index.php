<?php require APPROT . '/views/inc/header.php'; ?>
    <div class="p-5 bg-light border rounded-3 text-center">
        <div class="container">
            <h1 class="display-3"><?php echo $data['title']; ?></h1>
            <p class="lead"><?php echo $data['description']; ?></p>
            <?php if ( isset( $_SESSION['user_name'] ) ) {
                echo 'Hello ' . $_SESSION['user_name'] . '!';
            }; ?>
        </div>
    </div>
<?php require APPROT . '/views/inc/footer.php'; ?>
