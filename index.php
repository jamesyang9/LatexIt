<? require_once 'header.php'; ?>
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
<? require_once 'footer.php'; ?>