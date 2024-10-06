
<?php

$user_server = "localhost";
$user_name = "root";
$password = "";
$db_name = "ITE_220";

$conn = new mysqli($user_server, $user_name, $password, $db_name);

if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}else{
    //echo "Connected successfully";
}

$conn -> select_db($db_name);

//QUERIES

//get all movies from the DB 
$sql = "SELECT movie.id_movie, movie.name, movie.year_of_release, movie.director, movie.description, movie.movie_link ,ratings.rating_score,trailer.image, trailer.video
FROM movie
INNER JOIN ratings ON movie.id_movie = ratings.id_movie
INNER JOIN trailer ON movie.id_movie = trailer.id_movie";

//get movie detials by ID MOVIE from the DB 
$get_movie_details = "SELECT movie.name, movie.year_of_release, movie.director, movie.country ,movie.description, movie.movie_link ,ratings.rating_score,trailer.image, trailer.video, genre.name_genre
FROM movie
INNER JOIN ratings ON movie.id_movie = ratings.id_movie
INNER JOIN trailer ON movie.id_movie = trailer.id_movie 
INNER JOIN movie_genre ON movie.id_movie = movie_genre.id_movie
INNER JOIN genre ON movie_genre.id_genre = Genre.id_genre
WHERE movie.id_movie = ?;";

//get movie gender by movie id from the DB 
$get_movie_genre_by_movie_id = "SELECT genre.name_genre
FROM movie
INNER JOIN movie_genre ON movie.id_movie = movie_genre.id_movie
INNER JOIN genre ON movie_genre.id_genre = Genre.id_genre
WHERE movie.id_movie = ?;";

//get main cast by movie id from the DB 
$get_main_cast_by_id_movie = "SELECT main_cast.character_name AS actor_name, main_cast.character_image
FROM movie
INNER JOIN movie_maincast ON movie.id_movie = movie_maincast.id_movie
INNER JOIN main_cast ON movie_maincast.id_character = main_cast.id_character WHERE movie.id_movie = ?;";

//get movie by year
$get_movie_by_year = "SELECT movie.id_movie, movie.name, movie.year_of_release, movie.director, movie.country, movie.description, 
movie.movie_link ,ratings.rating_score,trailer.image, trailer.video
FROM movie
INNER JOIN ratings ON movie.id_movie = ratings.id_movie
INNER JOIN trailer ON movie.id_movie = trailer.id_movie 
WHERE movie.year_of_release = ?;";

// get movie by genre
$get_movie_by_genre = "SELECT movie.id_movie, movie.name, movie.year_of_release, movie.director, movie.country, movie.description, 
movie.movie_link ,ratings.rating_score,trailer.image, trailer.video, genre.name_genre
FROM movie
INNER JOIN ratings ON movie.id_movie = ratings.id_movie
INNER JOIN trailer ON movie.id_movie = trailer.id_movie 
INNER JOIN movie_genre ON movie.id_movie = movie_genre.id_movie
INNER JOIN genre ON movie_genre.id_genre = Genre.id_genre
WHERE genre.name_genre = ?;";

// get movie by country
$get_movie_by_country = "SELECT movie.id_movie, movie.name, movie.year_of_release, movie.director, movie.country, movie.description, 
movie.movie_link ,ratings.rating_score,trailer.image, trailer.video
FROM movie
INNER JOIN ratings ON movie.id_movie = ratings.id_movie
INNER JOIN trailer ON movie.id_movie = trailer.id_movie
WHERE movie.country = ?;";


// get movie by genre or country or year
$get_movie_by_custom_or_filters = "SELECT movie.id_movie, movie.name, movie.year_of_release, movie.director, movie.country, movie.description, 
movie.movie_link ,ratings.rating_score,trailer.image, trailer.video, genre.name_genre
FROM movie
INNER JOIN ratings ON movie.id_movie = ratings.id_movie
INNER JOIN trailer ON movie.id_movie = trailer.id_movie 
INNER JOIN movie_genre ON movie.id_movie = movie_genre.id_movie
INNER JOIN genre ON movie_genre.id_genre = Genre.id_genre
WHERE movie.year_of_release = ? OR movie.country= '?' OR genre.name_genre = '?';";

