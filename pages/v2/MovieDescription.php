<?php
    include("../../DB/db_connection.php");
    
    $movie_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    //var_dump($movie_id);
    $get_main_cast = get_main_cast_by_id($movie_id);
    $get_movie_genre = get_movie_genre($movie_id);

?>

    
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../Styles/V2/general.css">
    <link rel="stylesheet" href="../../Styles/V2/movie_description.css">
    
    <title>Movieland</title>
</head>
<body>
    
    <!-- MAIN CONTAINER -->
    <div class="main_container">
        
        <!-- FTITLE -->
        <h1 class="web_title">
            <a class="web_title_link" href="HomePage.php">MOVIELAND</a>
        </h1>
        
        
        <?php 
        if($movie_id > 0){
            $result = get_movie_details_by_id($movie_id);
            if($result->num_rows > 0){
                $movie = $result->fetch_assoc();
                $youtube = $movie["video"];
                echo "<div class = 'div_row_container'>";  //<!-- MOVIE DESCRIPTION CONTAINER -->
                    
                    echo "<div class='title_image_container'>";   //<!-- TITLE & IMAGE CONTAINER -->
                        echo "<img class='img_movie_style_style' src='" . $movie["image"] . "'>";
                    echo "</div>";

                    echo "<div class='details_container'>"; //<!-- MOVIE DETAILS CONTAINER -->
                        echo "<h2 class='movie_title'>" . $movie["name"] . "</h2>";
                        echo "<p class='custom_text'>Year: " . "<span class='custom_text'>" . $movie["year_of_release"] . "</span>" . "</p>";
                        echo "<p class='custom_text'>Rating: " ."<span class='custom_text'>" . $movie["rating_score"]. "</span> ".  "/10" . "</p>"; 
                        echo "<p class='custom_text'>Director: " . "<span class='custom_text'>" . $movie["director"]. "</span>" . "</p>";
                        echo "<div class='genre_container'>"; //<!-- GENRE CONTAINER -->
                            if($get_movie_genre->num_rows > 0){                            
                                $genres = [];
                                //echo "<p class='custom_text'>Genre: "; echo "</p>";
                                while ($movie_genre = $get_movie_genre->fetch_assoc()) {
                                    $genres[] = "<span class='custom_text'>" . $movie_genre["name_genre"] . "</span>";
                                   // echo "<span class='custom_text'>" . $movie_genre["name_genre"] . "</span> ";
                                }
                                echo "<p class='custom_text'>Genre: " . implode(", ", $genres) . "</p>"; //inplode used to join array elements with a (,) string
                                
                            }
                        echo "</div>";
                        echo "<h3 class = 'custom_description'>Description</h3>";
                        echo "<p class='cus_description_text'>" . $movie["description"] . "</p>";
                        echo '<a href="' . $movie["movie_link"] . '" class= "movie_link">Watch movie here</a>';
                    echo "</div>";

                echo "</div>";
            }
        }
        ?>
       
    
      
        <?php
        echo "<div class='video_container'>"; //<!-- VIDEO CONTAINER -->
            if (!empty($youtube)) {
                $parsedUrl = parse_url($youtube);
                if (isset($parsedUrl['query'])) {
                    parse_str($parsedUrl['query'], $urlParams);
                    if (isset($urlParams['v'])) {
                        $video_id = $urlParams['v'];
                        echo "<iframe width='720' height='415' src='https://www.youtube.com/embed/" . $video_id . "' frameborder='0' allow='accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>";
                    } else {
                        echo "<p>Invalid YouTube URL: Missing video ID.</p>";
                    }
                } else {
                    echo "<p>Invalid YouTube URL: Missing query parameters.</p>";
                }
            } else {
                echo "<p> No video URL provided.</p>";
            }
        echo "</div>";
        ?>

        <?php
        echo "<h3 class='main_cast_text'> Main cast </h3>"; //<!-- MAIN CAST CONTAINER -->
        echo "<div class='main_cast_container'>";
            if($get_main_cast->num_rows > 0 ){
                while($row = $get_main_cast->fetch_assoc()){ 
                    echo "<div class ='cast_member'>";
                        echo "<img class='img_style' src='" . $row["character_image"] . "'>";
                        echo "<h3 class='actor_name'>" . $row["actor_name"] . "</h3>";
                    echo "</div>";
                }
            }
        echo "</div>";
        ?>
      
    </div>
    
  <!-- FOOTER CONTAINER -->
  <footer>
        <div class="footer-content">
            <div class="footer-links">
                <ul>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Contact</a></li>
                    <li><a href="#">Terms of Service</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-copyright">
            &copy; 2024 Movieland Ltd. All rights reserved.
        </div>
    </footer>

</body>
</html>