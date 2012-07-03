/* Tüm javascript'ler yüklendikten sonra, custom olarak tanımlanan 
 * eventlerin yada başka gerekli kodların çalışması için kullanılacak script dosyası
 */

$(FinishStart);

function FinishStart()
{
	$(document).trigger("onFinish");
}