// get movie by NAME
$get_movie_by_name_from_BD = "SELECT movie.id_movie, movie.name, movie.year_of_release, movie.director, movie.country, movie.description, 
movie.movie_link ,ratings.rating_score,trailer.image, trailer.video
FROM movie
INNER JOIN ratings ON movie.id_movie = ratings.id_movie
INNER JOIN trailer ON movie.id_movie = trailer.id_movie 
WHERE  movie.name LIKE ?;";

//get all favorite movies by user id
$get_all_users_fav_movies = "SELECT movie.id_movie, movie.name, movie.year_of_release, movie.director, movie.description, movie.movie_link ,ratings.rating_score,trailer.image, trailer.video, users.username, users.id_user
FROM movie
INNER JOIN ratings ON movie.id_movie = ratings.id_movie
INNER JOIN trailer ON movie.id_movie = trailer.id_movie
INNER JOIN users_movie ON movie.id_movie =  users_movie.id_movie
INNER JOIN users ON users_movie.id_user = users.id_user 
WHERE users.id_user = ?;";

//get user's hashed password
$get_user_hash_password = "SELECT password FROM users WHERE users.username = ?";

//get user's credentials
$get_user_credentials = "SELECT username, gmail, password FROM users WHERE username = ? AND gmail = ?;";

//Insert user into the DB
$insert_user = "INSERT INTO users (username, gmail, password) VALUES (?, ?, ?);";

//Get user id by username and password
$get_id_user = "SELECT id_user FROM users WHERE users.username = ? AND users.password = ?";

//Insert user's favorite movie
$insert_user_fav_movie = "INSERT INTO users_movie (id_user, id_movie) VALUES (?, ?);";

$delete_user_fav_movie = "DELETE FROM users_movie WHERE users_movie.id_user = ? AND users_movie.id_movie = ?;";


//------------ FUCNTIONS ------------

//Get all movies
function get_movie_data(){
    global $conn, $sql;
    $result = $conn->query($sql);
    return $result;
}

//Get main cast by movie id
function get_main_cast_by_id($id_movie){
    
    global $conn, $get_main_cast_by_id_movie;
    //$result = $conn->query($get_main_cast_by_id_movie);
    $custom_query = $conn -> prepare($get_main_cast_by_id_movie); 
    $custom_query-> bind_param("i", $id_movie);
    $custom_query-> execute();
    $result = $custom_query->get_result();
    
    return $result;
}

//Get movie genre by movie id
function get_movie_genre($id_movie){
   
    global $conn, $get_movie_genre_by_movie_id;
    $custom_query = $conn -> prepare($get_movie_genre_by_movie_id); 
    $custom_query-> bind_param("i", $id_movie);
    $custom_query-> execute();
    $result = $custom_query->get_result();

    return $result;
}

//Get movie details by movie id
function get_movie_details_by_id($id_movie){
    
    global $conn, $get_movie_details;
    
    $custom_query = $conn->prepare($get_movie_details);
    $custom_query->bind_param("i", $id_movie);
    $custom_query->execute();
    $result = $custom_query->get_result();

    return $result;
}

//Get movie by year
function get_movie_by_year($year){
    
    global $conn, $get_movie_by_year;
    
    $custom_query = $conn->prepare($get_movie_by_year);
    $custom_query->bind_param("i", $year);
    $custom_query->execute();
    $result = $custom_query->get_result();

    return $result;
}

//Get movie by NAME
function get_movie_by_name($movie_name){
    
    global $conn, $get_movie_by_name_from_BD;
    
    $custom_query = $conn->prepare($get_movie_by_name_from_BD);
    $custom_query->bind_param("s", $movie_name);
    $custom_query->execute();
    $result = $custom_query->get_result();

    return $result;
}


