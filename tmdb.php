<?
  require "vendor/autoload.php";

  session_start();
 

  $token = new \Tmdb\ApiToken(config.API_KEY);
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
  $session_id = $login_process->getSessionTokenWithLogin($request['request_token'], config.username, config.password);

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

  $getList = $account->getLists($myAccount['id'], ['session_id' => $session_id['session_id']]);


  $list = new \Tmdb\Api\Lists($client);

  $myList = [];

  foreach ($getList['results'] as $listing) {
    array_push($myList, $list->getList($listing['id']));
  }

  /**
   * Grabbing my Rating Movies
   * 
   */
    $myRatings = [];
    $pages = $account->getRatedMovies($myAccount['id'], ['session_id' => $session_id['session_id']]);
    for($total = 1; $total <= $pages['total_pages']; $total++){
      array_push($myRatings, $account->getRatedMovies($myAccount['id'],['session_id' => $session_id['session_id'], 'page' => $total]));
    }


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