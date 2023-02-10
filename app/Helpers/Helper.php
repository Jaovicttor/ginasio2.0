<?php

namespace App\Helpers;

use DateTime;

class Helper
{
    public static function onlyDigitsString($string)
    {
        return preg_replace("/[^0-9]/", '', $string);
    }

    public static function changeFormatDate($date,$from_format,$format)
    {
        if ($date) {
            if (trim($from_format) == 'Y-m-d') {
                $myDateTime = new DateTime($date);
            } else {
                $myDateTime = DateTime::createFromFormat($from_format, $date);
            }
            $date = $myDateTime->format($format);
        }
        return $date;
    }

    public static function removeMask($string, $mask)
    {
        
        switch ($mask){
            case 'money':
                $string = str_replace(".", "", $string);
                $string = str_replace(",", ".", $string);
                $string = str_replace("R$","", $string);
            break;
            case 'percent':
                $string = str_replace(".", "", $string);
                $string = str_replace(",", ".", $string);
                $string = str_replace("%","", $string);
            break;
            case 'document':
                $string = str_replace(".", "", $string);
                $string = str_replace("/", "", $string);
                $string = str_replace("-", "", $string);
            break;
            case 'phone':
                $string = str_replace("-", "", $string);
            break;
            case 'postal_code':
                $string = str_replace("-", "", $string);
            break;
            case 'ddd':
                $string = str_replace("_", "0", $string);
            break;

        }    
        if(empty($string)){
            return null;
        } 
        return trim($string);
    }

    public static function format($string, $type){
        $string = trim($string);
        switch ($type){
            case 'document':
                if (strlen($string)) {
                    if (strlen($string) == 11) {
                        $string =   substr($string, 0, 3) . '.' .
                                    substr($string, 3, 3) . '.' .
                                    substr($string, 6, 3) . '-' .
                                    substr($string, 9, 2);
                    } else if (strlen($string) == 14) {
                        $string =   substr($string, 0, 2) . '.' .
                                    substr($string, 2, 3) . '.' .
                                    substr($string, 5, 3) . '/' .
                                    substr($string, 8, 4) . '-' .
                                    substr($string, -2);
                    }else if (strlen($string) == 8) { //radical do CNPJ
                        $string =   substr($string, 0, 2) . '.' .
                                    substr($string, 2, 3) . '.' .
                                    substr($string, 5, 3) ;
                    }
                }
            break;
            case 'credentialing_code':
                $string = str_pad($string, 4, "0", STR_PAD_LEFT);
                break;
            case 'date':
                if ($string != '') {
                    $string = date('d/m/Y',strtotime($string));
                }
            break;
            case 'hour':
                $string = date('H:i',strtotime($string));
            break;
            case 'time':
                $string = date('H:i:s',strtotime($string));
            break;
            case 'timestamp':
                $string = date('d/m/Y H:i',strtotime($string));
            break;
            case 'timestamp_full':
                $string = date('d/m/Y H:i:s',strtotime($string));
            break;
            case 'postal_code':
                $string =   substr($string, 0, 5) . '-' . substr($string, -3);
            break;
            case 'phone':
                if (strlen($string) == 9) {
                    $string =   substr($string, 0, 5) . '-' .
                                substr($string, -4) ;
                } else if (strlen($string) == 8) {
                    $string =   substr($string, 0, 4) . '-' .
                                substr($string, -4) ;
                }
            break;
            case 'money':
                if(!empty($string))
                    $string = "R$ " . number_format($string, 2, ',', '.');
            break;
            case 'money2':
                if(!empty($string))
                    $string = number_format($string, 2, ',', '.');
            break;
            case 'percent':
                if(!empty($string))
                    $string = number_format($string, 2, ',', '.') . " %";
            break;
            case 'percent2':
                if(!empty($string))
                    $string = number_format($string, 2, ',', '.');
            break;

            case 'billet':
                if(!empty($string))
                    $string = str_replace(' ', '', $string);
        }  
        return trim($string);
    }

    public static function html($information) 
    {   
        $string = '';
        switch (trim($information)){
            case 'required':
                $string = '<span class="text-danger">*</span>';
            break;
            case 'optional':
                $string = '(Opcional)';
            break;
        }
        
        return $string;
    }

    public static function removeAccent($string)
    {
        $from = "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ";
        $to = "aaaaeeiooouucAAAAEEIOOOUUC";

        $keys = array();
        $values = array();
        preg_match_all('/./u', $from, $keys);
        preg_match_all('/./u', $to, $values);
        $mapping = array_combine($keys[0], $values[0]);
        
        return strtr($string, $mapping);
        
    }

    public static function getMonthText($month) 
    {   
        switch ($month) {
            case 1: 
                $month = 'Janeiro';
            break;  
            case 2: 
                $month = 'Fevereiro';
            break;  
            case 3: 
                $month = 'Março';
            break;  
            case 4: 
                $month = 'Abril';
            break;  
            case 5: 
                $month = 'Maio';
            break;  
            case 6: 
                $month = 'Junho';
            break;  
            case 7: 
                $month = 'Julho';
            break;  
            case 8: 
                $month = 'Agosto';
            break;            
            case 9: 
                $month = 'Setembro';
            break;  
            case 10: 
                $month = 'Outubro';
            break;  
            case 11: 
                $month = 'Novembro';
            break; 
            case 12: 
                $month = 'Dezembro';
            break;  

        }

        return $month;
    }

    public static function getYear($date)
    {
        return intval(date('Y',strtotime($date)));
    }

    public static function getDateText($date) 
    {   

        $day = intval(date('d',strtotime($date)));
        $month = intval(date('m',strtotime($date)));
        $year = intval(date('Y',strtotime($date)));
        
        $month = self::getMonthText($month);

        return "{$day} de {$month} de {$year}";

    }

    public static function generatePassword($qtd_characters = 8)
    {
        $smallLetters = str_shuffle('abcdefghijklmnopqrstuvwxyz');
        $capitalLetters = str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ');
        $numbers = (((date('Ymd') / 12) * 24) + mt_rand(800, 9999));
        $numbers .= 1234567890;
        $specialCharacters = str_shuffle('!@#$%*-');

        $characters = $capitalLetters.$smallLetters.$numbers.$specialCharacters;
    

        $password = substr(str_shuffle($characters), 0, $qtd_characters);
    
        return $password;
    }

   
}
