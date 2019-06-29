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

function add_comment($img_id, $body)
{
    global $DB_connect;
    
    $statement =  $DB_connect->prepare("INSERT INTO db.commentary (img_id, body, user_id) WHERE VALUES (:img_id, :body , :user_id)");
    $statement->execute(['img_id' => $img_id, 'body' => $body , 'user_id' => $_SESSION['user_id']]);
        
    #change data type for comment
    $statement =  $DB_connect->prepare("INSERT INTO db.commentary (img_id, body, user_id) WHERE VALUES (:img_id, :body , :user_id)");
    $statement->execute(['img_id' => $img_id, 'body' => $body , 'user_id' => $_SESSION['user_id']]);
    
}

?>