<?php

class SMPG_ScreenSize
{

    protected int $width, $height;

    function __construct(int $width, int $height)
    {
        $this->height = $height;
        $this->width = $width;
    }

    public function smpg_getWidth()
    {
        return $this->width;
    }
    public function smpg_getHeight()
    {
        return $this->height;
    }
}
