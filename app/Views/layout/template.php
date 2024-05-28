<!DOCTYPE html>
<html lang="en" class="dark">

<?php
echo view("layout/head");
?>

<body class="dark:bg-slate-600">
    <div id="loading" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="loader">
            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="48px" height="60px" viewBox="0 0 24 30" xml:space="preserve">
                <rect x="0" y="0" width="4" height="10" class="fill-current text-orange-500">
                    <animateTransform attributeType="xml" attributeName="transform" type="translate" values="0 0; 0 20; 0 0" begin="0" dur="0.6s" repeatCount="indefinite" />
                </rect>
                <rect x="10" y="0" width="4" height="10" class="fill-current text-orange-500">
                    <animateTransform attributeType="xml" attributeName="transform" type="translate" values="0 0; 0 20; 0 0" begin="0.2s" dur="0.6s" repeatCount="indefinite" />
                </rect>
                <rect x="20" y="0" width="4" height="10" class="fill-current text-orange-500">
                    <animateTransform attributeType="xml" attributeName="transform" type="translate" values="0 0; 0 20; 0 0" begin="0.4s" dur="0.6s" repeatCount="indefinite" />
                </rect>
            </svg>
        </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(window).ready(function() {
            $('#loading').fadeOut();
        })
    </script>
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