<?php

    class Venue
    {
        private $name;
        private $cuisine_id;
        private $id;
        private $rating;
        private $address;
        private $description;

        function __construct($name, $cuisine_id, $id = null, $rating, $address, $description)
        {
            $this->name = $name;
            $this->cuisine_id = $cuisine_id;
            $this->id = $id;
            $this->rating = $rating;
            $this->address = $address;
            $this->description = $description;
        }

        //Name setter and getter
        function setName($new_name)
        {
            $this->name = (string) $new_name;
        }

        function getName()
        {
            return $this->name;
        }

        //ID getters
        function getCuisineId()
        {
            return $this->cuisine_id;
        }

        function getId()
        {
            return $this->id;
        }

        //Rating setter and getter
        function setRating($new_rating)
        {
            $this->rating = $new_rating;
        }

        function getRating()
        {
            return $this->rating;
        }

        //Address setter and getter
        function setAddress($new_address)
        {
            $this->address = $new_address;
        }

        function getAddress()
        {
            return $this->address;
        }

        //Description setter and getter
        function setDescription($new_description)
        {
            $this->description = $new_description;
        }

        function getDescription()
        {
            return $this->description;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO venues (name, cuisine_id, rating, address, description) VALUES ('{$this->getName()}', {$this->getCuisineId()}, {$this->getRating}, '{$this->getAddress}', '{$this->getDescription}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_venues = $GLOBALS['DB']->query("SELECT * FROM venues ORDER BY rating;");
            $venues = array();
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

        static function find($search_id)
        {
            $found_venue = null;
            $venues = Task::getAll();
            foreach($venues as $venue) {
                $venue_id = $venue->getId();
                if ($venue_id == $search_id) {
                    $found_venue = $venue;
                }
            }
            return $found_venue;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM venues;");
        }
    }

?>
