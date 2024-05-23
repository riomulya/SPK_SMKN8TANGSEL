<!DOCTYPE html>
<html lang="en" class="dark">

<?php
echo view("layout/head");
?>

<body class="dark:bg-slate-600">
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