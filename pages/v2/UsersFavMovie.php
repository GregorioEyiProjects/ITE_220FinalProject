<<<<<<< HEAD
<?php
    session_start();
    
    include '../../DB/db_connection.php';  


    $username = isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : "Guest";
    $user_gmail = isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : "";
    $user_hashed_password = isset($_SESSION['user_hashed_password']) ? htmlspecialchars($_SESSION['user_hashed_password']) : "";
    //var_dump($username);
    //var_dump($user_hashed_password);


    //$id_user = $_SESSION['id_user_going'] ?? null;
    $id_user = get_id_user_by_name_and_password($username, $user_hashed_password);
    //var_dump($id_user);

    $get_all_users_favorite_movies = get_all_favorite_movies_by_id_user($id_user);
    //var_dump($get_all_users_favorite_movies);

    if($_SERVER["REQUEST_METHOD"] === "POST") {  
        $id_user_comming = $_POST['id_user'];
        $id_movie_comming = $_POST['id_movie'];
        $delete_fav_movie = deleteUsersFavMovie($id_user_comming, $id_movie_comming);
    
        // Return JSON response
        if ($delete_fav_movie) {
            echo json_encode(["success" => true, "message" => "Movie deleted successfully"]);
        } else {
            echo json_encode(["error" => "Failed to delete movie"]);
        }
        // Debugging statement
        //error_log("Movie deleted, redirecting to HomePage.php");
        //header("Location: UsersFavMovie.php");
        exit();

    }            
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

                            $userID = $movie['id_user'];
                            $userIDMovie = $movie['id_movie'];
                            echo "<div class='movie-card'>";
                                echo "<img class='img_style_2' src='" . $movie["image"] . "' alt='movie image'>";
                                echo "<h3>".$movie['name']."</h3>";
                                echo "<di class = 'watch-delete-container'>";
                                    echo "<a href='".$movie['movie_link']."'>Watch</a>";
                                    echo "<a href='#' onclick='showModal(". $userID .", ". $userIDMovie .")'>Delete</a>";
                                echo "</di>";
                            echo "</div>";
                        }
                    } else {
                        echo "<h3>No favorite movies yet</h3>";
                    }
                ?>
            </div>
            <!-- The Modal -->
            <div id="deleteModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal()">&times;</span>
                    <p style="color: black;">Are you sure you want to delete this movie?</p>
                    <div class="bt_container">
                        <button id="confirmDelete" onclick="confirmDelete()">Yes</button>
                        <button onclick="closeModal()">No</button>
                    </div>
                </div>
            </div>
   </div>

   <script>

    var userIDtoDelete;
    var userIDMovietoDelete;

    function showModal(userID, userIDMovie) {
        userIDtoDelete = userID;
        userIDMovietoDelete = userIDMovie;
        var modal = document.getElementById("deleteModal");
        modal.style.display = "block";
    }

    function closeModal() {
        var modal = document.getElementById("deleteModal");
        modal.style.display = "none";
    }

    function confirmDelete() {
        closeModal();
        delete_fav_movie(userIDtoDelete, userIDMovietoDelete);
    }

    function delete_fav_movie(id_user, id_movie) {
        //alert("Are you sure you want to delete this movie from your favorite list?"+"ID_user: "+ id_user + " ID_movie: " + id_movie);
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "UsersFavMovie.php", true)
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                try {
                    var response = JSON.parse(xhr.responseText);
                    if (response.error) {
                        console.error(response.error);
                        console.log("Debug Info:", response.debug); // Log debug information
                    } else {
                        console.log("Favorite movie:", response);
                        alert("Movie deleted successfully!");
                        location.reload();
                    }
                } catch (error) {
                    console.error(error);
                }
                    
            }
        };
        xhr. send("id_user=" + encodeURIComponent(id_user) + "&id_movie=" + encodeURIComponent(id_movie)); //The & character acts as a separator between these key-value pairs.
    }
</script>
    

</body>
=======
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
>>>>>>> 2465aec46218dbac1bb297b97524c9327b1caeea
</html>