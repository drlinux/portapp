<?php
class CasString
{

	function randomStringGenerator($length=10){
		$pattern = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
		for($i=0; $i<$length; $i++){
			$s .= $pattern{rand(0,strlen($pattern)-1)};
		}
		return $s;
	}

	function randomColorGenerator(){
		global $red, $green, $blue, $color;
		$color = array(rand(50,255), rand(50,255), rand(50,255)); //generates random RGB color;
		$red = $color[1]; //red value;
		$green = $color[2]; //green value;
		$blue = $color[3]; //blue value;
	}

	function clearWhiteSpaces($str) {
		return preg_replace("/[[:space:]]/", "", $str);
	}


	// TODO Not completed
	function data_url($file, $mime) {
		// TODO Resim alınabiliyor mu denenecek
		// http://en.wikipedia.org/wiki/Data:_URI
		// NOT WORKS WITH IE
		/* <img src="<?php echo data_url('elephant.png','image/png')?>" alt="An elephant" /> */
		/*window.open('data:text/html;charset=utf-8,%3C!DOCTYPE%20HTML%20PUBLIC%20%22-'+
		 '%2F%2FW3C%2F%2FDTD%20HTML%204.0%2F%2FEN%22%3E%0D%0A%3Chtml%20lang%3D%22en'+
		 '%22%3E%0D%0A%3Chead%3E%3Ctitle%3EEmbedded%20Window%3C%2Ftitle%3E%3C%2Fhea'+
		 'd%3E%0D%0A%3Cbody%3E%3Ch1%3E42%3C%2Fh1%3E%3C%2Fbody%3E%0D%0A%3C%2Fhtml%3E'+
		 '%0D%0A','_blank','height=300,width=400');
		 */
		$pages = file_get_contents($file);
		$base64   = base64_encode($pages);
		return ('data:' . $mime . ';base64,' . $base64);
	}


	/*
	 * strtoupper(): ıabc idef ghıiş » IABC İDEF GHIİŞ
	 */
	function trbuyult($veri) { return mb_convert_case(str_replace('i','İ',$veri), MB_CASE_UPPER, "UTF-8"); }


	/*
	 * strtolower(): strtoupper(): IABC İDEF GHIİŞ » ıabc idef ghıiş
	 */
	function trkucult($veri) { return mb_convert_case(str_replace('I','ı',$veri), MB_CASE_LOWER, "UTF-8"); }


	/*
	 * ucwords(): ıabc idef ghıiş » Iabc İdef Ghıiş
	 */
	function trkelilk($veri) { return mb_convert_case(str_replace(array(' I',' ı', ' İ', ' i'),array(' I',' I',' İ',' İ'),$veri), MB_CASE_TITLE, "UTF-8"); }


	/*
	 * ucfirst(): ıabc idef ghıiş » Iabc idef ghıiş veya IABC İDEF GHIİŞ » Iabc idef ghıiş
	 */
	function trcumilk($veri) {
		$veri = in_array(crc32($veri[0]),array(1309403428, -797999993, 957143474)) ? array(trbuyult(substr($veri,0,2)),trkucult(substr($veri,2))) : array(trbuyult($veri[0]),trkucult(substr($veri,1)));
		return $veri[0].$veri[1];
	}


	function getCurrentPath() {
		$a = explode("/", $_SERVER["REQUEST_URI"]);
		array_pop($a);
		return implode("/", $a);
	}

	/*
	 * Reads the extension of the file
	 *
	 * @param string $filename the the filename with extension
	 */
	function getExtension($filename) {
		$i = strrpos($filename, ".");
		if (!$i) { return ""; }
		$l = strlen($filename) - $i;
		$ext = substr($filename, $i+1, $l);
		return strtolower($ext);
	}

	function getExtensionReturnArray($filename) {
		return explode(".", $filename);
	}




	/*
	 * kimlik numaraları 11 haneden oluşur
	 * her bir hane rakamsal değer içerir
	 * 0 (sıfır) ile başlamazlar
	 * 1, 3, 5, 7 ve 9. basamakların toplamının 7 katından, 2, 4, 6 ve 8. basamakların toplamı çıkartıldığında, çıkan sonucun 10′a bölümünden kalan sayı (mod10), kimlik numaramızın 10. hanesine eşittir
	 * ilk 10 basamağın toplamından çıkan sonucun 10′a bölünmesinden kalan sayı da, 11. haneye eşittir.
	 *
	 */
	static public function isTckimlik($tckimlik){
		$olmaz = array(
		'11111111110',
		'22222222220',
		'33333333330',
		'44444444440',
		'55555555550',
		'66666666660',
		'77777777770',
		'88888888880',
		'99999999990'
		);

		if ( $tckimlik[0]==0 or !ctype_digit($tckimlik) or strlen($tckimlik)!=11 )
		{
			return false;
		}
		else
		{
			for($a=0; $a<9; $a=$a+2)
			{
				$ilkt = $ilkt + $tckimlik[$a];
			}
			for($a=1; $a<8; $a=$a+2)
			{
				$sont = $sont + $tckimlik[$a];
			}
			for($a=0; $a<10; $a=$a+1)
			{
				$tumt = $tumt + $tckimlik[$a];
			}

			if( ($ilkt*7-$sont)%10 != $tckimlik[9] or $tumt%10 != $tckimlik[10])
			{
				return false;
			}
			else
			{
				foreach($olmaz as $olurmu)
				{
					if($tckimlik == $olurmu)
					{
						return false;
					}
				}
				return true;
			}
		}
	}

