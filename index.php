<? require_once 'header.php'; ?>
      <div id="play">
        <div id="playbtn">
          <img src="images/play.png" />
          <div id="description">Get ready to LaTeX!</div>
          <div id="waiting">Waiting for players<span id="ellipsis">...</span></div>
        </div>
        <div id="scoreboard">
          <ol id="scores">
          </ol>
        </div>
        <div class="row" id="guesser">
          <div id="timer">
            0:00
          </div>
          <div id="sample">
            <img />
          </div>
          <div id="input">
            <textarea placeholder="Type your latex here..."></textarea>
          </div>
          <div id="output">
          </div>
        </div>
      </div>
<? require_once 'footer.php'; ?>