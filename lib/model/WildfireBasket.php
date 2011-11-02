<?
class WildfireBasket extends WaxModel{

  public function setup(){
    $this->define("token", "CharField"); //the unique token to join to
    $this->define("class", "CharField"); //the class of the model
    $this->define("item", "IntegerField"); //the id of the model
    $this->define("quantity", "IntegerField");
    $this->define("ip", "CharField");
  }

}
?>