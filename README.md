A lightweight Pagination class for PHP5

Tested on PHP 5.2.0+

Features

    Very simple configuration.
    
Usage

    Include the class
    Instantiate a new object pass in the number of items per page and the instance identifier, this is used for the GET parameter such as ?page=2
    Pass the set_total method to set the total number of records
    Call the set_limit method to set limit expression in sql-query
    Call the get_links method to create the navigation links


Let's See Some Code

    <?php
     include('paginator.php');
     
     $pages = new Paginator('10', 'page');
     $pages->set_total('100'); //or a number from a database
     //if using a database you limit the records in your query, this will limit the number of records
     $query = "SELECT * FROM posts ".$pages->set_limit(); //create limit expression
     
     //display the records here
     foreach($posts as $post)  {
        echo $post['title'];
     }
    
     echo $pages->get_links();
     ?>
     
Method get_links also allows to pass additional parameters such as a series of GET's

    <?php
    $dept = !empty($_GET['dept']) ? $_GET['dept'] : 1;
    echo $pages->get_links('&dept='.$dept);
    
    ?> 

