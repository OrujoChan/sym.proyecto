<!DOCTYPE html>
<html>
<?php
include __DIR__ . '/header.part.php';
?>

<body>
    <?php
    include __DIR__ . '/nav.part.php';
    include __DIR__ . '/show-error.part.view.php';
    echo $mainContent;
    include __DIR__ . '/footer.part.php';
    ?>
</body>

</html>