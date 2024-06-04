<?php
require_once 'config.php';

session_start();

$query = isset($_GET['query']) ? $_GET['query'] : '';

if (!empty($query)) {
    $url = "http://www.omdbapi.com/?apikey=618ee09c&s=" . urlencode($query);
    $response = file_get_contents($url);
    $movies = json_decode($response, true)['Search'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_list'])) {
    $movieID = $_POST['movie_id'];
    $movieTitle = $_POST['movie_title'];
    $movieYear = $_POST['movie_year'];
    $movieActors = $_POST['movie_actors'];
    $moviePlot = $_POST['movie_plot'];
    $moviePoster = $_POST['movie_poster'];

    $movie = [
        'id' => $movieID,
        'title' => $movieTitle,
        'year' => $movieYear,
        'actors' => $movieActors,
        'plot' => $moviePlot,
        'poster' => $moviePoster
    ];

    if (!isset($_SESSION['my_list'])) {
        $_SESSION['my_list'] = [];
    }

    $_SESSION['my_list'][$movieID] = $movie;
}
?>

<?php include('includes/header.php'); ?>
<div class="search-results-container">
    <h2>Search Results for "<?php echo htmlspecialchars($query); ?>"</h2>
    <?php
    if (!empty($movies)) {
        foreach ($movies as $movie) {
            $detailsUrl = "http://www.omdbapi.com/?apikey=618ee09c&i=" . urlencode($movie['imdbID']);
            $detailsResponse = file_get_contents($detailsUrl);
            $details = json_decode($detailsResponse, true);

            echo '<div class="movie">';
            echo '<h3>' . htmlspecialchars($details['Title']) . '</h3>';
            echo '<p>Year: ' . htmlspecialchars($details['Year']) . '</p>';
            echo '<p>Actors: ' . htmlspecialchars($details['Actors']) . '</p>';
            echo '<p>Plot: ' . htmlspecialchars($details['Plot']) . '</p>';
            echo '<img src="' . htmlspecialchars($details['Poster']) . '" alt="Poster">';
            echo '<form method="post">';
            echo '<input type="hidden" name="movie_id" value="' . htmlspecialchars($details['imdbID']) . '">';
            echo '<input type="hidden" name="movie_title" value="' . htmlspecialchars($details['Title']) . '">';
            echo '<input type="hidden" name="movie_year" value="' . htmlspecialchars($details['Year']) . '">';
            echo '<input type="hidden" name="movie_actors" value="' . htmlspecialchars($details['Actors']) . '">';
            echo '<input type="hidden" name="movie_plot" value="' . htmlspecialchars($details['Plot']) . '">';
            echo '<input type="hidden" name="movie_poster" value="' . htmlspecialchars($details['Poster']) . '">';
            echo '<input type="submit" name="add_to_list" value="Add to List">';
            echo '</form>';
            echo '</div>';
        }
    } else {
        echo '<p>No results found.</p>';
    }
    ?>
</div>
<?php include('includes/footer.php'); ?>
