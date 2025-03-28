<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instagram Scraper</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.3/dist/tailwind.min.css" rel="stylesheet">
    <script>
        function validateForm() {
            const username = document.getElementById("username").value.trim();
            if (username === "") {
                alert("Le nom du compte Instagram ne peut pas être vide !");
                return false;
            }
            return true;
        }
    </script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-lg">
        <h1 class="text-2xl font-semibold text-center mb-6">Recherche de posts Instagram</h1>
        <form action="index.php" method="POST" onsubmit="return validateForm();">
            <label for="username" class="block text-lg font-medium mb-2">Nom du compte Instagram :</label>
            <input type="text" id="username" name="username" class="w-full p-3 border border-gray-300 rounded mb-4" required>
            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded">Rechercher</button>
        </form>
    </div>
</body>
</html>

<?php
// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer le nom du compte depuis le formulaire
    $username = $_POST['username'];

    // L'URL de l'API avec le nom du compte
    $url = "https://instagram-scraper-api2.p.rapidapi.com/v1/posts?username_or_id_or_url=" . $username;

    // Initialiser une session cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'x-rapidapi-host: instagram-scraper-api2.p.rapidapi.com',
        'x-rapidapi-key: c26ea3dfc6msh8aee293701fdd19p1b7248jsnce74b46ebb52'
    ]);

    // Exécuter l'appel API et récupérer la réponse
    $response = curl_exec($ch);
    curl_close($ch);

    // Décoder la réponse JSON
    $data = json_decode($response, true);

    // Vérifier si des posts sont disponibles
    if (isset($data['data']['items']) && count($data['data']['items']) > 0) {
        echo "<h2>Posts de @$username</h2>";
        echo "<ul>";

        // Parcourir les posts et les afficher
        foreach ($data['data']['items'] as $post) {
            $caption_text = isset($post['caption']['text']) ? $post['caption']['text'] : 'Texte non disponible';
            $post_date = date('Y-m-d', $post['caption']['created_at']);
            $likes_count = isset($post['like_count']) ? $post['like_count'] : 0;
            $comments_count = isset($post['comment_count']) ? $post['comment_count'] : 0;
            $media_url = isset($post['carousel_media'][0]['image_versions'][0]['url']) ? $post['carousel_media'][0]['image_versions'][0]['url'] : '';
            $media_type = isset($post['media_type']) ? $post['media_type'] : 'photo';
            $view_count = isset($post['view_count']) ? $post['view_count'] : 0;

            echo "<li>";
            echo "<strong>Publié le : </strong>" . $post_date . "<br>";
            echo "<strong>Texte : </strong>" . $caption_text . "<br>";
            echo "<strong>Likes : </strong>" . $likes_count . "<br>";
            echo "<strong>Commentaires : </strong>" . $comments_count . "<br>";
            echo "<strong>Vues : </strong>" . $view_count . "<br>";
            echo "<strong>Type de média : </strong>" . $media_type . "<br>";
            echo "<img src='" . $media_url . "' alt='Image du post' style='width: 300px;'><br>";
            echo "</li><br>";
        }
        echo "</ul>";
    } else {
        echo "Aucun post trouvé pour ce compte.";
    }
}
?>
