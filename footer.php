<?php
use Roots\WStheme\Custom;
use Roots\WStheme\ACF;
?>
        </div>
        <!-- /Main -->
        
        <!-- Footer -->
        <footer class="footer">
            <div class="container">
                
                    <?php 
                    $menuParameters = array(
                        'menu' => 'Footer Menu', 
                        'container'       => false,
                        'container_class' => false,
                        'echo'            => false,
                        'menu_id'         => false,
                        'items_wrap'      => '%3$s',
                        'depth'           => 0,
                    );
                    echo strip_tags(wp_nav_menu( $menuParameters ), '<a>' );
                    ?>  
            </div>
            <a title="eCommerce" target="_blank" href="https://www.websolute.com" alt="eCommerce"><img src="<?php Custom\image_path('DigitalMarketing.png', false); ?>"></a>
        </footer>
        <!-- /Footer -->
        
    </div>
    <!-- /Wrapper -->

    <?php wp_footer(); ?>
</body>
</html>