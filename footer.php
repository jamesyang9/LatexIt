      <div id="footer">
        <div id="tops">
          <table>
            <? $query = $db->query("SELECT answerer_id SUM(score) as s FROM answers GROUP BY answerer_id SORT by s");
            ?>
            <tr>
              <td>Will</td>
              <td>132</td>
            </tr>
            <tr>
              <td>James</td>
              <td>110</td>
            </tr>

            <tr>
              <td>Patrick</td>
              <td>95</td>
            </tr>

            <tr>
              <td>Maryyann</td>
              <td>92</td>
            </tr>

          </table>
        </div>
        <img src="images/footer.png" />
      </div>
    </div>
    <script src="https://www.dropbox.com/static/api/2/dropins.js" id="dropboxjs" data-app-key="kgnjjrr9ywdj8z5"></script>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
    <script src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>
    <script src="http://willcrichton.net:8000/socket.io/socket.io.js"></script>
    <script> var USER_ID = '<?= $_COOKIE['id']; ?>'; var USER_NAME = '<?= $_COOKIE['name']; ?>';</script>
    <script src="js/app.js"></script>
  </body>
</html>