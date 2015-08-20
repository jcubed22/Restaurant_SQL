<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Cuisine.php";
    require_once "src/Venue.php";

    $server = 'mysql:host=localhost;dbname=restaurant_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class CuisineTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
            Cuisine::deleteAll();
            Venue::deleteAll();
        }

        function test_getType()
        {
            //Arrange
            $type = "Italian";
            $test_Cuisine = new Cuisine($type);

            //Act
            $result = $test_Cuisine->getType();

            //Assert
            $this->assertEquals($type, $result);
        }

        function test_getId()
        {
            //Arrange
            $type = "Italian";
            $id = 1;
            $test_Cuisine = new Cuisine($type, $id);

            //Act
            $result = $test_Cuisine->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_save()
        {
            //Arrange
            $type = "Italian";
            $test_Cuisine = new Cuisine($type);
            $test_Cuisine->save();

            //Act
            $result = Cuisine::getAll();

            //Assert
            $this->assertEquals($test_Cuisine, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $type = "Italian";
            $type2 = "Thai";
            $test_Cuisine = new Cuisine($type);
            $test_Cuisine->save();
            $test_Cuisine2 = new Cuisine($type2);
            $test_Cuisine2->save();

            //Act
            $result = Cuisine::getAll();

            //Assert
            $this->assertEquals([$test_Cuisine, $test_Cuisine2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $type = "Italian";
            $type2 = "Thai";
            $test_Cuisine = new Cuisine($type);
            $test_Cuisine->save();
            $test_Cuisine2 = new Cuisine($type2);
            $test_Cuisine2->save();

            //Act
            Cuisine::deleteAll();
            $result = Cuisine::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            //Arrange
            $type = "Italian";
            $type2 = "Thai";
            $test_Cuisine = new Cuisine($type);
            $test_Cuisine->save();
            $test_Cuisine2 = new Cuisine($type2);
            $test_Cuisine2->save();

            //Act
            $result = Cuisine::find($test_Cuisine->getId());

            //Assert
            $this->assertEquals($test_Cuisine, $result);
        }

        function test_update()
        {
            //Arrange
            $type = "Italian";
            $id = null;
            $test_cuisine = new Cuisine($type, $id);
            $test_cuisine->save();

            $new_cuisine_type = "Thai";

            //Act
            $test_cuisine->setType($new_cuisine_type);

            //Assert
            $this->assertEquals($new_cuisine_type, $test_cuisine->getType());
        }

        function test_updateCuisine()
        {
            //Arrange
            $type = "Italian";
            $id = null;
            $test_cuisine = new Cuisine($type, $id);
            $test_cuisine->save();

            $new_type = "Thai";

            //Act
            $test_cuisine->updateCuisine($new_type);
            $test_cuisine->save();

            //Assert
            $this->assertEquals($test_cuisine->getType(), "Thai");
        }

        function test_delete()
        {
            //Arrange
            $type = "Italian";
            $id = null;
            $test_cuisine = new Cuisine($type, $id);
            $test_cuisine->save();

            $type2 = "Thai";
            $id = null;
            $test_cuisine2 = new Cuisine($type, $id);
            $test_cuisine2->save();

            //Act
            $test_cuisine->deleteCuisine();

            //Assert
            $this->assertEquals([$test_cuisine2], Cuisine::getAll());
        }

        function test_deleteCuisineVenue()
        {
            //Arrange
            $type = "Italian";
            $id = null;
            $test_cuisine = new Cuisine($type, $id);
            $test_cuisine->save();

            $name = "Montage";
            $cuisine_id = $test_cuisine->getId();
            $rating = 4;
            $address = "1139 NW Elm Street";
            $description = "Yum yum for my tum tum";
            $test_venue = new Venue($name, $cuisine_id, $id, $rating, $address, $description);
            $test_venue->save();

            //Act
            $test_cuisine->deleteCuisine();

            //Assert
            $this->assertEquals([], Venue::getAll());
        }
    }

?>
