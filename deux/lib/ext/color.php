<?php

/**
 * Modify by QedQod
 * Author: Arlo Carreon <http://arlocarreon.com>
 * Info: http://mexitek.github.io/phpColors/
 * License: http://arlo.mit-license.org/
 */

/**
 * A color utility that helps manipulate HEX colors
 */
class Deux_Color {

    private $_hex;
    private $_hsl;
    private $_rgb;

    /**
     * Auto darkens/lightens by 10% for sexily-subtle gradients.
     * Set this to FALSE to adjust automatic shade to be between given color
     * and black (for darken) or white (for lighten)
     */
    const DEFAULT_ADJUST = 10;

    /**
     * Instantiates the class with a HEX value
     * @param string $hex
     * @throws Exception "Bad color format"
     */
    function __construct( $hex ) {
        // Strip # sign is present
        $color = str_replace("#", "", $hex);

        // Make sure it's 6 digits
        if( strlen($color) === 3 ) {
            $color = $color[0].$color[0].$color[1].$color[1].$color[2].$color[2];
        } else if( strlen($color) != 6 ) {
            throw new Exception("HEX color needs to be 6 or 3 digits long");
        }

        $this->_hsl = self::hexToHsl( $color );
        $this->_hex = $color;
        $this->_rgb = self::hexToRgb( $color );
    }

    // ====================
    // = Public Interface =
    // ====================

    /**
     * Given a HEX string returns a HSL array equivalent.
     * @param string $color
     * @return array HSL associative array
     */
    public static function hexToHsl( $color ){

        // Sanity check
        $color = self::_checkHex($color);

        // Convert HEX to DEC
        $R = hexdec($color[0].$color[1]);
        $G = hexdec($color[2].$color[3]);
        $B = hexdec($color[4].$color[5]);

        $HSL = array();

        $var_R = ($R / 255);
        $var_G = ($G / 255);
        $var_B = ($B / 255);

        $var_Min = min($var_R, $var_G, $var_B);
        $var_Max = max($var_R, $var_G, $var_B);
        $del_Max = $var_Max - $var_Min;

        $L = ($var_Max + $var_Min)/2;

        if ($del_Max == 0)
        {
            $H = 0;
            $S = 0;
        }
        else
        {
            if ( $L < 0.5 ) $S = $del_Max / ( $var_Max + $var_Min );
            else            $S = $del_Max / ( 2 - $var_Max - $var_Min );

            $del_R = ( ( ( $var_Max - $var_R ) / 6 ) + ( $del_Max / 2 ) ) / $del_Max;
            $del_G = ( ( ( $var_Max - $var_G ) / 6 ) + ( $del_Max / 2 ) ) / $del_Max;
            $del_B = ( ( ( $var_Max - $var_B ) / 6 ) + ( $del_Max / 2 ) ) / $del_Max;

            if      ($var_R == $var_Max) $H = $del_B - $del_G;
            else if ($var_G == $var_Max) $H = ( 1 / 3 ) + $del_R - $del_B;
            else if ($var_B == $var_Max) $H = ( 2 / 3 ) + $del_G - $del_R;

            if ($H<0) $H++;
            if ($H>1) $H--;
        }

        $HSL['H'] = ($H*360);
        $HSL['S'] = $S;
        $HSL['L'] = $L;

        return $HSL;
    }

    /**
     *  Given a HSL associative array returns the equivalent HEX string
     * @param array $hsl
     * @return string HEX string
     * @throws Exception "Bad HSL Array"
     */
    public static function hslToHex( $hsl = array() ){
         // Make sure it's HSL
        if(empty($hsl) || !isset($hsl["H"]) || !isset($hsl["S"]) || !isset($hsl["L"]) ) {
            throw new Exception("Param was not an HSL array");
        }

        list($H,$S,$L) = array( $hsl['H']/360,$hsl['S'],$hsl['L'] );

        if( $S == 0 ) {
            $r = $L * 255;
            $g = $L * 255;
            $b = $L * 255;
        } else {

            if($L<0.5) {
                $var_2 = $L*(1+$S);
            } else {
                $var_2 = ($L+$S) - ($S*$L);
            }

            $var_1 = 2 * $L - $var_2;

            $r = round(255 * self::_huetorgb( $var_1, $var_2, $H + (1/3) ));
            $g = round(255 * self::_huetorgb( $var_1, $var_2, $H ));
            $b = round(255 * self::_huetorgb( $var_1, $var_2, $H - (1/3) ));

        }

        // Convert to hex
        $r = dechex($r);
        $g = dechex($g);
        $b = dechex($b);

        // Make sure we get 2 digits for decimals
        $r = (strlen("".$r)===1) ? "0".$r:$r;
        $g = (strlen("".$g)===1) ? "0".$g:$g;
        $b = (strlen("".$b)===1) ? "0".$b:$b;

        return $r.$g.$b;
    }


