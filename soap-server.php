<?php
require "../news/NewsDB.class.php";

class NewsService extends NewsDB{

  /* $this -> db = new NewsDB; */
	/* Метод возвращает новость по её идентификатору */
	function getNewsById($id){
    $this -> db = new SQLite3("../news/news.db");
		try{
			$sql = "SELECT id, title, 
					(SELECT name FROM category WHERE category.id = msgs.category) as category, description, source, datetime 
					FROM msgs
					WHERE id = $id";
			$result = $this->db->query($sql);
      $rows = [];
      if(is_object($result)){
        while($row =  $result -> fetchArray()){
         /*   echo $row['title']; */
           $rows = $row;
         } 
  }
			if (!is_object($result)) 
				throw new Exception($this->db->lastErrorMsg());
			return base64_encode(serialize($rows));
		}catch(Exception $e){
			throw new SoapFault('getNewsById', $e->getMessage());
		}
	}
	/* Метод считает количество всех новостей */
	function getNewsCount(){
    $this -> db = new SQLite3("../news/news.db");
		try{
			$sql = "SELECT count(*) FROM msgs";
			$result = $this->db->querySingle($sql);
			if (!$result) 
				throw new Exception($this->db->lastErrorMsg());
			return $result;
		}catch(Exception $e){
			throw new SoapFault('getNewsCount', $e->getMessage());
		}
	}
	/* Метод считает количество новостей в указанной категории */
	function getNewsCountByCat($cat_id){
    $this -> db = new SQLite3("../news/news.db");
		try{
			$sql = "SELECT count(*) FROM msgs WHERE category=$cat_id";
			$result = $this->db->querySingle($sql);
			if (!$result) 
				throw new Exception($this->db->lastErrorMsg());
			return $result;
		}catch(Exception $e){
			throw new SoapFault('getNewsCountByCat', $e->getMessage());
		}
	}
}

/* отключаем кеширование wsdl документа */
ini_set("soap.wsdl_caahe_enabled", "0");
/* создание soap сервера */
$server = new SoapServer("http://mysite.local/soap/news.wsdl");
/* регистрация клбасса */
$server -> setClass("NewsService");
ob_clean();
ob_start();
/* запуск сервера */
$server -> handle();

