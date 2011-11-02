<?
class WildfireBasket extends WaxModel{

  public function setup(){
    $this->define("token", "CharField"); //the unique token to join to
    $this->define("class", "CharField"); //the class of the model
    $this->define("item", "IntegerField"); //the id of the model
    $this->define("ip", "CharField");
  }

  public function before_save(){
    if(!$this->ip) $this->ip = $_SERVER['REMOTE_ADDR'];
  }

  public function basket($token, $class=false,$item=false){
    if($class) $this->filter("class", $class);
    if($item) $this->filter("item", $item);
    return $this->filter("token", $token)->all();
  }
  
  public function add_to($token, $class, $item){
    $cl = get_class($this);
    $mo = new $cl;
    return $mo->update_attributes(array('token'=>$token, 'class'=>$class, 'item'=>$item));
  }
  public function remove_from($token, $class, $item){
    $cl = get_class($this);
    $mo = new $cl;
    if($found = $mo->filter(array('token'=>$token, 'class'=>$class, 'item'=>$item))->first()) $found->delete();
  }
}
?>