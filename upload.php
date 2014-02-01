<?
$db = new PDO('sqlite:db/site.db');

if ($_COOKIE['id'] && array_key_exists('file', $_POST)) {
  $file = $_POST['file'];

  // process file...

  $query = $db->prepare('INSERT INTO homeworks (user_id, num_pieces) VALUES(:user_id, :num_pieces)');
  $success = $query->execute(array(
    'user_id' => $_COOKIE['id'],
    'num_pieces' => 1
  ));
  
  if (!$success) {
    print_r($query->errorInfo());
  } 
}

echo json_encode(['success']);
?>