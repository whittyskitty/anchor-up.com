<?php 

//header Style: https://braydoncoyer.dev/blog/build-a-glassmorphic-navbar-with-tailwindcss-backdrop-filter-and-backdrop-blur
?>
<div class="mx-auto container px-4">
    <div class="lg:flex lg:justify-between lg:items-center py-6">
        <div class="flex justify-between items-center">
            <div>
                <?php 
                if ($theme_options['site_logo']) {
                        echo "<a href='/'>";
                            echo wp_get_attachment_image( $theme_options['site_logo'], array(300,60) );
                        echo "</a>";
                    } else {
                        echo AloeHelpers::front_end_error("Site Logo Not Set: <a style='color:blue;' href='/wp-admin/admin.php?page=acf-options'>SET IT HERE</a>");
                    }
                    /* 
                    <div class="text-lg uppercase">
                        <a href="<?php echo get_bloginfo( 'url' ); ?>" class="font-extrabold text-lg uppercase">
                            <?php echo get_bloginfo( 'name' ); ?>
                        </a>
                    </div>

                    <p class="text-sm font-light text-gray-600">
                        <?php echo get_bloginfo( 'description' ); ?>
                    </p>
                    */ 
                ?>
            </div>

            <div class="lg:hidden z-20 text-aloe-blue-dark">
                <a href="#" aria-label="Toggle navigation" id="primary-menu-toggle">
                    <svg viewBox="0 0 20 20" class="inline-block w-6 h-6" version="1.1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <g stroke="none" stroke-width="1" fill="currentColor" fill-rule="evenodd">
                            <g id="icon-shape">
                                <path d="M0,3 L20,3 L20,5 L0,5 L0,3 Z M0,9 L20,9 L20,11 L0,11 L0,9 Z M0,15 L20,15 L20,17 L0,17 L0,15 Z"
                                        id="Combined-Shape"></path>
                            </g>
                        </g>
                    </svg>
                </a>
            </div>
        </div>

        <?php
        wp_nav_menu(
            array(
                'container_id'    => 'primary-menu',
                'container_class' => 'hidden mt-4 p-4 bg-white absolute right-0 top-0 w-3/5 lg:w-auto z-10 h-full lg:relative lg:mt-0 lg:p-0 lg:bg-transparent lg:block',
                'menu_class'      => 'primary-menu lg:flex lg:-mx-4 pt-12 lg:p-0',
                'theme_location'  => 'primary',
                'li_class'        => 'lg:mx-4 flex align-center text-aloe-green-dark hover:text-aloe-blue-dark',
                'fallback_cb'     => false,
                'list_item_class'  => 'nav-item',
                'link_class'   => 'block self-center w-full py-4 lg:p-0'
            )
        );
        ?>
    </div>
    <style>
        #primary-menu {
            z-index:100;
            text-align: left;
            font-family: Helvetica Neue;
            font-style: normal;
            font-weight: bold;
            font-size: 24px;
        }
    </style>
</div>

<?php 