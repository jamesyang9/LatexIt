<? require_once 'header.php'; ?>
   <div>
      <div> 
         <center>Upload file</center>
      </div>
   </div>
   <div>
   <?php
      function generateHWs($uid) {
         global $db;
         //$query = "SELECT * from ANSWERS WHERE id = {$id}";
         $query = $db->prepare('SELECT * from homeworks where user_id = :uid');
         $query->execute(
            array('uid' => $uid)
         );
         $result = $query->fetchAll()[0];
         for($i = 0; $i < $result['num_pieces']; $i++) {
            generateLine($i, $result['id']);
         }
      }

      function generateLine($piece_num, $id) {
         echo "hi";
         global $db;
         //$query = "SELECT * from ANSWERS WHERE id = {$id}";
         $query = $db->prepare('SELECT * from answers where hw_id = :id and piece_num = :piece_num');
         $query->execute(array('id' => $id,
            'piece_num' => $piece_num));
         $result = $query->fetchAll();

         foreach($result as $row) {
            echo "<div>{$row['id']}, <div class = 'tex'> \$x^2\$ {$row['answer']} </div> </div>";
         }
      }
      generateHWs("jamesyan");
   ?>
   </div>
<? require_once 'footer.php'; ?>