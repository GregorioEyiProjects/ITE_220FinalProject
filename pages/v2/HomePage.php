<?php
    
    session_start(); 
    
    include '../../DB/db_connection.php';  
   
    // Initialize variables
    $year = null;
    $genre = null;
    $country = null;
    $filtered_movies = null;

    //$user_hashed_pass_coming = $_POST['user_gmail_going'] ?? null; user_hashed_password
    $user_hashed_pass = isset($_SESSION['user_hashed_password']) ? htmlspecialchars($_SESSION['user_hashed_password']) : "";

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        // Handle GET request
        $year = isset($_GET['year']) ? $_GET['year'] : null;
        $genre = isset($_GET['genre']) ? $_GET['genre'] : null;
        $country = isset($_GET['country']) ? $_GET['country'] : null;
        $movie_name = isset($_GET['movie_name']) ? $_GET['movie_name'] : null;
        $movie_name = $movie_name . "%";
    
        if ($year || $genre || $country) {
            $filtered_movies = get_movie_by_year_or_genre_or_country($year, $genre, $country);
        } elseif ($movie_name) {
            $filtered_movies = get_movie_by_name($movie_name);
        } else {
            $filtered_movies = get_movie_data();
        }
    }  elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Handle POST request
        $movieId_coming = $_POST['movie_id'] ?? null;
        $userName_coming = $_POST['user_name_going'] ?? null;
        $user_hashed_pass_coming = $_POST['user_hashed_password_going'] ?? null;
    
        if ($userName_coming && $user_hashed_pass_coming) {
            $id_user = get_id_user_by_name_and_password($userName_coming, $user_hashed_pass_coming);
            $add_fav_movie = insert_users_fav_movie($id_user, $movieId_coming);
    
            if ($add_fav_movie) {
                echo json_encode(["success" => true, "message" => "Movie added to watchlist successfully"]);
            } else {
                echo json_encode(["error" => "Error adding movie to watchlist"]);
            }
        } else {
            echo json_encode(["error" => "Error adding movie to watchlist"]);
        }
        exit; // Ensure no further output is sent
    } else {
        $filtered_movies = get_movie_data(); // Default to original data if no GET request
    }
                        
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../Styles/V2/home_page_v2.css">
    <link rel="stylesheet" href="../../Styles/V2/general.css">
    <link rel="stylesheet" href="../../Styles/V2/movie_description.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Home</title>
