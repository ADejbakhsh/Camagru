<!DOCTYPE html>
<html>
<head>
    <title>Camagru</title>
    <link rel="stylesheet" href="../../../css/header.css">
</head>
<body>

    <div class="header">
      <a href="../../index.php" class="logo">Camagrue</a>
      <div class="header-right">
        <a class="active" href="../../index.php" title="Home" >Home</a>
    <?PHP
    if (!isset($_SESSION['user']))
    {
        echo "<a href=\"../../../user/login_page.php\" title=\"Login\" >Login</a>";
        echo  "<a href=\"../../../user/register_page.php\" title=\"Register\" >Register</a>";
    }
    else
    {
      echo  "<a href=\"../../../user/Deconexion.php\" title=\"Deconexion\" >Deconexion</a>";
    }
    if ($_SESSION['permission'] == "admin")
      echo "<a href=\"../../../admin_page.php\" title=\"admin\">Admin</a>";
    ?>
      </div>
    </div>
    </body>
    </html>