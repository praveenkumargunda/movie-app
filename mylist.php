<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['remove_from_list'])) {
    $movieID = $_POST['movie_id'];
    if (isset($_SESSION['my_list'][$movieID])) {
        unset($_SESSION['my_list'][$movieID]);
    }
}

include('includes/header.php'); 
?>
<div class="search-results-container">
    <h2>My List</h2>
    <form action="welcome.php" class="back-button">
        <input type="submit" value="Back">
    </form>
    <?php
    if (!empty($_SESSION['my_list'])) {
        foreach ($_SESSION['my_list'] as $movieID => $movie) {
            // Fetch detailed information about the movie
            $detailsUrl = "http://www.omdbapi.com/?apikey=618ee09c&i=" . urlencode($movieID);
            $detailsResponse = file_get_contents($detailsUrl);
            $details = json_decode($detailsResponse, true);

            echo '<div class="movie">';
            echo '<h3>' . htmlspecialchars($details['Title']) . '</h3>';
            echo '<p>Year: ' . htmlspecialchars($details['Year']) . '</p>';
            echo '<p>Genre: ' . htmlspecialchars($details['Genre']) . '</p>';
            echo '<p>Director: ' . htmlspecialchars($details['Director']) . '</p>';
            echo '<p>Actors: ' . htmlspecialchars($details['Actors']) . '</p>';
            echo '<p>Plot: ' . htmlspecialchars($details['Plot']) . '</p>';
            echo '<p>IMDb Rating: ' . htmlspecialchars($details['imdbRating']) . '</p>';
            echo '<img src="' . htmlspecialchars($details['Poster']) . '" alt="Poster">';
            echo '<form method="post">';
            echo '<input type="hidden" name="movie_id" value="' . htmlspecialchars($details['imdbID']) . '">';
            echo '<input type="submit" name="remove_from_list" value="Remove">';
            echo '</form>';
            echo '</div>';
        }
    } else {
        echo '<p>No movies in your list.</p>';
    }
    ?>
</div>
<?php include('includes/footer.php'); ?>
