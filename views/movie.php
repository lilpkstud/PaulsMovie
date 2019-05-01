<?php
    require('../tmdb.php');

    $info = search_list($_GET['movieId'], $_SESSION['korean_list']['items']);

    var_dump($info);



    function search_list($movie_id, $list){
        foreach($list as $id => $movie){
            //var_dump(intval($movie_id));
            //var_dump($movie['id']);
            //var_dump($id);
            if($movie['id'] == intval($movie_id)) {
                return $_SESSION['korean_list']['items'][$id];
            }
        } 
    }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <ul>
        <li>Grab info of the movie</li>
        <li>Grab my rating for this movie</li>
    </ul>
    <h1><?=$info['title']?></h1>
    <h4><?=$info['original_title']?></h4>
    <?php echo getImage($info['poster_path'], $client)?>
    <p><?=$info['overview']?></p>
    <?php echo getImage($info['backdrop_path'], $client)?>
</body>
</html>


<?php
/**
     * Get the list of rated movies (and associated rating) for an account.
     *
     * @param  integer $accountId
     * @param  array   $parameters
     * @param  array   $headers
     * @return mixed
     */
    /*public function getRatedMovies($accountId, array $parameters = [], array $headers = [])
    {
        return $this->get('account/' . $accountId . '/rated/movies', $parameters, $headers);
    }*/
?>