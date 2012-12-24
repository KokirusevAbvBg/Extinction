<head>
    <title>Extinction</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
<div class="regbar">
    <?php
        require_once('connect_db.php');
        require_once('functions.php');

        if(isset($_POST['logout'])){
            session_destroy();
            header("Location: index.php"); 
        }

        if (isset($_SESSION['username'])) {
            // echo 'Hello ' . $_SESSION['username']. '';
            echo '      <form name="logout" class="logout" method="post"> 
            Hello ' . $_SESSION['username'] . ' 
            <input type="submit" value="Logout" name="logout" class="logoutbutton" />  
            </form>';
        }else{
            echo'<ul class="regbar">
            <li><a href="login.php">Login</a></li>
            <li><a href="register.php">Register</a></li>
            </ul>';
        }
    ?>
</div>    


<div id="title">
    <h1>Extinction</h1>
</div>

<div class="navbar"> 
    <ul class="navbar">
        <li><a href="index.php">Home</a></li>
        <li><a href="#">Your Hero</a></li> 
        <li><a href="#">Item Store</a></li>
        <li><a href="#">Arena</a></li>  
        <li><a href="#">Quests</a></li>    
    </ul>
    </div>

