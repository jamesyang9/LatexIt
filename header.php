<?
$db = new PDO('sqlite:db/site.db');
$posted = false;
if (array_key_exists('post', $_POST)) {
  setcookie('name', substr(trim(htmlentities($_POST['name'])), 0, 20));
  setcookie('id', uniqid());
  $posted = true;
}

$page = basename($_SERVER['PHP_SELF']);
if (!array_key_exists('id', $_COOKIE) && !$posted && $page != 'login.php') {
  header('Location: login.php');
}

?>
<!DOCTPYE html>
<html>
  <head>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
   </head>
  <body>
    <div class="navbar">
      <div class="container">
        <div class="navbar-header">
          <a class="navbar-brand" href="index.php">LatexIt</a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="index.php">Game</a></li>
            <li><a href="homeworks.php">Files</a></li>
          </ul>
          <div class="navbar-right">
            <ul class="nav navbar-nav">
              <li><a href="#"><?= $_COOKIE['name']; ?></a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
