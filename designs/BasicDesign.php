<?php

use League\ColorExtractor\Color;

class SMPG_BasicDesign implements SMPG_IDesignData
{
  public function smpg_fillData($screen, $post, $data)
  {
    $mainColor = SMPG_CommonUtils::smpg_get_color_palette(plugin_dir_path(__FILE__) . 'tmp/image.png', 10)[rand(0, 9)];
    $mainColor = SMPG_CommonUtils::smpg_getNearestMaterialColor(Color::fromIntToHex($mainColor));
    $fontColor = SMPG_CommonUtils::smpg_getContrastColor($mainColor);
    $fontPair = SMPG_Font::smpg_getFontPair();
    $yOffset = rand(-200, 0);

    //basic        
    $size = getimagesize(plugin_dir_path(__FILE__) . 'tmp/image.png');
    $data['imageHeight'] = $size[1];
    $data['imageWidth'] = $size[0];

    $data['labels'] = array();

    // title
    $data['texts'][0] = array();
    $data['texts'][0]['attrs'] = array();
    $data['texts'][0]['attrs']['text'] = $post->post_title;
    $data['texts'][0]['name'] = 'Title';
    $data['texts'][0]['inputId'] = $data['id'] . '_' . md5(time() + rand(0, 1000000));
    $data['texts'][0]['attrs']['fontFamily'] = $fontPair['primary']->smpg_getFontFamily();
    $data['texts'][0]['attrs']['fontSize'] = 100;
    $data['texts'][0]['attrs']['fontStyle'] = $fontPair['primary']->smpg_getStyle();
    $data['texts'][0]['attrs']['fill'] = $fontColor;

    $data['texts'][0]['attrs']['width'] = $screen->smpg_getWidth();
    $data['texts'][0]['maxHeight'] = 300;
    $data['texts'][0]['attrs']['padding'] = 40;
    $data['texts'][0]['attrs']['align'] = 'center';

    $data['texts'][0]['attrs']['x'] = 0;
    $data['texts'][0]['attrs']['y'] = $screen->smpg_getHeight() - 480 + $yOffset;

    // subtitle
    $data['texts'][1] = array();
    $data['texts'][1]['attrs'] = array();
    $data['texts'][1]['attrs']['text'] =  substr(preg_replace('/[^A-Za-z0-9 ]/', '', strip_tags($post->post_content)), 0, 70) . "[...]";
    $data['texts'][1]['name'] = 'Subtitle';
    $data['texts'][1]['inputId'] = $data['id'] . '_' . md5(time() + rand(0, 1000000));
    $data['texts'][1]['attrs']['fontFamily'] = $fontPair['secondary']->smpg_getFontFamily();
    $data['texts'][1]['attrs']['fontSize'] = 50;
    $data['texts'][1]['attrs']['fontStyle'] = $fontPair['secondary']->smpg_getStyle();
    $data['texts'][1]['attrs']['fill'] = $fontColor;

    $data['texts'][1]['attrs']['width'] = $screen->smpg_getWidth();
    $data['texts'][1]['maxHeight'] = 200;
    $data['texts'][1]['attrs']['padding'] = 40;
    $data['texts'][1]['attrs']['align'] = 'center';

    $data['texts'][1]['attrs']['x'] = 0;
    $data['texts'][1]['attrs']['y'] = $screen->smpg_getHeight() - 240 + $yOffset;


    // blog url
    /*  $data['texts'][2] = array();
        $data['texts'][2]['attrs'] = array();
        $data['texts'][2]['inputId'] = -1;
        $data['texts'][2]['attrs']['text'] = get_home_url();
        $data['texts'][2]['attrs']['fontFamily'] =  $fontPair['secondary']->getFontFamily();
        $data['texts'][2]['attrs']['fontSize'] = 35;
        $data['texts'][2]['attrs']['fontStyle'] =  $fontPair['secondary']->getStyle();
        $data['texts'][2]['attrs']['fill'] = $fontColor;

        $data['texts'][2]['attrs']['width'] = $screen->smpg_getWidth();
        $data['texts'][2]['maxHeight'] = 500;
        $data['texts'][2]['attrs']['padding'] = 20;
        $data['texts'][2]['attrs']['align'] = 'left';

        $data['texts'][2]['attrs']['x'] = 0;
        $data['texts'][2]['attrs']['y'] = $screen->smpg_getHeight() - 60 + $yOffset;
*/

    // rect
    $data['rects'] = array();
    $data['rects'][0]['attrs'] = array();
    $data['rects'][0]['attrs']['width'] = $screen->smpg_getWidth();
    $data['rects'][0]['attrs']['height'] = 400;
    $data['rects'][0]['attrs']['x'] = 0;
    $data['rects'][0]['attrs']['y'] = $screen->smpg_getHeight() - 480 + $yOffset;
    $data['rects'][0]['attrs']['fill'] = $mainColor;
    $data['rects'][0]['attrs']['opacity'] = rand(90, 100) / 100;

    return $data;
  }
}
