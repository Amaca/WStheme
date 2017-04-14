<?php
$html = '';

//templates/homepage.php
if (is_page_template('templates/homepage.php')) {
    $html .= '<div class="side-element">homepage</div>';
} else {
    $html .= '<div class="side-element"></div>';
}
?>

<!-- Sidebar -->
<div id="sidebar">
   
    <?php echo $html; ?>

</div>
<!-- /Sidebar -->

<?php dynamic_sidebar('sidebar-primary'); ?>
