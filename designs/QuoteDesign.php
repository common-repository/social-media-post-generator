<?php

use League\ColorExtractor\Color;

class SMPG_QuoteDesign implements SMPG_IDesignData
{
    public function smpg_fillData($screen, $post, $data)
    {
        $mainColor = SMPG_CommonUtils::smpg_get_color_palette(plugin_dir_path(__FILE__) . 'tmp/image.png', 10)[rand(0, 9)];
        $mainColor = Color::fromIntToHex($mainColor);

        $fontColor = SMPG_CommonUtils::smpg_getContrastColor($mainColor);
        $fontPair = SMPG_Font::smpg_getFontPair();


        $xOffset = rand(-40, 40);
        $yOffset = rand(100, $screen->smpg_getHeight() - 400);

        //basic        
        $size = getimagesize(plugin_dir_path(__FILE__) . 'tmp/image.png');
        $data['imageHeight'] = $size[1];
        $data['imageWidth'] = $size[0];
        $data['blurRadius'] = 30;

        $data['texts'] = array();
        $data['labels'] = array();
        $data['rects'] = array();

        // title
        $data['texts'][0] = array();
        $data['texts'][0]['attrs'] = array();
        $data['texts'][0]['attrs'] = array();
        $data['texts'][0]['attrs']['text'] = $post->post_title;
        $data['texts'][0]['attrs']['text'] = $post->post_title;
        $data['texts'][0]['name'] = 'Title';
        $data['texts'][0]['inputId'] = $data['id'] . '_' . md5(time() + rand(0, 1000000));
        $data['texts'][0]['attrs']['fontFamily'] = $fontPair['primary']->smpg_getFontFamily();
        $data['texts'][0]['attrs']['fontSize'] = 170;
        $data['texts'][0]['attrs']['fontStyle'] = $fontPair['primary']->smpg_getStyle();
        $data['texts'][0]['attrs']['fill'] = 'white';

        $data['texts'][0]['attrs']['width'] = $screen->smpg_getWidth() - 100 - 60;
        $data['texts'][0]['maxHeight'] = $screen->smpg_getHeight() / 13 * 5 -80;
        $data['texts'][0]['attrs']['align'] = 'center';
        $data['texts'][0]['attrs']['x'] = 50  + 30;
        $data['texts'][0]['attrs']['y'] = $screen->smpg_getHeight() / 13 * 4 + 45;


        //rect
        $data['rects'][0]['attrs']['width'] = $screen->smpg_getWidth() - 100;
        $data['rects'][0]['attrs']['height'] = $screen->smpg_getHeight() / 13 * 5;
        $data['rects'][0]['attrs']['x'] = 50;
        $data['rects'][0]['attrs']['y'] =  $screen->smpg_getHeight() / 13 * 4;
        $data['rects'][0]['attrs']['fill'] = $mainColor;
        $data['rects'][0]['attrs']['opacity'] = 100;
        $data['rects'][0]['attrs']['cornerRadius'] = rand(10, 70);
        //$data['rects'][0]['attrs']['stroke'] = "black";
        //$data['rects'][0]['attrs']['strokeWidth'] = "0";

        return $data;
    }
}
