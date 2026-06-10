<?php

/**
 * 主题页眉
 * @author Seaton Jiang <hi@seatonjiang.com>
 * @license GPL-3.0 License
 * @version 2023.03.30
 */
?>
<!DOCTYPE html>
<html lang="<?php bloginfo('language'); ?>">

<head>
    <meta charset="UTF-8">
    <script>
        (function () {
            try {
                var t = localStorage.getItem('kratos-theme');
                if (t === 'dark' || t === 'light') {
                    document.documentElement.setAttribute('data-theme', t);
                }
            } catch (e) { }
        })();
    </script>
    <title><?php wp_title('-', true, 'right'); ?></title>
    <?php
    $ogImage = is_home() || !have_posts() ? kratos_option('seo_shareimg', ASSET_PATH . '/assets/img/default.jpg') : share_thumbnail_url();
    $ogUrl = is_home() || !have_posts() ? get_site_url() : get_the_permalink();
    $ogTitle = is_home() && is_front_page() ? get_bloginfo('name') : get_the_title();

    echo '<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">';
    echo '<meta name="format-detection" content="telphone=no, date=no, address=no, email=no">';
    echo '<meta name="theme-color" content="' . kratos_option('g_chrome', '#282a2c') . '">';
    echo '<meta name="keywords" itemprop="keywords" content="' . keywords() . '">';
    echo '<meta name="description" itemprop="description" content="' . description() . '">';
    echo '<meta itemprop="image" content="' .  $ogImage . '">';

    echo '<meta property="og:site_name" content="' . get_bloginfo('name') . '">';
    echo '<meta property="og:url" content="' . $ogUrl . '">';
    echo '<meta property="og:title" content="' . $ogTitle . '">';
    echo '<meta property="og:image" content="' . $ogImage . '">';
    echo '<meta property="og:image:type" content="image/webp">';
    echo '<meta property="og:locale" content="' . get_bloginfo('language') . '">';

    echo '<meta name="twitter:card" content="summary_large_image">';
    echo '<meta name="twitter:title" content="' . $ogTitle . '">';

    if (is_single() || is_singular()) {
        global $post;
        $author_id = $post->post_author;
        echo '<meta name="twitter:creator" content="' . get_the_author_meta('nickname',  $author_id) . '">';
    }

    if (kratos_option('g_icon')) {
        echo '<link rel="shortcut icon" href="' . kratos_option("g_icon") . '">';
    }
    wp_head();
    wp_print_scripts('jquery');
    mourning();
    if (kratos_option('seo_statistical')) {
        echo kratos_option('seo_statistical');
    }
    ?>
</head>
<?php flush(); ?>

<body>
    <div class="k-header">
        <nav class="k-nav navbar navbar-expand-lg navbar-light fixed-top" <?php echo kratos_option('top_img_switch', true) ? '' : 'style="background:' . kratos_option('top_color', '#24292e') . '"'; ?>>
            <div class="container">
                <a class="navbar-brand" href="<?php echo get_option('home'); ?>">
                    <?php
                    if (kratos_option('g_logo')) {
                        echo '<img src="' . kratos_option('g_logo') . '"><h1 style="display:none">' . get_bloginfo('name') . '</h1>';
                    } else {
                        echo '<h1>' . get_bloginfo('name') . '</h1>';
                    }
                    ?>
                </a>
                <button class="k-theme-toggle" type="button" aria-label="<?php esc_attr_e('切换主题', 'kratos'); ?>" title="<?php esc_attr_e('切换主题', 'kratos'); ?>">
                    <svg class="icon-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                    </svg>
                    <svg class="icon-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="12" cy="12" r="5"></circle>
                        <line x1="12" y1="1" x2="12" y2="3"></line>
                        <line x1="12" y1="21" x2="12" y2="23"></line>
                        <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
                        <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
                        <line x1="1" y1="12" x2="3" y2="12"></line>
                        <line x1="21" y1="12" x2="23" y2="12"></line>
                        <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
                        <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
                    </svg>
                </button>
                <?php if (has_nav_menu('header_menu')) { ?>
                    <button class="navbar-toggler navbar-toggler-right" id="navbutton" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="line first-line"></span>
                        <span class="line second-line"></span>
                        <span class="line third-line"></span>
                    </button>
                <?php }
                if (has_nav_menu('header_menu')) {
                    wp_nav_menu(array(
                        'theme_location'  => 'header_menu',
                        'depth'           => 2,
                        'container'       => 'div',
                        'container_class' => 'collapse navbar-collapse',
                        'container_id'    => 'navbarResponsive',
                        'menu_class'      => 'navbar-nav ml-auto',
                        'walker'          => new WP_Bootstrap_Navwalker(),
                    ));
                }
                ?>
            </div>
        </nav>
        <?php if (kratos_option('top_img_switch', true)) { ?>
            <div class="banner">
                <div class="overlay"></div>
                <div class="content text-center" style="background-image: url(<?php echo kratos_option('top_img', ASSET_PATH . '/assets/img/background.jpg'); ?>);">
                    <div class="introduce animate__animated animate__fadeInUp">
                        <?php
                        if (is_category() || is_tag()) {
                            echo '<div class="title">' . single_cat_title('', false) . '</div>';
                            echo '<div class="mate">' . strip_tags(category_description()) . '</div>';
                        } else {
                            echo '<div class="title">' . kratos_option('top_title', 'Kratos') . '</div>';
                            echo '<div class="mate">' . kratos_option('top_describe', __('专注于用户阅读体验的响应式博客主题', 'kratos')) . '</div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>