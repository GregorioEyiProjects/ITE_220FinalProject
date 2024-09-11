<?php
    session_start();
    
    include '../../DB/db_connection.php';  


    $username = isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : "Guest";
    $user_gmail = isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : "";
    $user_hashed_password = isset($_SESSION['user_hashed_password']) ? htmlspecialchars($_SESSION['user_hashed_password']) : "";
    var_dump($username);
    //svar_dump($user_hashed_password);


    //$id_user = $_SESSION['id_user_going'] ?? null;
    $id_user = get_id_user_by_name_and_password($username, $user_hashed_password);
    //var_dump($id_user);

    $get_all_users_favorite_movies = get_all_favorite_movies_by_id_user($id_user);
    //var_dump($get_all_users_favorite_movies);

              
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../Styles/V2/usersFavMovie.css">
    <link rel="stylesheet" href="../../Styles/V2/general.css">    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Favorite movies</title>
</head>
<body>
    

   <!-- MAIN CONTAINER -->
   <div class="content_wrapper">
        <div class="column-container">
            
            <div class="user-profile">
                <?php
                    $username = isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : "Guest";
                    echo "<h4 class='user-name'>Hi, $username</h4>";
                ?>            
            </div>

            <div class="fav-movies">
                <h2 class="fav-movies">
                    <a href="HomePage.php">Favorite movies</a>
                </h2>
            </div>

            <div class="fav-movies-container">
                <?php
                    if ($get_all_users_favorite_movies) {
                        foreach ($get_all_users_favorite_movies as $movie) {
                            echo "<div class='movie-card'>";
                                echo "<img class='img_style_2' src='" . $movie["image"] . "' alt='movie image'>";
                                echo "<h3>".$movie['name']."</h3>";
                                echo "<di class = 'watch-delete-container'>";
                                    echo "<a href='".$movie['movie_link']."'>Watch</a>";
                                    echo "<a href='delete_fav_movie.php?id=".$movie['id_movie']."'>Delete</a>";
                                echo "</di>";
                            echo "</div>";
                        }
                    } else {
                        echo "<h3>No favorite movies yet</h3>";
                    }
                ?>
            </div>
   </div>
    

</body>
</html>