<?php
    /*
     * posnetoos_config.php
     *
     */

    /**
     * @package posnet oos
     */

    //Configuration parameters
    define('MID', '6783406546');
    define('TID', '67599225');
    define('POSNETID', '16916');
    define('ENCKEY', '19,99,102,114,56,11,29,70');
    
    //Posnet Sistemi ile ilgili parametreler
    define('USERNAME', 'vd1anby7');
    define('PASSWORD', '9i2cfmva');

    //OOS/TDS sisteminin web adresi
    //define('OOS_TDS_SERVICE_URL', 'http://setmpos.ykb.com/3DSWebService/YKBPaymentService');
    define('OOS_TDS_SERVICE_URL', 'https://www.posnet.ykb.com/3DSWebService/YKBPaymentService');
    //Posnet XML Servisinin web adresi
    //define('XML_SERVICE_URL', 'http://setmpos.ykb.com/PosnetWebService/XML');
    define('XML_SERVICE_URL', 'https://www.posnet.ykb.com/PosnetWebService/XML');

    //Üye işyeri sayfası başlangıç web adresi (hata durumunda bu sayfaya dönülür.)
    define('MERCHANT_INIT_URL', 'https://www.bedenozgurlugu.com/portapp/modules/b2c/sales.php');
    //Üye işyeri dönüş sayfasının web adresi
    define('MERCHANT_RETURN_URL', 'https://www.bedenozgurlugu.com/portapp/modules/b2c/3DPayResults.php');
    
    //�ifreleme i�in PHP MCrypt mod�l�n� kullan
	define('USEMCRYPTLIBRARY', true);
    define('OPEN_NEW_WINDOW', '0');
    
    //3D-Secure kontrolleri
    define('TD_SECURE_CHECK', true);
    define('TD_SECURE_CHECK_MASK', '1:2:4:9');
?>