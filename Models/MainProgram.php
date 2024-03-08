<?php
ini_set("display-errors" , 1);

use Illuminate\Database\Capsule\Manager as Capsule;

require_once("./DbHandler.php");
class MainProgram implements DbHandler
{
    private $_capsule;
    public function __construct()
    {
        $this->_capsule = new Capsule;
    }
    public function connect()
    {
        try {
            $this->_capsule->addConnection([
                'driver'    => __DRIVER_DB__,
                'host'      => __HOST_DB__,
                'database'  => __NAME_DB__,
                'username'  => __USERNAME_DB__,
                'password'  => __PASS_DB__,
            ]);
            $this->_capsule->setAsGlobal();
            $this->_capsule->bootEloquent();
            return true;
        } catch (\Exception $ex) {
            echo "Error : " . $ex->getMessage();
            return false;
        }
    }
    public function get_data($fields = array(),  $start = 0)
    {
        $items = Items::skip($start)->take(5)->get();
        if (empty($fields)) {
            foreach ($items as $item) {
                echo $item->id . " <br>";
            }
        } else {
            return $items;
        }
    }
    public function disconnect()
    {
        try {
            Capsule::disconnect();
            return true;
        } catch (\Exception $e) {
            echo "Error : " . $e->getMessage();
            return false;
        }
    }
    public function get_record_by_id($id, $primary_key)
    {
        $item = Items::where($primary_key, "=", $id)->get();
        if (count($item) > 0)
            return $item[0];
    }
    public function search_by_column($name_column, $value)
    {
        $items = Items::where($name_column, "like", "%$value%")->get();
        if (count($items) > 0)
            return $items;
    }

  public function getitemsCount(){
    try {
        return Items::count();
    } catch(\Exception $ex) {
        echo $ex->getMessage();
    }

  }
}


