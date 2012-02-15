<?php

class WildfireBasketController extends ApplicationController{

  public $basket_id = false;
  public $basket = array();
  public $basket_cookie_var = "basket_id";
  public $basket_model_class = "WildfireBasket"; //the actual basket
  public $basket_class = false; //the class going in to the basket
  public $lifetime = 2592000; //(60*60*24*30) - 30 days
  public $redirect_on_change_basket = true;

  public function controller_global(){
    parent::controller_global();
    $this->basket_id = $this->id(false);
    if(!$this->basket_class) $this->basket_class = $this->cms_content_class;
    if($this->basket_id) $this->basket = $this->basket($this->basket_id);
  }
  
  public function add($item){
    if($item || ($item = Request::param('id'))){
      if(!$this->basket_id) $this->basket_id = $this->id($item);
      $model = new $this->basket_model_class;
      $this->added_item = $model->add_to($this->basket_id, $this->basket_class, $item);
    }
    if($this->redirect_on_change_basket){
      if($_SERVER['HTTP_REFERER']) $this->redirect_to($_SERVER['HTTP_REFERER']);
      else $this->redirect_to("/");
    }
  }
  
  public function delete($item){
    if($item || ($item = Request::param('id'))){
      if(!$this->basket_id) $this->basket_id = $this->id($item);
      $model = new $this->basket_model_class;
      $this->removed_item = $model->remove_from($this->basket_id, $this->basket_class, $item);
    }
    if($this->redirect_on_change_basket){
      if($_SERVER['HTTP_REFERER']) $this->redirect_to($_SERVER['HTTP_REFERER']);
      else $this->redirect_to("/");
    }
  }
  
  //until something is added/removed from basket get an empty id
  protected function id($generate = true){    
    if($id = $_COOKIE[$this->basket_cookie_var]) return $id;
    elseif($generate){
      $id = hash_hmac("sha1", time().$generate, $_SERVER['REMOTE_ADDR'].$generate);
      setcookie($this->basket_cookie_var, $id, time()+$this->lifetime, "/", $_SERVER['HTTP_HOST']);
      return $id;
    }
    return false;
  }

  protected function basket($id){
    $model = new $this->basket_model_class;
    if(!$id) return false;
    else return $model->basket($id, $this->basket_class);
  }

}
?>