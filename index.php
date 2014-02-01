<?
$posted = false;
if (array_key_exists('post', $_POST)) {
  setcookie('name', substr(trim(htmlentities($_POST['name'])), 0, 20));
  setcookie('id', uniqid());
  $posted = true;
}
?>
<!DOCTPYE html>
<html>
  <head>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
   </head>
  <body>
    <? if (!array_key_exists('id', $_COOKIE) && !$posted): ?>
    <div id="overlay">
      <form method="POST">        
        <input type="text" placeholder="Enter a name..." name="name" />
        <input type="hidden" name="post" value="name" />
        <input type="submit" />
      </form>
    </div>
    <? endif ?>
    <div class="navbar navbar-inverse">
      <div class="container">
        <div class="navbar-header">
          <a class="navbar-brand" href="#">LatexIt</a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
              <li><a href="#">Stats</a></li>
              <li><a href="#">Homework</a></li>
            </ul>
        </div>
      </div>
    </div>
    
    <div class="container">
      
    </div>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
    <script src="js/app.js"></script>
  </body>
</html>