	/*
	 * http://www.webcheatsheet.com/php/regular_expressions.php
	 */
	public static function checkStartsEndsWith($needle, $haystack)
	{
		return preg_match('/(^'.$needle.'|'.$needle.'$)/', $haystack);
	}


	public static function getIP()
	{
		if ( isset($_SERVER["REMOTE_ADDR"]) )    {
			$ip = $_SERVER["REMOTE_ADDR"];
		} elseif ( isset($_SERVER["HTTP_X_FORWARDED_FOR"]) )    {
			$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
		} elseif ( isset($_SERVER["HTTP_CLIENT_IP"]) )    {
			$ip = $_SERVER["HTTP_CLIENT_IP"];
		}
		return $ip;
	}


	/*
	 * $number = 1234.56;
	 * setlocale(LC_MONETARY, 'pt_BR.UTF-8', 'Portuguese_Brazil.1252');
	 * setlocale(LC_ALL, 'tr_TR.UTF-8', 'tr_TR', 'tr', 'turkish');
	 * echo CasString::money_format('%.2n', $number) . "\n";
	 * 
	 */
	function money_format($format, $number)
	{
		if (function_exists('money_format')) {
			return money_format($format, $number);
		}
		if (setlocale(LC_MONETARY, 0) == 'C') {
			setlocale(LC_MONETARY, '');
			//return number_format($number, 2);
		}
		
		$locale = localeconv();
		
		$regex  = '/%((?:[\^!\-]|\+|\(|\=.)*)([0-9]+)?'.
              '(?:#([0-9]+))?(?:\.([0-9]+))?([in%])/';
		
		preg_match_all($regex, $format, $matches, PREG_SET_ORDER);
		
		foreach ($matches as $fmatch) {
			$value = floatval($number);
			$flags = array(
            'fillchar'  => preg_match('/\=(.)/', $fmatch[1], $match) ? 
			$match[1] : ' ',
            'nogroup'   => preg_match('/\^/', $fmatch[1]) > 0, 
            'usesignal' => preg_match('/\+|\(/', $fmatch[1], $match) ? 
			$match[0] : '+',
            'nosimbol'  => preg_match('/\!/', $fmatch[1]) > 0, 
            'isleft'    => preg_match('/\-/', $fmatch[1]) > 0 
			);
			$width      = trim($fmatch[2]) ? (int)$fmatch[2] : 0;
			$left       = trim($fmatch[3]) ? (int)$fmatch[3] : 0;
			$right      = trim($fmatch[4]) ? (int)$fmatch[4] : $locale['int_frac_digits'];
			$conversion = $fmatch[5];

			$positive = true;
			if ($value < 0) {
				$positive = false;
				$value  *= -1;
			}
			$letter = $positive ? 'p' : 'n';

			$prefix = $suffix = $cprefix = $csuffix = $signal = '';

			$signal = $positive ? $locale['positive_sign'] : $locale['negative_sign'];
			switch (true) {
				case $locale["{$letter}_sign_posn"] == 1 && $flags['usesignal'] == '+':
					$prefix = $signal;
					break;
				case $locale["{$letter}_sign_posn"] == 2 && $flags['usesignal'] == '+':
					$suffix = $signal;
					break;
				case $locale["{$letter}_sign_posn"] == 3 && $flags['usesignal'] == '+':
					$cprefix = $signal;
					break;
				case $locale["{$letter}_sign_posn"] == 4 && $flags['usesignal'] == '+':
					$csuffix = $signal;
					break;
				case $flags['usesignal'] == '(':
				case $locale["{$letter}_sign_posn"] == 0:
					$prefix = '(';
					$suffix = ')';
					break;
			}
			if (!$flags['nosimbol']) {
				$currency = $cprefix .
				($conversion == 'i' ? $locale['int_curr_symbol'] : $locale['currency_symbol']) .
				$csuffix;
			} else {
				$currency = '';
			}
			$space  = $locale["{$letter}_sep_by_space"] ? ' ' : '';

			$value = number_format($value, $right, $locale['mon_decimal_point'],
			$flags['nogroup'] ? '' : $locale['mon_thousands_sep']);
			$value = @explode($locale['mon_decimal_point'], $value);

			$n = strlen($prefix) + strlen($currency) + strlen($value[0]);
			if ($left > 0 && $left > $n) {
				$value[0] = str_repeat($flags['fillchar'], $left - $n) . $value[0];
			}
			$value = implode($locale['mon_decimal_point'], $value);
			if ($locale["{$letter}_cs_precedes"]) {
				$value = $prefix . $currency . $space . $value . $suffix;
			} else {
				$value = $prefix . $value . $space . $currency . $suffix;
			}
			if ($width > 0) {
				$value = str_pad($value, $width, $flags['fillchar'], $flags['isleft'] ?
				STR_PAD_RIGHT : STR_PAD_LEFT);
			}

			$format = str_replace($fmatch[0], $value, $format);
		}
		return $format;
	}
	
	public function isGLN($number)
	{
		if ($number==null || $number=="" || strlen($number)!=13)
			return false;
			
		$checkDigit = substr($number, 12, 1);
		$number = substr($number, 0, 12);
		$temp = str_split($number);
		
		$even = 0;
		$odd = 0;
		foreach ($temp as $k=>$v)
		{
			if ($k%2==0)
			{
				$even += $v;
			}
			elseif ($k%2==1)
			{
				$odd += $v;
			}
		}
		
		$remainder = ($even+($odd*3))%10;
		if ($remainder>0)
		{
			$calculation = 10-$remainder;
		}
		else
		{
			$calculation = $remainder;
		}
		
		if($calculation==$checkDigit)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

}