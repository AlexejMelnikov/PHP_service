<?php
 error_reporting(E_ALL);
$client = new SoapClient('http://mysite.local/soap/news.wsdl');
try{
  /* ������� ����� �������� */
  $result = $client -> getNewsCount();  
  echo " <p>Count all news : $result</p>";
  /* ������� �������� � ��������� �������� */
  $result = $client -> getNewsCountByCat(1);
  echo "<p> Count all news about politics : $result</p>";
  /* ������� ���������� ������� */
  $result = $client -> getNewsById(4);
  $result = unserialize(base64_decode($result));
  echo $result['title']."<br>".
       $result['description']."<br>". 
       $result['source'];
  /* var_dump($result);  */
} catch(SoapFault $e) {
  echo " �������� ". $e -> faultcode."�e����� ������ ".$e -> getMessage();
}
echo "HI";
