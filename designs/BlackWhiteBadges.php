<?php

use League\ColorExtractor\Color;

class SMPG_BlackWhiteBadges implements SMPG_IDesignData
{
    public function smpg_fillData($screen, $post, $data)
    {
        $fontPair = SMPG_Font::smpg_getFontPair();
        $xOffset = rand(-40, 40);
        $yOffset = rand(70, $screen->smpg_getHeight() - 500);

        //basic        
        $size = getimagesize(plugin_dir_path(__FILE__) . 'tmp/image.png');
        $data['imageHeight'] = $size[1];
        $data['imageWidth'] = $size[0];

        $data['texts'] = array();
        $data['labels'] = array();
        $data['rects'] = array();

        // title
        $data['labels'][0] = array();
        $data['labels'][0]['attrsText'] = array();
        $data['labels'][0]['attrs'] = array();
        $data['labels'][0]['attrsText']['text'] = $post->post_title;
        $data['labels'][0]['attrs']['text'] = $post->post_title;
        $data['labels'][0]['name'] = 'Title';
        $data['labels'][0]['inputId'] = $data['id'] . '_' . md5(time() + rand(0, 1000000));
        $data['labels'][0]['attrsText']['fontFamily'] = $fontPair['primary']->smpg_getFontFamily();
        $data['labels'][0]['attrsText']['fontSize'] = 120;
        $data['labels'][0]['attrsText']['fontStyle'] = $fontPair['primary']->smpg_getStyle();
        $data['labels'][0]['attrsText']['fill'] = 'white';

        $data['labels'][0]['attrsText']['width'] = $screen->smpg_getWidth() * 0.7 + 45;
        $data['labels'][0]['maxHeight'] = 310;
        $data['labels'][0]['attrsText']['align'] = 'left';

        //  label
        $data['labels'][0]['attrsLabel']['fill'] = 'black';
        $data['labels'][0]['attrsLabel']['x'] = 110 + $xOffset;
        $data['labels'][0]['attrsText']['padding'] = 20;
        $data['labels'][0]['attrsLabel']['y'] = $yOffset;

        // subtitle

        $content =   substr(preg_replace('/[^A-Za-z0-9 ]/', '', strip_tags($post->post_content)), 0, 20) . "[...]";

        $data['labels'][1] = array();
        $data['labels'][1]['attrsText'] = array();
        $data['labels'][1]['attrs'] = array();
        $data['labels'][1]['attrs']['text'] = $content;
        $data['labels'][1]['attrsText']['text'] = $content;
        $data['labels'][1]['name'] = 'Subtitle';
        $data['labels'][1]['inputId'] = $data['id'] . '_' . md5(time() + rand(0, 1000000));
        $data['labels'][1]['attrsText']['fontFamily'] = $fontPair['secondary']->smpg_getFontFamily();
        $data['labels'][1]['attrsText']['fontSize'] = 80;
        $data['labels'][1]['attrsText']['fontStyle'] = $fontPair['secondary']->smpg_getStyle();
        $data['labels'][1]['attrsText']['fill'] = 'black';

        $data['labels'][1]['attrsText']['width'] = $screen->smpg_getWidth() * 0.5;
        $data['labels'][1]['maxHeight'] = 200;
        $data['labels'][1]['attrsText']['align'] = 'left';

        //  label
        $data['labels'][1]['attrsLabel']['fill'] = 'white';
        $data['labels'][1]['attrsLabel']['x'] = 110 + $xOffset;
        $data['labels'][1]['attrsText']['padding'] = 15;
        $data['labels'][1]['attrsLabel']['y'] = 310 + $yOffset;

        return $data;
    }
}
