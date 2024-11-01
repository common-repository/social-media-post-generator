<?php
class SMPG_Font
{

    protected static $fonts = null;

    protected $fontFamily, $url, $weight, $style;

    function __construct($f, $weight = "400", $style = "normal", $e = "")
    {
        $this->fontFamily = $f;
        $this->url = 'https://fonts.googleapis.com/css2?family=' . str_replace(' ', '+', $f) . $e;
        $this->weight = $weight;
        $this->style = $style;
    }

    public function smpg_getFontFamily()
    {
        return $this->fontFamily;
    }
    public function smpg_getUrl()
    {
        return $this->url;
    }

    public function smpg_getStyle()
    {
        return $this->weight . " " . $this->style;
    }


    static function smpg_createFonts()
    {
        SMPG_Font::$fonts = array();

        array_push(SMPG_Font::$fonts, new SMPG_Font('Roboto'));
        //array_push(SMPG_Font::$fonts, new SMPG_Font('Dela Gothic One'));
        //array_push(SMPG_Font::$fonts, new SMPG_Font('Train One'));
        array_push(SMPG_Font::$fonts, new SMPG_Font('Oswald', '500', 'normal', ':wght@500'));
        array_push(SMPG_Font::$fonts, new SMPG_Font('Merriweather'));
        array_push(SMPG_Font::$fonts, new SMPG_Font('Noto Serif', '400', 'italic', ':ital@1'));
    }

    public static function smpg_getFonts()
    {

        if (is_null(SMPG_Font::$fonts)) {
            SMPG_Font::smpg_createFonts();
        }

        return SMPG_Font::$fonts;
    }

    public static function smpg_getFontPair()
    {
        if (is_null(SMPG_Font::$fonts)) {
            SMPG_Font::smpg_createFonts();
        }

        $ret = array();
        $ret['primary'] = SMPG_Font::$fonts[rand(0, sizeof(SMPG_Font::$fonts) - 1)];
        $ret['secondary'] = SMPG_Font::$fonts[rand(0, sizeof(SMPG_Font::$fonts) - 1)];

        return $ret;
    }
}
