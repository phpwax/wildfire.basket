<?
class WildfireBasket extends WaxModel{

  public function setup(){
    $this->define("token", "CharField"); //the unique token to join to
    $this->define("class", "CharField"); //the class of the model
    $this->define("item", "IntegerField"); //the id of the model
    $this->define("ip", "CharField");
  }

  public function basket($token, $class=false,$item=false){
    if($class) $this->filter("class", $class);
    if($item) $this->filter("item", $item);
    return $this->filter("token", $token)->all();
  }
  
}
?>