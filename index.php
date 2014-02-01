<?
$db = new PDO('sqlite:db/site.db');

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
      <div class="row">
        <div class="col-md-6" id="upload">
          <h2>Homework upload</h2>
        </div>
        <div class="col-md-6">
          <h2>Stats</h2>
          WPM: ???
        </div>
      </div>
      <div class="row" style="margin-top:20px;">
        <div class="col-md-6" id="guesser">
          <h2>Guesser <div id="timer" class="pull-right">00:00</div></h2>
          <div id="sample">
            <img src="http://lorempixel.com/555/100/animals" />
          </div>
          <div id="input">
            <textarea placeholder="Your guess..."></textarea>
          </div>
          <div id="output">
          </div>
          <button class="btn btn-lg btn-primary pull-right">Submit</button>
        </div>
      </div>
    </div>
    <script src="https://www.dropbox.com/static/api/2/dropins.js" id="dropboxjs" data-app-key="kgnjjrr9ywdj8z5"></script>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
    <script src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>
    <script src="js/app.js"></script>
  </body>
</html>