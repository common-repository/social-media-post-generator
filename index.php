<?php

/**
 * Plugin Name: Social Media Post Generator
 * Plugin URI: https://camerloher.eu/plugins/social-media
 * Description: Create Social Media Posts easily
 * Version: 0.2.3
 * Author: Paul Camerloher
 * Author URI: https://camerloher.eu
 */


include(plugin_dir_path(__FILE__) . 'font/Fonts.php');
include(plugin_dir_path(__FILE__) . 'designs/IDesignData.php');
include(plugin_dir_path(__FILE__) . 'designs/CommonUtils.php');
include(plugin_dir_path(__FILE__) . 'variables/ButtonTexts.php');
include(plugin_dir_path(__FILE__) . 'image-size/PostSizes.php');
include(plugin_dir_path(__FILE__) . 'posts-wp-list-table.php');
include(plugin_dir_path(__FILE__) . 'image-size/ScreenSize.php');
include(plugin_dir_path(__FILE__) . 'designs/BasicDesign.php');
include(plugin_dir_path(__FILE__) . 'designs/BlackWhiteBadges.php');
include(plugin_dir_path(__FILE__) . 'designs/QuoteDesign.php');
include(plugin_dir_path(__FILE__) . 'vendor/autoload.php');
add_action('admin_print_styles', 'smpg_add_fonts');
add_action('admin_menu', 'smpg_setup_admin_panel');
add_action('admin_enqueue_scripts', 'smpg_add_scripts');

use \Gumlet\ImageResize;

function smpg_add_scripts()
{
    wp_enqueue_script('smpg_image-gen', plugins_url('/js/image-gen.js', __FILE__));
    wp_enqueue_script('smpg_konva', plugins_url('/js/konva.js', __FILE__));
}

function smpg_add_fonts()
{
    wp_enqueue_style('smpg_post_size', plugins_url('/css/admin.css', __FILE__));
    foreach (SMPG_Font::smpg_getFonts() as $f) {
        wp_enqueue_style($f->smpg_getFontFamily(), $f->smpg_getUrl());
    }
}
function smpg_setup_admin_panel()
{
    add_menu_page('Social Media Generator', 'Social Media Generator', 'manage_options', 'social-media-generator', 'smpg_init');
}

function smpg_init()
{
    smpg_generateNavTabs();
}

function smpg_generateNavTabs()
{
?>
    <div class="wrap">

        <div id="icon-themes" class="icon32"></div>
        <h1>Social Media Image Generator</h1>
        <?php settings_errors(); ?>

        <?php
        $active_tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'new';
        if (isset($_GET['tab'])) {
            $active_tab = sanitize_text_field($_GET['tab']);
        }
        if ($active_tab == 'generate' && isset($_GET['postId'])) {
            if (get_post(sanitize_text_field($_GET['postId'])) == FALSE) {
                $active_tab = 'new';
            }
        } else {
            $active_tab = 'new';
        }

        ?>

        <h2 class="nav-tab-wrapper">
            <a href="?page=social-media-generator&tab=new" class="nav-tab <?php echo $active_tab == 'new' ? 'nav-tab-active' : ''; ?>">Choose</a>
            <a href="?page=social-media-generator&tab=generate" class="nav-tab <?php echo $active_tab == 'generate' ? 'nav-tab-active' : ''; ?>">Generate</a>
        </h2>

        <?php
        if ($active_tab == 'generate') {
            echo '<button class="button button-primary" style="margin-top: 40px;" onclick="location.reload()">Recreate</button>';
            smpg_generateNew(sanitize_text_field($_GET['postId']));
        } else {
            $list = new SMPG_Wp_List_Table();
            $list->prepare_items();
            $list->display();
        }

        ?>

    </div><!-- /.wrap -->
<?php
}

function smpg_generateNew($post_id)
{
    smpg_createImages($post_id);
}

// more specific data like fonts
function smpg_getData($screen, $post)
{
    $data = array();
    $id = md5(time() + rand(0, 1000000));
    $data['id'] = $id;
    $data['inputs']['genImage'] = 'genImage_' . $id;
    $data['height'] = $screen->smpg_getHeight();
    $data['width'] =  $screen->smpg_getWidth();
    $data['img'] = get_the_post_thumbnail_url($post);

    $types = [new SMPG_BlackWhiteBadges(), new SMPG_BasicDesign(), new SMPG_QuoteDesign()];

    $design = $types[rand(0, 2)];
    $data = $design->smpg_fillData($screen, $post, $data);

    return $data;
}


function smpg_resizeImage($filename, $output)
{
    $image = new ImageResize($filename);
    $image->resizeToHeight(100);
    $image->save($output);
}
// creates the data and corresponding html elements for the images
function smpg_createImages($post_id)
{
    // todo selection
    $post = get_post($post_id);
    $sampleCount = 4;

    // todo
    $img = get_the_post_thumbnail_url($post);
    file_put_contents(plugin_dir_path(__FILE__) . 'designs/tmp/image2.png', file_get_contents(str_replace('8000', '80', $img)));
    smpg_resizeImage(plugin_dir_path(__FILE__) . 'designs/tmp/image2.png', plugin_dir_path(__FILE__) . 'designs/tmp/image.png');
?>
    <div style="width:100%; display:flex; flex-direction:row; flex-wrap:wrap; gap:25px;">
        <?php

        for ($i = 0; $i < $sampleCount; $i++) {

            $screen = SMPG_InstagramPostSizes::smpg_getSquarePost();
            $data = smpg_getData($screen, $post);
        ?>
            <div style="display:flex; flex-direction:column; gap:12px;">
                <div style="margin-top:50px;">
                    <div id=<?php echo '"' . $data['id'] . '"' ?>></div>
                </div>
                <script>
                    <?php
                    echo "generateImage(" . json_encode($data) . ")";
                    ?>
                </script>
            <?php
            echo "<div style=\"display:flex; flex-direction:column;width:150px; gap:6px; margin-top:12px;\">";
            foreach (($data['texts'] + $data['labels']) as $element) {
                if ($element['inputId'] !== -1) {
                    echo "<label for=\"" . $element['inputId'] . "\">" . $element['name'] . "</label>";
                    echo "<input class=\"regular-text code\" id=\"" . $element['inputId'] . "\" value=\"" . $element['attrs']['text'] . "\" />";
                }
            }
            echo "<button class=\"button button-primary\" id=\"" . $data['inputs']['genImage'] . "\">Download Image</button>";
            echo "</div></div>";
        }     ?>
            </div>

        <?php


    }
