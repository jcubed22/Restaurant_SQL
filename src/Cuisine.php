<?php

    class Cuisine
    {
        private $type;
        private $id;

        function __construct($type, $id = null)
        {
            $this->type = $type;
            $this->id = $id;
        }

        function setFood($new_type);
        {
            $this->type = (string) $new_type;
        }

        function getFood()
        {
            return $this->type;
        }

        function getId()
        {
            return $this->id;
        }

        //Don't forget to name our tables/columns appropriately.
        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO cuisine (type) VALUES ('{$this->getType()}')");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_cuisines = $GLOBALS['DB']->query("SELECT * FROM type;")
            $cuisine = array();
            foreach($returned_cuisines as $cuisine) {
                 $type = $cuisine['type'];
                 $id = $cuisine['id'];
                 $new_cuisine = new Cuisine($type, $id);
                 array_push($cuisine, $new_cuisine);
            }
            return $cuisine;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM cuisine;")
        }

        static function find($search_id)
        {
            $found_cuisine = null;
            $cuisines = Cuisine::getAll();
            foreach($cuisines as $cuisine) {
                $cuisine_id = $cuisine->getId();
                if ($cuisine_id == $search_id) {
                    $found_cuisine = $cuisine;
                }
                return $found_cuisine;
            }
        }

        //Complete once we've built Venue class.
        // function getVenues()
        // {
        //     $venues = array();
        //     $returned_venues = $GLOBALS['DB']->query("SELECT * FROM venues WHERE cuisine_id = {$this->getId()} ORDER BY name;");
        //     foreach($returned_venues as $venue) {
        //         $
        //     }
        // }
    }

?>
