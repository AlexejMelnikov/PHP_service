<?php
 error_reporting(E_ALL);
$client = new SoapClient('http://mysite.local/soap/news.wsdl');
try{
  /* сколько всего новостей */
  $result = $client -> getNewsCount();  
  echo " <p>Count all news : $result</p>";
  /* сколько новостей в категории политика */
  $result = $client -> getNewsCountByCat(1);
  echo "<p> Count all news about politics : $result</p>";
  /* Покажем конкретную новость */
  $result = $client -> getNewsById(4);
  $result = unserialize(base64_decode($result));
  echo $result['title']."<br>".
       $result['description']."<br>". 
       $result['source'];
  /* var_dump($result);  */
} catch(SoapFault $e) {
  echo " Операция ". $e -> faultcode."вeрнула ошибку ".$e -> getMessage();
}
echo "HI";
