<?PHP
require_once($_SERVER["DOCUMENT_ROOT"] . "/src/utils.php");
require_once(path("/config/db_utils.php"));

#add picturs to user
function add_pic_to_user($pic_name)
{
    global $DB_connect;

    if (fetch_user_id())
    {
        $statement =  $DB_connect->prepare("INSERT INTO db.img(name, user_id) VALUES (:pic_name, :user_id);");
        $statement->execute(['pic_name' => $pic_name,'user_id' => fetch_user_id()]);
        return (true);
    }
    else
        return (false);
}

#delet picture
function del_pic_of_user($pic_name)
{

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


?>