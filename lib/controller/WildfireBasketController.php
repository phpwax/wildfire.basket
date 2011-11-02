<?php

class WildfireBasketController extends ApplicationController{

  public $basket_id = false;
  public $basket = array();
  public $basket_cookie_var = "basket_id";
  public $basket_model_class = "WildfireBasket"; //the actual basket
  public $basket_class = false; //the class going in to the basket
  public $lifetime = 2592000; //(60*60*24*30) - 30 days

  public function controller_global(){
    parent::controller_global();
    $this->basket_id = $this->id(false);
    if(!$this->basket_class) $this->basket_class = $cms_content_class;
    if($this->basket_id) $this->basket = $this->basket($this->basket_id);
  }

  public function add(){
    if($item = Request::param('id')){
      if(!$this->basket_id && ($this->basket_id = $this->id($item) )) setcookie($this->basket_cookie_var, $this->basket_id, time()+$this->lifetime);
    }
    
  }
  public function delete(){
    if($item = Request::param('id')){
      if(!$this->basket_id && ($this->basket_id = $this->id($item) )) setcookie($this->basket_cookie_var, $this->basket_id, time()+$this->lifetime);
    }
  }
  //until something is added/removed from basket get an empty id
  protected function id($generate = true){
    if($id = $_COOKIE[$this->basket_cookie_var]) return $id;
    elseif($generate) return hash_hmac("sha1", time().$generate, $_SERVER['REMOTE_ADDR'].$generate);
    return false;
  }

  protected function basket($id){
    if(!$id) return array();
    else{
      $model = new $basket_model_class;
      return $model->basket($id, $this->basket_class);
    }
  }

}
?>