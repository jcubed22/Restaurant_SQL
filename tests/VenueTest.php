<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Venue.php";
    require_once "src/Cuisine.php";

    $server = 'mysql:host=localhost;dbname=restaurant_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class VenueTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
            Venue::deleteAll();
        }

        function test_getName()
        {
            //Arrange
            $name = "Departure";
            $cuisine_id = 1;
            $id = 1;
            $rating = 3;
            $address = "1139 NW Elm Street";
            $description = "Yum yum for my tum tum";
            $test_Venue = new Venue($name, $cuisine_id, $id, $rating, $address, $description);

            //Act
            $result = $test_Venue->getName();

            //Assert
            $this->assertEquals($name, $result);
        }

        function test_getRating()
        {
            //Arrange
            $name = "Departure";
            $cuisine_id = 1;
            $id = 1;
            $rating = 3;
            $address = "1139 NW Elm Street";
            $description = "Yum yum for my tum tum";
            $test_Venue = new Venue($name, $cuisine_id, $id, $rating, $address, $description);

            //Act
            $result = $test_Venue->getRating();

            //Assert
            $this->assertEquals($rating, $result);
        }

        function test_getAddress()
        {
            //Arrange
            $name = "Departure";
            $cuisine_id = 1;
            $id = 1;
            $rating = 3;
            $address = "1139 NW Elm Street";
            $description = "Yum yum for my tum tum";
            $test_Venue = new Venue($name, $cuisine_id, $id, $rating, $address, $description);

            //Act
            $result = $test_Venue->getAddress();

            //Assert
            $this->assertEquals($address, $result);
        }

        function test_getDescription()
        {
            //Arrange
            $name = "Departure";
            $cuisine_id = 1;
            $id = 1;
            $rating = 3;
            $address = "1139 NW Elm Street";
            $description = "Yum yum for my tum tum";
            $test_Venue = new Venue($name, $cuisine_id, $id, $rating, $address, $description);

            //Act
            $result = $test_Venue->getDescription();

            //Assert
            $this->assertEquals($description, $result);
        }

        function test_save()
        {
            $type = "Italian";
            $id = null;
            $test_Cuisine = new Cuisine($type, $id);
            $test_Cuisine->save();

            $name = "Departure";
            $cuisine_id = $test_Cuisine->getId();
            $rating = "2";
            $address = "1139 NW Elm Street";
            $description = "Swanky";
            $test_Venue = new Venue($name, $cuisine_id, $id, $rating, $address, $description);

            //Act
            $test_Venue->save();

            //Assert
            $result = Venue::getAll();
            $this->assertEquals($test_Venue, $result[0]);
        }

        function test_getId()
        {
            //Arrange
            $type = "Italian";
            $id = null;
            $test_Cuisine = new Cuisine($type, $id);
            $test_Cuisine->save();

            $name = "Departure";
            $cuisine_id = 1;
            $id = 1;
            $rating = 3;
            $address = "1139 NW Elm Street";
            $description = "Yum yum for my tum tum";
            $test_Venue = new Venue($name, $cuisine_id, $id, $rating, $address, $description);
            $test_Venue->save();

            //Act
            $result = $test_Venue->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_getCuisineId()
        {
            //Arrange
            $type = "Italian";
            $id = null;
            $test_cuisine = new Cuisine($type, $id);
            $test_cuisine->save();

            $name = "Mai Thai";
            $cuisine_id = $test_cuisine->getId();
            $rating = 4;
            $address = "1139 NW Elm Street";
            $description = "Yum yum for my tum tum";
            $test_venue = new Venue($name, $cuisine_id, $id, $rating, $address, $description);
            $test_venue->save();

            //Act
            $result = $test_venue->getCuisineId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_deleteAll()
        {
            //Arrange
            $type = "Thai";
            $id = null;
            $rating = 4;
            $address = "1139 NW Elm Street";
            $description = "Yum yum for my tum tum";
            $test_Cuisine = new Cuisine($type, $id);
            $test_Cuisine->save();

            $name = "Mai Thai";
            $name2 = "Screen Door";
            $cuisine_id = $test_Cuisine->getId();
            $test_Venue = new Venue($name, $cuisine_id, $id, $rating, $address, $description);
            $test_Venue->save();
            $test_Venue2 = new Venue($name, $cuisine_id, $id, $rating, $address, $description);
            $test_Venue2->save();

            //Act
            Venue::deleteAll();

            //Assert
            $result = Venue::getAll();
            $this->assertEquals([], $result);

        }

        function test_find()
        {
            //Arrange
            $type = "Thai";
            $id = null;
            $rating = 4;
            $address = "1139 NW Elm Street";
            $description = "Yum yum for my tum tum";
            $test_Cuisine = new Cuisine($type, $id);
            $test_Cuisine->save();

            $name = "Mai Thai";
            $name2 = "Screen Door";
            $cuisine_id = $test_Cuisine->getId();
            $test_Venue = new Venue($name, $cuisine_id, $id, $rating, $address, $description);
            $test_Venue->save();
            $test_Venue2 = new Venue($name, $cuisine_id, $id, $rating, $address, $description);
            $test_Venue2->save();

            //Act
            $result = Venue::find($test_Venue->getId());

            //Assert
            $this->assertEquals($test_Venue, $result);
        }

        function test_getVenues()
        {
            //Arrange
            $type = "Thai";
            $id = null;
            $test_cuisine = new Cuisine($type, $id);
            $test_cuisine->save();

            $test_cuisine_id = $test_cuisine->getId();

            $name = "Mai Thai";
            $address = "1139 NW Elm Street";
            $description = "Yum yum for my tum tum";
            $rating = 3;

            $name2 = "Screen Door";
            $address2 = "19849 SW Santee Court";
            $description2 = "Huge lines.  Not worth it.";
            $rating2 = 4;

            $test_venue = new Venue($name, $test_cuisine_id, $id, $rating, $address, $description);
            $test_venue2 = new Venue($name2, $test_cuisine_id, $id, $rating2, $address2, $description2);

            $test_venue->save();
            $test_venue2->save();

            //Act
            $result = $test_cuisine->getVenues();

            //Assert
            $this->assertEquals([$test_venue, $test_venue2], $result);
        }

    }

?>
