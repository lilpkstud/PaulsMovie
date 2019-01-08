<?
require "vendor/autoload.php";

$token = new \Tmdb\ApiToken('#');
$client = new \Tmdb\Client($token);




$repository = new \Tmdb\Repository\MovieRepository($client);
$movie = $repository->load(87421);

//var_dump($repository);
//var_dump($movie->getTitle());

//$guest = new \Tmdb\Api\Authentication\Authentication($client);

$account = new \Tmdb\Api\Authentication($client);

$request_token = $account->getNewToken();



//What happens if I dont authenticate the Request Token?
//$account->authenticateRequestToken($request_token['request_token']);


//var_dump($paul['session_id']);
//die();

$paul_account = new Tmdb\Api\Account($client, $paul['session_id']);
//$paul_favorite = $paul_account->getLists('8198406');


var_dump($paul_favorite);
//die();


var_dump("Made it");
die();

//header('Location: /views/main.php');
//die();

//$hi = $account->getNewSession($request_token['request_token']);
//$guest = $account->getNewGuestSession();

//var_dump($request_token['request_token']);
//var_dump($hi);
//die();

?>