<?php
    require('tmdb.php');

     /**
     * myList[0] has all of my Korean Movies
     * myList[1] has all of my Korean Dramas
     */
        //var_dump($myList[0]['items']);
        //var_dump($myList[1]['items']);
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
        <!-- Accordian DIV -->
        <div class="accordion" id="accordionExample">
            <!-- Korean Dramas -->
            <div class="card">
                <div class="card-header" id="koreanList">
                    <h2 class="mb-0">
                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseKorean" aria-expanded="true" aria-controls="collapseKorean">
                        My Korean Drama List
                        </button>
                    </h2>
                </div>

                <div id="collapseKorean" class="collapse show" aria-labelledby="koreanList" data-parent="#accordionExample">
                    <div class="card-body">
                       <div class="row">
                            <?php foreach($myList[1]['items'] as $movie => $info){
                                $image = $info['poster_path'];
                                //var_dump($info);
                                //die();
                
                            ?>
                                <div class="col">
                                    <a href="views/movie.php?movieId=<?=$info['id']?>&type=dramas">
                                        <h4><?=$info['name']?></h4>
                                        <?php echo getImage($image, $client);?>
                                    </a>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Korean Movies -->
            <div class="card">
                <div class="card-header" id="koreanDrama">
                    <h2 class="mb-0">
                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseKoreanDrama" aria-expanded="false" aria-controls="collapseKoreanDrama">
                        My Korean Movies List
                        </button>
                    </h2>
                </div>
                <div id="collapseKoreanDrama" class="collapse" aria-labelledby="KoreanDrama" data-parent="#accordionExample">
                <div class="card-body">
                       <div class="row">
                            <?php foreach($myList[0]['items'] as $movie => $info){
                                $image = $info['poster_path'];
                            ?>
                                <div class="col">
                                    <a href="views/movie.php?movieId=<?=$info['id']?>&type=movies">
                                        <h4><?=$info['title']?></h4>
                                        <?php echo getImage($image, $client);?>
                                    </a>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Rated Movies -->
            <div class="card">
                <div class="card-header" id="ratingsList">
                    <h2 class="mb-0">
                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseRatings" aria-expanded="false" aria-controls="collapseRatings">
                        My Rated Movies
                        </button>
                    </h2>
                </div>
                <div id="collapseRatings" class="collapse" aria-labelledby="ratingsList" data-parent="#accordionExample">
                    <div class="card-body">
                        <div class="row">
                            <?php
                                for($index = 0; $index <= count($myRatings); $index++){
                                    foreach($myRatings[$index]['results'] as $movie => $info){    
                                        $image = $info['poster_path'];
                            ?>
                                        <div class="col">
                                            <a href="views/movie.php?movieId=<?=$info['id']?>&type=rated">
                                                <h4><?=$info['title']?></h4>
                                                <?php echo getImage($image, $client); ?>
                                            </a>
                                        </div>
                            <?php
                                    }
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- End of Accordian Div -->
    </div> <!--End of Container-->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script type='text/javascript' src='/js/config.js'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>