/*Get movie by year OR by genre OR by country*/
function get_movie_by_year_or_genre_or_country($year, $genre, $country) {
 
    if ($year) {
        global $conn, $get_movie_by_year;
        $custom_query = $conn->prepare($get_movie_by_year);
        $custom_query->bind_param("i", $year);
        $custom_query->execute();
        $result = $custom_query->get_result();
    }
    if ($genre) {
        global $conn, $get_movie_by_genre;
        $custom_query = $conn->prepare($get_movie_by_genre);
        $custom_query->bind_param("s", $genre);
        $custom_query->execute();
        $result = $custom_query->get_result();
    }
    if ($country) {
        global $conn, $get_movie_by_country;
        $custom_query = $conn->prepare($get_movie_by_country);
        $custom_query->bind_param("s", $country);
        $custom_query->execute();
        $result = $custom_query->get_result();
    }

    return $result;
}

/*Get movie by year OR by genre OR by country (THIS INE ALSO WOKRS)*/
function get_movie_by_year_or_genre_or_country_1($year, $genre, $country) {
    global $conn;

    $query = "SELECT movie.id_movie, movie.name, movie.year_of_release, movie.director, movie.country, movie.description, 
    movie.movie_link, ratings.rating_score, trailer.image, trailer.video, genre.name_genre
    FROM movie
    INNER JOIN ratings ON movie.id_movie = ratings.id_movie
    INNER JOIN trailer ON movie.id_movie = trailer.id_movie 
    INNER JOIN movie_genre ON movie.id_movie = movie_genre.id_movie
    INNER JOIN genre ON movie_genre.id_genre = genre.id_genre
    WHERE 1=1";
    
    $params = [];
    $types = "";

    if ($year) {
        $query .= " AND movie.year_of_release = ?";
        $params[] = $year;
        $types .= "i";
    }
    if ($genre) {
        $query .= " AND genre.name_genre = ?";
        $params[] = $genre;
        $types .= "s";
    }
    if ($country) {
        $query .= " AND movie.country = ?";
        $params[] = $country;
        $types .= "s";
    }

    $stmt = $conn->prepare($query);
    if ($params) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();

    return $result;
}

//---------------User Register--------------
function register_user($username, $gmail, $password){
    global $conn, $insert_user;
    $custom_query = $conn->prepare($insert_user);
    $custom_query->bind_param("sss", $username, $gmail, $password);
    $result = $custom_query->execute();
    return $result;
}

//Get the user id by username and gmail
function get_id_user_by_name_and_password($userName_coming, $user_hashed_pass_coming){
    global $conn, $get_id_user;    
    $custom_query = $conn->prepare($get_id_user);
    $custom_query->bind_param("ss", $userName_coming, $user_hashed_pass_coming);
    $custom_query->execute();
    $result = $custom_query->get_result();
    $row = $result->fetch_assoc();
    return $row['id_user'];
}

//Insert user's favorite movie
function insert_users_fav_movie($id_user, $id_movie){
    global $conn, $insert_user_fav_movie;
    $custom_query = $conn->prepare($insert_user_fav_movie);
    $custom_query->bind_param("ii", $id_user, $id_movie);
    $custom_query->execute(); // execute the query return true or false
    return $custom_query->affected_rows > 0;
    //return $result;
}

//Get all favorite movies by user id
function get_all_favorite_movies_by_id_user($id_user){
    global $conn, $get_all_users_fav_movies;
    $custom_query = $conn->prepare($get_all_users_fav_movies);
    $custom_query->bind_param("i", $id_user);
    $custom_query->execute();
    $result = $custom_query->get_result();
    return $result;
}

//---------------User--------------

//Get user's hashed password
function getStoredHashedPassword($username){
    global $conn, $get_user_hash_password;
    $custom_query = $conn->prepare($get_user_hash_password);
    $custom_query->bind_param("s", $username);
    $custom_query->execute();
    $result = $custom_query->get_result();
    $row = $result->fetch_assoc();
    return $row['password'] ?? null;
}

//Authenticate user
function deleteUsersFavMovie($id_user, $id_movie){
    global $conn, $delete_user_fav_movie;
    $custom_query = $conn->prepare($delete_user_fav_movie);
    $custom_query-> bind_param("ii", $id_user, $id_movie);
    $custom_query-> execute();
    return $custom_query->affected_rows > 0;
    //$result = $custom_query->get_result();    
    //return $result;
}

//Close connection
function close_connection(){
    global $conn;
    $conn->close();
}
?>