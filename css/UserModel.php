<?php
require_once 'DB.php';
require_once 'AdsModel.php';


class UserModel
{
    private $db;
    public $email;
    public $login;
    public $password;
     
    public function __construct()
    {    
        $this -> db = DB::getInstance();    
    }
    
	public function upshot() 
	{
	     $url = $_SERVER['REQUEST_URI'];
         $url = explode('/', $url);
         $upshot=$url[3];
		 return $upshot;
	}
	
    public function setData($login, $email, $password)  
	{
         $this->login = trim($login);
         $this->email = trim($email);
         $this->password = trim($password);
            
    }

    public function validForm() 
	{         
          $result = $this->db->prepare("SELECT email FROM `users` WHERE email=:email");
		  $result->execute(["email" => trim($this->email)]); 
          $user = $result->fetch(PDO::FETCH_ASSOC);
          if (!empty($user["email"])){       
            return "Такой email уже сущестувует!";
          }
          else if (strlen($this->login) < 2) {
              return "Длина имени не меньше 2 символов";
            } 
          else if (strlen($this->email) < 1) {
              return "Введите email";
            }
          else if (strlen($this->password) < 5) {
              return "Длина пароля не меньше 5 символов";
            }  
          else {
              return "Для подтверждения регистрации вам на почту было отправлено письмо";
            }
        }
        
     public function addUser() 
	 {
			$hash = $this->gen_password(10);
            $sql = 'INSERT INTO users(login, email, password,role, hash, ban, date_ban,vip,date_vip_off) VALUES(:login, :email, :password,:role, :hash, :ban, 
			:date_ban,:vip,:date_vip_off)';
            $query = $this->db->prepare($sql);
            $query->execute(['login' => htmlspecialchars(trim($this->login)), 'email' => htmlspecialchars(trim($this->email)), 'password' =>         htmlspecialchars(trim($_POST['password'])),'role' => 0, 'hash' => $hash, 'ban' => 0, 'date_ban' => date('Y-m-d H:i:s'),'vip' => 0, 'date_vip_off' => date('Y-m-d H:i:s')]);
		    $this->confirmation($email);
     }
	

	
	public function confirmation($email)  
	{	
			$this->email = $_POST["email"];
			$to= $this->email;
			$subject = 'Доска объявлений - Подтверждение регистрации';
			$sql = $this->db->prepare("SELECT*FROM users WHERE email = :email");
		 	$sql->execute(["email" => $this->email]);
			$user = $sql->fetch(PDO::FETCH_ASSOC);			
            $message = 'Подтведите регистрацию по ссылке '.'http://test.u1556708.plsk.regruhosting.ru/user/confirmation/'.$user["hash"].' Если             вы не регистрировались, то пропустите данное сообщение.';
			$headers = 'From: webmaster@example.com';
			mail($to, $subject, $message, $headers); 
    }
	
	public function confirm()  
    {
			$sql = $this->db->prepare("SELECT*FROM users WHERE hash = :hash");
			$sql->execute(["hash" => $this->upshot()]); 
			$user = $sql->fetch(PDO::FETCH_ASSOC);		  

			$res = 	 $user['id']; 
	        $result=$this->db->query("UPDATE users SET role=1 WHERE id=$res"); 	  
	}
    
    public function auth($email, $password)  
	{
            $this->email = trim($_POST["email"]);
		    $this->password = trim($_POST["password"]);
            $result = $this->db->prepare("SELECT*FROM `users` WHERE `password` = :password AND email=:email");
		    $result->execute(["password" => trim($this->password), "email" => trim($this->email)]); 
            $user = $result->fetch(PDO::FETCH_ASSOC);

            if (!empty($user['id'])) { 
                $_SESSION['auth'] = true;
                $_SESSION['login'] = $user['login'];
                $_SESSION['id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                header('Location: /');
            }
		
            else {
            header('Location: /');
            } 
    }
     
	function gen_password($length = 6) 
    {
			$password = '';
			$arr = array(
				'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 
				'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 
				'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 
				'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 
				'1', '2', '3', '4', '5', '6', '7', '8', '9', '0'
			);

			for ($i = 0; $i < $length; $i++) {
				$password .= $arr[random_int(0, count($arr) - 1)];
			}
			return $password;
    }
 
	public function forgot($email)  
	{ 
 		   $this->email = $_POST["email"];
           $pass = $this->gen_password(6);
		   $result = $this->db->prepare("SELECT*FROM `users` WHERE email=:email");
		   $result->execute(['email' => $this->email]);
           $user = $result->fetch(PDO::FETCH_ASSOC);
		   $id = $user["id"];
		
           if (empty($user["email"])) {       
                return "Такой email не сущестувует!";
            }
		   else {
			
			  $res=$this->db->prepare("UPDATE users SET password=:password WHERE id=:id"); 
              $res->execute(['password' => $pass, 'id' => $id]);
			  $res->execute();
			  $success = "Новый пароль был отправлен на email"; 
		    
		    $to= $this->email;
			$subject = 'Восстановление пароля - Доска объявлений ';			
            $message = 'Ваш новый пароль '.$pass;
		    $headers = 'From: webmaster@example.com';
			mail($to, $subject, $message, $headers); 
	       }
	}
	
    public function getCategory()  
    {    
		   $result = $this->db->query("SELECT * FROM `category`");
		   return  $categorys = $result->fetchAll(PDO::FETCH_ASSOC); 
      
    }
	
    public function getUsers() 
    {    
           $result = $this->db->query("SELECT * FROM `users`");
		   return  $users = $result->fetchAll(PDO::FETCH_ASSOC); 
      
    }
    
    public function deleteOneAd() 
	{
		   $result=$this->db->prepare("DELETE FROM ads WHERE id=:id"); 
		   $result->execute(["id" => $this->upshot()]); 
    }
     
	public function ban() 
	{
		   $time = time() + 604800;
           $data = date('Y.m.d H:i:s', $time);
		   $result=$this->db->prepare("UPDATE users SET ban=:ban,date_ban=:date_ban WHERE id=:id");  
		   $result->execute(["id" => $this->upshot(), "date_ban" => $data, "ban" => 1]); 
    }
	
	public function unban()  
	{
		   $result=$this->db->prepare("UPDATE users SET ban=:ban WHERE id=:id");  
		   $result->execute(["id" => $this->upshot(), "ban" => 0]); 
    }
    
    	public function on() 
	{
           $time = time() + 2678400;
           $data = date('Y.m.d H:i:s', $time);
		   $result=$this->db->prepare("UPDATE users SET vip=:vip,date_vip_off=:date_vip_off WHERE id=:id");  
		   $result->execute(["id" => $this->upshot(), "vip" => 1, 'date_vip_off' => $data]); 
    }
    
	public function off()  
	{      
           
		   $result=$this->db->prepare("UPDATE users SET vip=:vip,date_vip_off=:date_vip_off WHERE id=:id");  
		   $result->execute(["id" => $this->upshot(), "vip" => 0, 'date_vip_off'=> date('Y.m.d H:i:s')]); 
    }
    

}