<?php

namespace Scipper\Colorizer;

/**
 * Class Colorizer
 *
 * @author Steffen Kowalski <scipper@myscipper.de>
 *
 * @namespace Scipper\Colorizer
 * @package Scipper\Colorizer
 */
class Colorizer {

    const FG_BLACK = "0;30";
    const FG_DARK_GRAY = "1;30";
    const FG_BLUE = "0;34";
    const FG_LIGHT_BLUE = "1;34";
    const FG_GREEN = "0;32";
    const FG_LIGHT_GREEN = "1;32";
    const FG_CYAN = "0;36";
    const FG_LIGHT_CYAN = "1;36";
    const FG_RED = "0;31";
    const FG_LIGHT_RED = "1;31";
    const FG_PURPLE = "0;35";
    const FG_LIGHT_PURPLE = "1;35";
    const FG_BROWN = "0;33";
    const FG_YELLOW = "1;33";
    const FG_LIGHT_GRAY = "0;37";
    const FG_WHITE = "1;37";
    const FG_ORANGE = "38;5;208;48";

    const BG_BLACK = "40";
    const BG_RED = "41";
    const BG_GREEN = "42";
    const BG_YELLOW = "43";
    const BG_BLUE = "44";
    const BG_MAGENTA = "45";
    const BG_CYAN = "46";
    const BG_LIGHT_GRAY = "47";

    /**
     *
     * @var boolean
     */
    protected $isWindows;


    /**
     * Colorizer constructor.
     *
     * @param bool $isWindows
     */
    public function __construct($isWindows = false) {
        $this->isWindows = $isWindows;
    }

    /**
     *
     * @param string $string
     * @param string $foregroundColor
     * @param string $backgroundColor
     * @return string
     */
    public function cecho($string, $foregroundColor = NULL, $backgroundColor = NULL) {
        echo $this->colorize($string, $foregroundColor, $backgroundColor);
    }

    /**
     * @param $string
     * @param string $foregroundColor
     * @param string $backgroundColor
     *
     * @return string
     */
    public function colorize($string, $foregroundColor = NULL, $backgroundColor = NULL) {
        $coloredString = "";
        $fgConst = $this->getConstName($foregroundColor);
        if(!is_null($fgConst) && !$this->isWindows) {
            $coloredString .= "\033[" . constant("self::" . $fgConst) . "m";
        }

        $bgConst = $this->getConstName($backgroundColor);
        if(!is_null($bgConst) && !$this->isWindows) {
            $coloredString .= "\033[" . constant("self::" . $bgConst) . "m";
        }

        $coloredString .=  $string;

        if(!$this->isWindows) {
            $coloredString .=  "\033[0m";
        }

        return $coloredString;
    }

    /**
     * @param $lines
     */
    public function linesUp($lines) {
        echo "\033[" . $lines . "A";
    }

    /**
     * @param $lines
     */
    public function linesDown($lines) {
        echo "\033[" . $lines . "B";
    }

    /**
     *
     * @param string $search
     * @return string|NULL
     */
    public function getConstName($search) {
        $class = new \ReflectionClass(__CLASS__);
        $constants = $class->getConstants();

        $constName = NULL;
        foreach($constants as $name => $value) {
            if($value == $search) {
                $constName = $name;
                break;
            }
        }

        return $constName;
    }

    /**
     * @return boolean
     */
    public function isWindows() {
        return (boolean) $this->isWindows;
    }

    /**
     * @param boolean $isWindows
     */
    public function setIsWindows($isWindows) {
        $this->isWindows = (boolean) $isWindows;
    }

    /**
     *
     */
    public function hide() {
        if(!$this->isWindows) {
            system("stty -echo");
        }
    }

    /**
     *
     */
    public function restore() {
        if(!$this->isWindows) {
            system("stty echo");
        }
    }

}