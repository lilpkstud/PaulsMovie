<?php
    require('../tmdb.php');

    /**
     * myList[0] has all of my Korean Movies
     * myList[1] has all of my Korean Dramas
     */
        //var_dump($myList[0]['items']);
        //var_dump($myList[1]['items']);

    if($_GET['type'] === "movies") {
        $info = search_list($_GET['movieId'], $myList[0]['items']);
        $rating = getMyRating($_GET['movieId'], $myRatings);
    } 
    if($_GET['type'] === "dramas"){
        $info = search_list($_GET['movieId'], $myList[1]['items']);
        $rating = getMyRating($_GET['movieId'], $myRatings);
    }
    if($_GET['type'] == "rated"){
        $info = getMovieInfo($_GET['movieId'], $client);
        $rating = getMyRating($_GET['movieId'], $myRatings);
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Movies</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="/">Pauls Movies</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
                </li>
            </ul>
        </div>
    </nav>
    <div style="margin-top: 100px" class="container">
        <?php
            /**
             * Created a movie and drama container since the json for movies and drams are different
             * Ex. Grabbing the title
             */
            if($_GET['type'] == "movies" || $_GET['type'] == "rated") { 
        ?>
            
                <h1><?=$info['title']?></h1>
                <h4><?=$info['original_title']?></h4>
                <h5>My Rating: 
                    <?php if(is_null($rating)){
                        echo "Didnt rate this movie yet";
                    } else{
                    echo $rating['rating'];
                    }?>
                </h5>
                <h5>The Movie DB Rating: <?= $info['vote_average']?></h5>
                <?php echo getImage($info['poster_path'], $client)?>
                <p><?=$info['overview']?></p>
                <?php echo getImage($info['backdrop_path'], $client)?>
            
        <?php 
            } if($_GET['type'] == "dramas"){ 
        ?>
                <h1><?=$info['name']?></h1>
                <h4><?=$info['original_name']?></h4>
                <h3>My Rating: 
                    <?php if(is_null($rating)){
                        echo "Didnt rate this movie yet";
                    } else{
                    echo $rating['rating'];
                    }?>
                </h3>
                <h3>The Movie DB Rating: <?= $info['vote_average']?></h3>
                <?php echo getImage($info['poster_path'], $client)?>
                <p><?=$info['overview']?></p>
                <?php echo getImage($info['backdrop_path'], $client)?>
        <?php
            } 
        ?>
</body>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script type='text/javascript' src='/js/config.js'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</html>
<?php

    function search_list($movie_id, $list){
        foreach($list as $id => $movie){
            if($movie['id'] == intval($movie_id)) {
                return $movie;

            }
        } 
    }

    function getMyRating($movie_id, $ratings){
        for($index = 0; $index <= count($ratings); $index++){
            foreach($ratings[$index]['results'] as $id => $movie){
                if($movie['id'] == intval($movie_id)) {
                    return $movie;
                }
            }
        }
    }
?>
