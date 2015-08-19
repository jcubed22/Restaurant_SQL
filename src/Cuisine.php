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

        function setType($new_type)
        {
            $this->type = (string) $new_type;
        }

        function getType()
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
            $GLOBALS['DB']->exec("INSERT INTO cuisines (type) VALUES ('{$this->getType()}')");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_cuisines = $GLOBALS['DB']->query("SELECT * FROM cuisines;");
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
            $GLOBALS['DB']->exec("DELETE FROM cuisines;");
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

        function getVenues()
        {
            $venues = array();
            $returned_venues = $GLOBALS['DB']->query("SELECT * FROM venues WHERE cuisine_id = {$this->getId()} ORDER BY name;");
            foreach($returned_venues as $venue) {
                $name = $venue['name'];
                $cuisine_id = $venue['cuisine_id'];
                $id = $venue['id'];
                $rating = $venue['rating'];
                $address = $venue['address'];
                $description = $venue['description'];
                $new_venue = new Venue($name, $cuisine_id, $id, $rating, $address, $description);
                array_push($venues, $new_venue);
            }
            return $venues;
        }

    }

?>
