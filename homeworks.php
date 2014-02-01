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
         $query = $db->prepare('SELECT * from answers where user_id :uid');
         $query->execute(array(
            'uid' => $uid,
         $result = ($query->fetchAll())[0];
         for($i = 0; $i < )
      }
      function generateLine($piece, $id) {
         global $db;
         //$query = "SELECT * from ANSWERS WHERE id = {$id}";
         $query = $db->prepare('SELECT * from answers where hw_id = :id, piece_num = :piece_num');
         $query->execute(array(
            'id' => $id,
            'piece_num' => $piece_num));
         $result = $query->fetchAll();

         foreach($result as $row) {
            echo "{$row['id']}, {$row['hw_id']}";
         }       
      }
      generateLine(3, 23);
   ?>
   </div>
<? require_once 'footer.php'; ?>