    /**
     * Given a HEX string returns a RGB array equivalent.
     * @param string $color
     * @return array RGB associative array
     */
    public static function hexToRgb( $color ){

        // Sanity check
        $color = self::_checkHex($color);

        // Convert HEX to DEC
        $R = hexdec($color[0].$color[1]);
        $G = hexdec($color[2].$color[3]);
        $B = hexdec($color[4].$color[5]);

        $RGB['R'] = $R;
        $RGB['G'] = $G;
        $RGB['B'] = $B;

        return $RGB;
    }


    /**
     *  Given an RGB associative array returns the equivalent HEX string
     * @param array $rgb
     * @return string RGB string
     * @throws Exception "Bad RGB Array"
     */
    public static function rgbToHex( $rgb = array() ){
         // Make sure it's RGB
        if(empty($rgb) || !isset($rgb["R"]) || !isset($rgb["G"]) || !isset($rgb["B"]) ) {
            throw new Exception("Param was not an RGB array");
        }

        // https://github.com/mexitek/phpColors/issues/25#issuecomment-88354815
        // Convert RGB to HEX
        $hex[0] = str_pad(dechex($rgb['R']), 2, '0', STR_PAD_LEFT);
        $hex[1] = str_pad(dechex($rgb['G']), 2, '0', STR_PAD_LEFT);
        $hex[2] = str_pad(dechex($rgb['B']), 2, '0', STR_PAD_LEFT);

        return implode( '', $hex );

  }

    /**
     * Build a background or color-gradient style for CSS
     * 
     * @param  int $angle        
     * @param  string $color_one    hex color value
     * @param  strng $color_two    hex color value
     * @param  int $position_one
     * @param  int $position_two 
     * @return string
     *    
     * get_theme_mod( 'my_gradient', [ 'angle'=> '0', 'start' => ['color' => '', 'position' => ''], 'end' => ''  ] ) 
     */
    public static function makeGradient( $property, $color_1, $color_2 ) {
        
        if( $property == 'background' ) {
            $styles  = "background: {$color_1};";
            $styles .= "background:-moz-linear-gradient( 45deg, {$color_1} 0%, {$color_2} 100% );";
            $styles .= "background:-webkit-linear-gradient( 45deg, {$color_1} 0%, {$color_2} 100% );";
            $styles .= "background:-o-linear-gradient(45deg, {$color_1} 0%, {$color_2} 100% );";
            $styles .= "background:-ms-linear-gradient(45deg, {$color_1} 0%, {$color_2} 100% );";
            $styles .= "background:linear-gradient( 45deg, {$color_1} 0%, {$color_2} 100% );";
        }

        if( $property == 'color' ) {
            $styles = "background:-moz-linear-gradient( 45deg, {$color_1} 0%, {$color_2} 100% );";
            $styles .= "background:-webkit-linear-gradient( 45deg, {$color_1} 0%, {$color_2} 100% );";
            $styles .= "background:-o-linear-gradient(45deg, {$color_1} 0%, {$color_2} 100% );";
            $styles .= "background:-ms-linear-gradient(45deg, {$color_1} 0%, {$color_2} 100% );";
            $styles .= "background:linear-gradient( 45deg, {$color_1} 0%, {$color_2} 100% );";
            $styles .= '-webkit-background-clip: text;';
            $styles .= 'color: transparent;';
        }

        return $styles;
    }

    /**
     * Returns the complimentary color
     * @return string Complementary hex color
     *
     */
    public function complementary() {
        // Get our HSL
        $hsl = $this->_hsl;

        // Adjust Hue 180 degrees
        $hsl['H'] += ($hsl['H']>180) ? -180:180;

        // Return the new value in HEX
        return self::hslToHex($hsl);
    }
    
    /**
     * Returns your color's HSL array
     */
    public function getHsl() {
        return $this->_hsl;
    }
    /**
     * Returns your original color
     */
    public function getHex() {
        return $this->_hex;
    }
    /**
     * Returns your color's RGB array
     */
    public function getRgb() {
        return $this->_rgb;
    }

    // ===========================
    // = Private Functions Below =
    // ===========================

    /**
     * Given a Hue, returns corresponding RGB value
     * @param int $v1
     * @param int $v2
     * @param int $vH
     * @return int
     */
    private static function _huetorgb( $v1,$v2,$vH ) {
        if( $vH < 0 ) {
            $vH += 1;
        }

        if( $vH > 1 ) {
            $vH -= 1;
        }

        if( (6*$vH) < 1 ) {
               return ($v1 + ($v2 - $v1) * 6 * $vH);
        }

        if( (2*$vH) < 1 ) {
            return $v2;
        }

        if( (3*$vH) < 2 ) {
            return ($v1 + ($v2-$v1) * ( (2/3)-$vH ) * 6);
        }

        return $v1;

    }

    /**
     * You need to check if you were given a good hex string
     * @param string $hex
     * @return string Color
     * @throws Exception "Bad color format"
     */
    private static function _checkHex( $hex ) {
        // Strip # sign is present
        $color = str_replace("#", "", $hex);

        // Make sure it's 6 digits
        if( strlen($color) == 3 ) {
            $color = $color[0].$color[0].$color[1].$color[1].$color[2].$color[2];
        } else if( strlen($color) != 6 ) {
            throw new Exception("HEX color needs to be 6 or 3 digits long");
        }

        return $color;
    }
    

}