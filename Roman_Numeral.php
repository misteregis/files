<?php

class Roman_Numeral
{
    protected static $numeral = array(
        'I' => 1,
        'V' => 5,
        'X' => 10,
        'L' => 50,
        'C' => 100,
        'D' => 500,
        'M' => 1000
    );

    /**
     * Detects and converts Roman numerals
     *
     * @param  string/integer/array  $roman - The Roman numeral to convert
     *
     * Examples:
     *   Roman_Numeral::filter(1598) // Number or string to Roman numerals
     *   Roman_Numeral::filter('MDXCVIII') // Roman numerals to Number
     *   Roman_Numeral::filter(array('numberToRoman' => 1598, 'RomanToNumber' => 'MDXCVIII')) // Array
     *   Roman_Numeral::filter(array(1598, 'MDXCVIII')) // Array (1598 -> 'MDXCVIII' and 'MDXCVIII' -> 1598)
     */
    public function filter($roman)
    {
        if (is_array($roman)) {
            return array_map("self::filter", $roman);
        } else {
            if (is_numeric($roman)) {
                if ($roman > 3999)
                    return 'Maximum: 3,999 (MMMCMXCIX)';
                return self::toRoman($roman);
            } else {
                if (strlen($roman) > 9)
                    return 'Maximum: MMMCMXCIX (3,999)';
                return self::toNumber($roman);
            }
        }
    }

    /**
     * Converts a Roman numeral to a number
     *
     */
    private function toNumber($roman)
    {
        $r = strtoupper($roman);$s = 0;$l = 0;
        if (strlen($r) > 9) return 'Maximum: MMMCMXCIX (3,999)';
        foreach(str_split(strrev($r)) as $a) {
            $n = self::$numeral[$a];
            if ($n < $l)
                $s -= $n;
            else
                $s += $n;
            $l = $n;
        }
        return $s;
    }

    /**
     * Converts a number to Roman numeral
     *
     */
    private function toRoman($roman)
    {
        $n = intval($roman);
        $c = array_keys(self::$numeral);
        if ($n > 3999) return 'Maximum: 3,999 (MMMCMXCIX)';
        for($a=5,$b=0,$s='';$n;$b++,$a^=7)
            for($o=$n%$a,$n=$n/$a^0;$o--;$s=$c[$o>2?$b+$n-($n&=-2)+$o=1:($b>0?$b:0)].$s);
        return $s;
    }
}

// Example with array (key=>value)
echo '<pre>',print_r(
    Roman_Numeral::filter([
        'numberToRoman'=>1598,
        'RomanToNumber'=>'MDXCVIII'
    ]),
true),'</pre>';
