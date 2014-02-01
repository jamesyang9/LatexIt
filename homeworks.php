<? require_once 'header.php'; ?>
   <div>
      <center>
      <div id="upload"> 
         Upload file <br>
      </div>
      <br>
      </center>
   </div>
   <div>
   <div class="lhalf">
   <?php
      $hack_num_lines;
      function generateHWs($uid) {
         global $db, $hack_num_lines;
         //$query = "SELECT * from ANSWERS WHERE id = {$id}";
         //$query = $db->prepare('DELETE FROM answers WHERE answer = ""');
         //$query->execute();
         $query = $db->prepare('SELECT * FROM homeworks WHERE user_id = :user_id');
         $query->execute(array('user_id' => $_COOKIE['id']));
         $result = $query->fetchAll();
         if ($result) {
            $result = $result[count($result) - 1];

            for($i = 0; $i < $result['num_pieces']; $i++) {
               generateLine($i, $result['id']);
            }
            $hack_num_lines = $result['num_pieces'];
         }
         else {
            echo "<center><h1 id ='noFiles'>No files uploaded yet</h1></center>";
         }
      }

      function generateLine($piece_num, $id) {
         global $db;
         $image_url = "images/latex/".$id."_".$piece_num.".png";
         echo "<div class='hwline'> Line: $piece_num <img class='lineimg' src='$image_url'></img> <div class='answersWrap'>";
         $query = $db->prepare('SELECT * from answers where hw_id = :id and piece_num = :piece_num');
         $query->execute(array('id' => $id,
            'piece_num' => $piece_num));
         $result = $query->fetchAll();

         foreach($result as $row) {
            echo "<div class = 'tex' data-n=\"{$piece_num}\" data-text=\"{$row['answer']}\">{$row['answer']}</div>";
         }
         echo "<div class = 'tex' data-n=\"{$piece_num}\" data-text=\"\n\">None</div>";
         echo "</div></div>";
      }
      generateHWs($_COOKIE['id']);
   ?>
   </div>
   
   <div class="rhalf"> 
      <div style="float:left">Preview</div>
      <div style="float:right">
         <div id="generatePDF">Generate PDF</div>
         <div id="generateTEX">Generate TeX</div>
      </div>
      
      <div id="preview" class="tex preview">
         <?php
            for ($i = 0; $i < $hack_num_lines; $i++) {
               echo "<div> </div>";
            }
         ?>
      </div>
      <div style="clear:both;"></div>
   </div>
   <div style="clear:both;"></div>
   </div>
<? require_once 'footer.php'; ?>