</head>
<body>
    
    <!-- MAIN CONTAINER -->
    <div class="content_wrapper">

        <div class="user-profile add_movie_btn_container">
            <?php
                $username = isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : "Guest"; //coming from the register page
                $user_gmail = isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : "";  //coming from the register page
 
                //echo "<h4 class='user-name'>Welcome, $username</h4>";
                echo "<span class='user-profile-container add_movie_btn_container'>";
                    
                    echo "<h4 class='user-name '>";
                        if($username !== "Guest"){
                            echo "<a href='UsersFavMovie.php' class='user-name'>Welcome, $username</a>";
                        }else{
                            echo "<a href='Login.php' class='user-name'>Welcome, Guest</a>";
                        }
                    echo "</h4>";
                    
                    echo "<div class='hover-text'>";
                        echo "<button class='hover-button' onclick=\"window.location.href='UsersFavMovie.php'\">Favorite movie</button>";
                        if($username !== "Guest"){
                            echo "<button class='hover-button' onclick=\"window.location.href='Logout.php'\">Logout</button>";
                        }else{
                            echo "<button class='hover-button' onclick=\"window.location.href='logout.php'\">Log in</button>";
                        }
                    echo "</div>";

                echo "</span>";
            ?>            
        </div>

        <h4></h4>
        
        <!--TOP MOVIES 2024 & SEARCH INPUT AND BTN-->
        <div class="top_movies_2024_container"> 
            <div class="desciption_and_list_of_movie_container">
                <h1 class="top_description_text">
                    <a class="home_page_title" href="HomePage.php">TOP MOVIES 2024</a>
                </h1>
                <div class="list_of_movies_container">
            
                </div>
            </div>

            <div class="search">
                <form action="HomePage.php" method="get">
                    <input class="search_movie" type="text" name="movie_name" class="searchTerm" placeholder="What are you looking for?">
                    <button type="submit" class="searchButton">
                        <i class="fa fa-search"> </i>
                    </button>
                </form>
            </div>
        </div>

        <!--CATEGORY (YEAR, GENRE, COUNTRY) CONTAINER-->
        <div class="">
            <form class="category_container" action="HomePage.php" method="get">
                <!--YEAR CATEGORY -->
                <div class="year_category">
                    <div class="option_container">
                        <select class="dropdown-menu" name="year">
                            <option class="disable_option" disabled selected>Year</option>
                            <option value="2024">2024</option>
                            <option value="2023">2023</option>
                            <option value="2022">2022</option>
                            <option value="2021">2021</option>
                            <option value="2020">2020</option>
                        </select>
                    </div>
                </div>

                <!--GENRE CATEGORY -->
                <div class="genre_category">
                    <select class="dropdown-menu" name="genre">
                        <option class="disable_option" disabled selected>Genre</option>
                        <option value="action">Action</option>
                        <option value="comedy">Comedy</option>
                        <option value="drama">Drama</option>
                        <option value="horror">Horror</option>
                        <option value="sci-fi">Sci-Fi</option>
                    </select>
                </div>

            
                <!--COUNTRY CATEGORY -->    
                <div class="country_category">
                    <select class="dropdown-menu" name="country">
                        <option class="disable_option" disabled selected>Country</option>
                        <option value="US">US</option>
                        <option value="UK">UK</option>
                        <option value="RUS">RUS</option>
                        <option value="ES">ES</option>
                        <option value="KR">KR</option>
                    </select>    
                </div>

                <div class="button_container">
                    <button type="submit" class="searchButton">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </form>

        </div>

        <!-- LIST OF MOVES CONTAINER-->
        <?php
    if($filtered_movies->num_rows > 0){
    while($row = $filtered_movies->fetch_assoc()){
       
        echo "<div class='movie_item' style='position: relative;'>"; // Add padding to avoid overlap
            
            echo "<div class='movie_foto_container'>";
                echo "<img class='img_style_2' src='" . $row["image"] . "' alt=''>";
            echo "</div>";
            
            echo "<div class='movie_details_container'>";
                
                echo "<div class='movie_description_container'>";
                    
                    echo "<div class='movie_title_container'>";
                        
                        echo "<div class='movie_title'>";
                            echo "<h2 class='movie_title'>" . $row["name"] . "</h2>";
                        echo "</div>";

                        // Position 'Add to watchlist' button in the top-right corner
                        echo "<span class='add_movie_btn_container' style='position: absolute; top: 0; right: 0; z-index: 1;'>";
                            echo "<button onclick='handleAddToWatchlist(" . $row["id_movie"] . ", \"" . addslashes($username) . "\", \"".addslashes($user_hashed_pass)."\")' class='add_movie_btn hover-button2'>";
                                echo "<i class='fa fa-add moreCss'></i>";
                            echo "</button>";

                            echo "<div class='hover-text'>";
                                echo "<p class='hover-text'>Add to watchlist</p>";
                            echo "</div>";

                        echo "</span>";

                    echo "</div>";

                    echo "<h3 class='movie_country'>"."Country: " . $row["country"] . "</h3>";
                    echo "<h3 class='movie_ratings'>"."Ratings: " . $row["rating_score"]. "/10". "</h3>";
                    echo "<h4 class='movie_description_title'>" ."Description". "</h4>";  
                    echo "<p class='movie_description'>" . $row["description"] . "</p>";  

                echo "</div>";

                // Position 'Watch' button in the bottom-right corner
                echo "<div class='movie_link_container' style='position: absolute; bottom: 0; right: 0;'>";
                    echo "<button class='movie_btn' style='width: 100px; height: 40px;' >";  // Set fixed width and height
                        echo "<a href='MovieDescription.php?id=".$row["id_movie"]."' class='movie_link_2'></a>";
                    echo "</button>";
                echo "</div>";

            echo "</div>";

        echo "</div>"; // Close the wrapper for each movie item
    }
}
?>


    
  <!-- FOOTER CONTAINER -->
<footer>
        <div class="footer-content">
            <div class="footer-links">
                <ul>
                    <li><a href="#" >About Us</a></li>
                    <li><a href="ContactPage.php">Contact</a></li>
                    <li><a href="#">Terms of Service</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-copyright">
            &copy; 2024 Movieland Ltd. All rights reserved.
        </div>
</footer>

<!---->
<script>

    function handleAddToWatchlist(movieId, user_name, user_hashed_pass_coming) {

       // alert("Adding movie with ID: " + movieId + " for user: " + user_name + " (" + user_hashed_pass_coming + ")");

        if (!<?php echo isset($_SESSION['username']) ? 'true' : 'false'; ?>) {
            window.location.href = 'Register.php';
        } else {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "HomePage.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    try {
                        var response = JSON.parse(xhr.responseText);
                        if (response.error) {
                            console.error(response.error);
                            onsole.log("Debug Info:", response.debug); // Log debug information
                        } else {
                            console.log("Favorite movies:", response);
                            alert("Movie added successfully!");
                        }
                    } catch (error) {
                        console.error(error);
                    }
                }
            };
            xhr.send("movie_id=" + movieId + "&user_name_going=" + encodeURIComponent(user_name) + "&user_hashed_password_going=" + encodeURIComponent(user_hashed_pass_coming));
        }
    }

</script> 


</body>
</html>