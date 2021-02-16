<b>Yii2 REST API on Basic configuration</b>
<br>
<br>
<p>Получение курса валют ЦБ</p>
<br>Для получения курса необходимо отправить GET запрос на адрес http://your_host/rates
<br>Входные JSON параметры:
<pre>
{
	"currency" : "USD",     // код валюты.
	"rateCurrency" : "EUR", // код валюты, в которой выведется курс, по умолчанию RUB
	"rateSum" : "5"		// сумма первой валюты
}
</pre>
