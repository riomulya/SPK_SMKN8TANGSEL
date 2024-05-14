<!DOCTYPE html>
<html lang="en">

<?php
echo view("layout/head");
?>

<body>
    <?php
    echo view('layout/nav');
    ?>
    <div class="main-content">
        <?= $this->renderSection('content') ?>
    </div>
    <?php
    echo view('layout/footer');
    ?>
</body>

</html>