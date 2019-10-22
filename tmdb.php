<?
  require "vendor/autoload.php";
  session_start();
  $dotenv = Dotenv\Dotenv::create(__DIR__);
  $dotenv->load();  
 

  $token = new \Tmdb\ApiToken(ENV['API_KEY']);
  $client = new \Tmdb\Client($token, ['secure' => false]);
  $configRepository = new \Tmdb\Repository\ConfigurationRepository($client);


  $login_process = new \Tmdb\Api\Authentication($client);
  $account = new \Tmdb\Api\Account($client);
  
  /**
   * 
   * $request will grab the Request Token under $reques['request_token']
   *  */
  $request = getRequestToken($login_process);
  

  /**
   * 
   * $session_id will grab the SESSION ID under $session_id['session_id']
   *  
   * */
  $session_id = $login_process->getSessionTokenWithLogin($request['request_token'], getenv('username'), getenv('password'));

  /**
   * 
   * $myAccount will grab MY personal account info
   * Will need $myAccount['id'] for future use
   **/
  
  $myAccount = $account->getAccount($session_id);


  
  /**
   * 
   * Grabbing the List['id']
   * 
   * 
   * 99430 - KMovies
   * 
   * 110918 - KDrama
   **/

  $getAllLists = $account->getLists($myAccount['id'], ['session_id' => $session_id['session_id']]);

  $list = new \Tmdb\Api\Lists($client);

  /**
   * 
   * Grabbing my Korean Movies LIST
   */
  $myKoreanMovieList = [];
  $koreanMovies = $getAllLists['results'][0];
  array_push($myKoreanMovieList, $list->getList($koreanMovies['id']));

  /**
   * Grabbing all Rated Tv Shows and then filtering korean dramas by [origin_country] => "KR"
   */
  $myTVRatings = [];
  $myKoreanDramaList = [];

  $pages = $account->getRatedTvShows($myAccount['id'], ['session_id' => $session_id['session_id']]);

  for($total = 1; $total <= $pages['total_pages']; $total++){
    array_push($myTVRatings, $account->GetRatedTvShows($myAccount['id'],['session_id' => $session_id['session_id'], 'page' => $total]));

    for($totalRatedShows = 0; $totalRatedShows <= $myTVRatings[0]["total_results"]; $totalRatedShows++){
      //var_dump($myTVRatings[0]['results'][$totalRatedShows]['origin_country']);
      if($myTVRatings[0]['results'][$totalRatedShows]['origin_country'][0] == "KR" || $myTVRatings[1]['results'][$totalRatedShows]['origin_count'][0] == "KR"){
        array_push($myKoreanDramaList, $myTVRatings[0]['results'][$totalRatedShows]);
      }
    }

  }

  //var_dump($myTVRatings[0]["total_results"]);
  /*if($myTVRatings[0]['results'][1]['origin_country'][0] == "KR"){
    var_dump("MADE IT");
  }*/
  //var_dump($myKoreanDramaList[2]);
  //die();

  

  
  
 

  //array_push($myKoreanDramaList, $list->getList($koreanDramas['id']));


  //var_dump($myKoreanMovieList);
  //die();

  /*foreach ($getList['results'] as $listing) {    
    array_push($myList, $list->getList($listing['id']));
  }*/

  //var_dump($myKoreanDramaList);
  //die();

  /**
   * Grabbing my Rating Movies
   * 
   */
    $myMovieRatings = [];
    $pages = $account->getRatedMovies($myAccount['id'], ['session_id' => $session_id['session_id']]);
    for($total = 1; $total <= $pages['total_pages']; $total++){
      array_push($myMovieRatings, $account->getRatedMovies($myAccount['id'],['session_id' => $session_id['session_id'], 'page' => $total]));
    }
    ///Movies must be filtered by original_language
    //var_dump($myMovieRatings[0]["results"]);
    //die();

  


  /**
   * User Authentication
   * Step 1: Creating a new request token and saving it into $request_token['request_token']
   **/
      function getRequestToken($login_process){
        return $login_process->getNewToken();
      }

  /**
   * Step 2: Get the user to authorize the request token
   * 
   * This will go to the website asking for permission. BUT the redirect method isnt working or I have NO CLUE what to do next.
   **/
      function getRequest($login_process, $request_token){
        $user = $login_process->authenticateRequestToken($request_token['request_token']);
        $login_process->getNewSession($user);
      }

    function getImage($image, $client){

      $configRepository = new \Tmdb\Repository\ConfigurationRepository($client);

      $config = $configRepository->load();

      $imageHelper = new \Tmdb\Helper\ImageHelper($config);
      //DUNNO WHAT 'w154' thing is BUT 154 = width and 200 = height
      return $imageHelper->getHtml($image, 'w154', 154, 200);
    }

    function getMovieInfo($movieId, $client){
      $movie = new \Tmdb\Api\Movies($client);
      return $movie->getMovie($movieId);
    }


?>