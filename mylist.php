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
?>

<?php include('includes/header.php'); ?>
<div class="search-results-container">
    <h2>My List</h2>
    <?php
    if (!empty($_SESSION['my_list'])) {
        foreach ($_SESSION['my_list'] as $movie) {
            echo '<div class="movie">';
            echo '<h3>' . htmlspecialchars($movie['title']) . '</h3>';
            echo '<p>Year: ' . htmlspecialchars($movie['year']) . '</p>';
            echo '<p>Actors: ' . htmlspecialchars($movie['actors']) . '</p>';
            echo '<p>Plot: ' . htmlspecialchars($movie['plot']) . '</p>';
            echo '<img src="' . htmlspecialchars($movie['poster']) . '" alt="Poster">';
            echo '<form method="post">';
            echo '<input type="hidden" name="movie_id" value="' . htmlspecialchars($movie['id']) . '">';
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
