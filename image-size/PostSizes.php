<?php

class SMPG_InstagramPostSizes
{
    public static function smpg_getSquarePost()
    {
        return new SMPG_ScreenSize(1080, 1080);
    }
    public static function smpg_getPortraitPost()
    {
        return new SMPG_ScreenSize(1080, 1350);
    }

}
