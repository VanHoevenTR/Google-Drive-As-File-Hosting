<?php

/**
 * Class Name: KZ_Crypt
 * Author: Killer
**/

class KZ_Crypt {

    public $_text = '';
    public $_key = 'f_pk_ZingTV_2_@z';
    public $_iv = 'f_iv_ZingTV_2_@z';
    
    //Kết quả trả về
    public $_result = '';
    
    /**
     * Hàm mã hoá
    **/
    public function _encrypt() {
        if($this->_text != '') {
            $cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
            $iv_size = mcrypt_enc_get_iv_size($cipher);
            if (mcrypt_generic_init($cipher, $this->_key, $this->_iv) != -1){
                $cipherText = @mcrypt_generic($cipher,$this->_text);
                mcrypt_generic_deinit($cipher);
                $this->_result = bin2hex($cipherText);
                return true;
            }
        }else{
            return false;
        }
    }
    
    /**
     * Hàm giải mã
    **/
    public function _decrypt(){
        if($this->_text != ''){
            $cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
            $iv_size = mcrypt_enc_get_iv_size($cipher);
            if(mcrypt_generic_init($cipher, $this->_key, $this->_iv) != -1){
                $cipherText = @mdecrypt_generic($cipher,$this->_hexToString($this->_text));
                mcrypt_generic_deinit($cipher);
                $this->_result = $cipherText;
                return true;
            }else{
                return false;
            }
        }
    }
    
    /**
     * Hàm chuyển đổi từ mã hex sang chuỗi.
    **/
    protected function _hexToString($hex){
        if(!is_string($hex)){
            return null;
        }
        $char = '';
        for($i=0; $i<strlen($hex);$i+=2){
            $char .= chr(hexdec($hex{$i}.$hex{($i+1)}));
        }
        return $char;
    }
}

/*

$kz_crypt = new KZ_Crypt;

$kz_crypt->_text = 'ABC';

//Bắt đầu mã hoá.
if($kz_crypt->_encrypt() != false){
    //Kết quả trả về.
    echo $kz_crypt->_result;
}





$kz_crypt = new KZ_Crypt;

$kz_crypt->_text = '3846258a1761dcc417a1b749a438bdbbec04bd989a10ad94b9da7127d38571ba2f2afcbbed7e719963b69f42e24a3721c4fe15260a48ffa69c8f87b5c52148e71469fc0d538854324121f4b565085c57eae19cfe9fa48388f1c06cf82c573e818902be0e3d2e83111b16965ab9aa91150760a05cda89bb7e1ad3341b30185a6cde311dfc8de9e27d103397d3e927582930692185d7c9aea74d017da18ea12b16';

//Bắt đầu giải mã.
if($kz_crypt->_decrypt() != false){
    //Kết quả trả về.
    echo $kz_crypt->_result;
}
*/
