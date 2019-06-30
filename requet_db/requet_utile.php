<?PHP
require_once($_SERVER["DOCUMENT_ROOT"] . "/src/utils.php");
require_once(path("/config/db_utils.php"));

#add picturs to user
function add_pic_to_user($pic_name)
{
    global $DB_connect;

    if ($_SESSION['user_id'])
    {
        $statement =  $DB_connect->prepare("INSERT INTO db.img(name, user_id) VALUES (:pic_name, :user_id);");
        $statement->execute(['pic_name' => $pic_name,'user_id' => $_SESSION['user_id']]);
        return (true);
    }
    else
        return (false);
}

#delet picture
function del_pic_of_user($pic_name)
{
    global $DB_connect;

        $statement =  $DB_connect->prepare("DELETE FROM db.img WHERE name = :pic_name AND user_id = :user_id;");
        $statement->execute(['pic_name' => $pic_name,'user_id' => $_SESSION['user_id']]);
        return (true);
}

function fetch_user_id()
{  
    global $DB_connect;
    if(isset($_SESSION['login']) && $_SESSION['login'] != NULL)
    {
        $statement =  $DB_connect->prepare("SELECT id FROM db.user WHERE login = :login");
        $statement->execute(['login'=> $_SESSION['login']]);
        return ($statement->fetch()['0']);
    }
    else
        return (false);
}


# return bool if the img belong to the user
function img_belong_to_user($img)
{
	global $DB_connect;

	$statement = $DB_connect->prepare("SELECT user_id FROM db.img WHERE name = :img");
	$statement->execute(['img' => $img]);
	if ($statement->fetch()['0'] = $_SESSION['user_id'])
        return(true);
	return(false);
}

function fetch_all_pic($limit)
{
    global $DB_connect;
 
        $statement =  $DB_connect->prepare("SELECT name FROM db.img ORDER BY id LIMIT $limit, 5");
        $statement->execute();

        $array = Array();
        foreach($statement->fetchAll() as $tmp => $ttt)
        {
            array_push($array, $ttt['0']);
        }
        return ($array);
}

function fetch_all_pic_of_user()
{
    global $DB_connect;
 
        $statement =  $DB_connect->prepare("SELECT name FROM db.img WHERE user_id = :user_id");
        $statement->execute(['user_id' => $_SESSION['user_id']]);

        $array = Array();
        foreach($statement->fetchAll() as $tmp => $ttt)
        {
            array_push($array, $ttt['0']);
        }
        return ($array);
}

function add_comment($img_name, $body)
{
    global $DB_connect;
    
    $statement =  $DB_connect->prepare("SELECT id FROM db.img WHERE name = :img_name LIMIT 1");
    $statement->execute(['img_name' => $img_name]);
    $tmp = $statement->fetch()['0'];
    $statement =  $DB_connect->prepare("INSERT INTO db.commentary (img_id, body, user_id) VALUES ( $tmp ,:body , :user_id)");
    $statement->execute(['body' => $body , 'user_id' => $_SESSION['user_id']]);

    #send a mail to the posssor of img
    $statement =  $DB_connect->prepare("SELECT user.email 
        FROM db.img
        INNER JOIN db.user ON img.user_id = user.id 
        WHERE img.name = :img_name AND want_mail = :yes;");
    $statement->execute(['img_name' => $img_name, 'yes' => 'yes']);
    mail($statement->fetch()['0'], "someone commented your img on CAMAGRU", "go check it out");
}

function fetch_all_comment_of_image($imag_name)
{
    global $DB_connect;
 
        $statement =  $DB_connect->prepare("SELECT login, body 
        FROM db.commentary 
        INNER JOIN db.user ON commentary.user_id = user.id 
        INNER JOIN db.img ON img.id = commentary.img_id 
        WHERE img.name = :img_name;
        ORDER BY commentary.id
        ");
        $statement->execute(['img_name' => $imag_name]);
        $array = Array();
        foreach($statement->fetchAll() as $tmp => $ttt)
        {
            array_push($array, put_comment($ttt['login'], $ttt['body']));
        }
        return ($array);
}

function like($img_name)
{
    global $DB_connect;

    $statement =  $DB_connect->prepare("SELECT id FROM db.img WHERE name = :img_name LIMIT 1");
    $statement->execute(['img_name' => $img_name]);
    $tmp = $statement->fetch()['0'];
    $statement =  $DB_connect->prepare("INSERT INTO db.like (img_id, user_id) VALUES ($tmp, :user)");
    $statement->execute(['user' => $_SESSION['user_id']]);
}

function unlike($img_name)
{
     global $DB_connect;
 
        $statement =  $DB_connect->prepare("DELETE db.like
        FROM
            db.like
        INNER JOIN db.img ON like.img_id = img.id
        WHERE img.name = :img_name AND like.user_id = :user_id ");
        $statement->execute(['img_name' => $img_name, 'user_id' => $_SESSION['user_id']]);
}

function is_liked($img_name)
{
     global $DB_connect;
 
        $statement =  $DB_connect->prepare("SELECT db.like.id
        FROM db.like 
        INNER JOIN db.img ON img.id = like.img_id
        WHERE img.name = :img_name AND like.user_id = ".$_SESSION['user_id']);
        $statement->execute(['img_name' => $img_name]);
        if (count($statement->fetchAll()) === 0)
            return ("false");
        else
            return("true");
}
?>
