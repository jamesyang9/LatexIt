<?
require_once 'algo/imageSegmentation.php';

$db = new PDO('sqlite:db/site.db');

if ($_COOKIE['id'] && array_key_exists('file', $_POST)) {
  $file = $_POST['file'];

  $temp = tmpfile();
  $metaDatas = stream_get_meta_data($temp);
  $fname = $metaDatas['uri'];

  $img = file_get_contents($file);
  file_put_contents($fname, $img);

  $query = $db->prepare('INSERT INTO homeworks (user_id, num_pieces, completed) VALUES(:user_id, :num_pieces, 0)');
  $query->execute(array(
    'user_id' => $_COOKIE['id'],
    'num_pieces' => 0
  ));

  $id = $db->lastInsertId();
  $pieces = cutImage($id, $fname);
  $db->query("UPDATE homeworks SET num_pieces = $pieces WHERE id = $id");
}

echo json_encode(['success']);
?>