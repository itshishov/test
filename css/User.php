<?php
 class User extends Controller
  {
	 public function index()
	 {
		   $this -> view('user/index'); 
	 }

     public function registration() 
	 {
            $data = [];
            if (isset($_POST['login'])) {
                $user = $this->model('UserModel');
                $user->setData($_POST['login'], $_POST['email'], $_POST['password'], $_POST['role']);
                $isValid = $user->validForm();
                if ($isValid == "Для подтверждения регистрации вам на почту было отправлено письмо") {
                    $user->addUser();
                    $data['message'] = $isValid;
                }
                else {
                    $data['message'] = $isValid;
                }
            }
            $this->view('user/index', $data);
        }
	 
      public function auth()
	  {  
            if (isset($_POST['email'])) {
                $user = $this->model('UserModel');
            }
            $this->view('project/index', $user->auth($_POST['email'], $_POST['password']), $user->getCategory());         
      }
	 
	  public function forgot() 
	  {
            $message["valid"] =[];
            $user = $this->model('UserModel');
		    $this->view('user/forgot', $user->forgot($email),$message["valid"]);       
      }
	 
	  public function confirmation()
	  {
		    $user = $this->model('UserModel');
		    $this->view('project/confirmation', $user->confirm());
	  }
	 
	  public function ban()
	  {
		    $user = $this->model('UserModel');
		    $this->view('user/ban', $user->ban());
	  }
	 
	  public function unban()
	  {
		    $user = $this->model('UserModel');
		    $this->view('user/unban', $user->unban());
	  }
     
       public function on()
	  {
		    $user = $this->model('UserModel');
		    $this->view('user/on', $user->on());
	  }
	 
	  public function off()
	  {
		    $user = $this->model('UserModel');
		    $this->view('user/off', $user->off());
	  }
     
	 
      public function logout() 
	  {
            unset($_SESSION['login']);
            unset($_SESSION['role']);
            header('Location: /');
      }
     
      public function myAds()
	  {
            $user = $this->model('UserModel');
            $this->view('user/myads', $user->getCategory());  
      }
	 
      public function admin()
      {    
		    $user = $this->model('UserModel');
		    $this->view('user/admin', $user->getUsers());
      }

      public function delete()
      {    
		    $user = $this->model('UserModel');
		    $this->view('user/delete', $user->deleteOneAd());
      }
	 
	  public function addingWithoutConfirmation()
      {    
		    $user = $this->model('UserModel');
		    $this->view('ads/index', $user->addingWithoutConfirmation());
      }
  }