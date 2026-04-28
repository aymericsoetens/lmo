<?php
// auth.php - Gère l'authentification OAuth GitHub

$client_id = 'Ov23liKHQiCVUr3wDmNl';
$client_secret = 'VOTRE_NOUVEAU_SECRET_ICI';
$redirect_uri = 'https://lamainocculte.fr/auth.php';

// Étape 1 : Redirection vers GitHub
if (!isset($_GET['code'])) {
    $url = 'https://github.com/login/oauth/authorize?' . http_build_query([
        'client_id' => $client_id,
        'redirect_uri' => $redirect_uri,
        'scope' => 'repo,user'
    ]);
    header('Location: ' . $url);
    exit;
}

// Étape 2 : Échange du code contre un token
if (isset($_GET['code'])) {
    $ch = curl_init('https://github.com/login/oauth/access_token');
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query([
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'code' => $_GET['code'],
            'redirect_uri' => $redirect_uri
        ]),
        CURLOPT_HTTPHEADER => ['Accept: application/json']
    ]);
    
    $response = curl_exec($ch);
    $data = json_decode($response, true);
    curl_close($ch);
    
    if (isset($data['access_token'])) {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Authentification réussie</title>
            <style>
                body {
                    background: #0a0a0f;
                    color: white;
                    font-family: 'Georgia', serif;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    height: 100vh;
                    flex-direction: column;
                }
                .success { 
                    color: #4CAF50;
                    font-size: 4rem;
                    animation: pulse 1s infinite;
                }
                @keyframes pulse {
                    0%, 100% { transform: scale(1); }
                    50% { transform: scale(1.1); }
                }
                p { 
                    color: #c49a6c;
                    font-size: 1.2rem;
                    margin-top: 1rem;
                }
            </style>
        </head>
        <body>
            <div class="success">✓</div>
            <p>Authentification réussie !</p>
            <p style="color:#888;font-size:0.9rem;">Redirection vers l'administration...</p>
            <script>
                const token = '<?php echo $data['access_token']; ?>';
                window.opener.postMessage({
                    token: token,
                    provider: "github"
                }, "https://lamainocculte.fr");
                setTimeout(() => window.close(), 1500);
            </script>
        </body>
        </html>
        <?php
        exit;
    }
}

// En cas d'erreur
header('HTTP/1.1 401 Unauthorized');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Erreur d'authentification</title>
    <style>
        body {
            background: #0a0a0f;
            color: white;
            font-family: 'Georgia', serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            flex-direction: column;
        }
        .error { color: #f44336; font-size: 4rem; }
        p { color: #c49a6c; font-size: 1.2rem; margin-top: 1rem; }
        a { color: #6b2d9c; margin-top: 1rem; }
    </style>
</head>
<body>
    <div class="error">✗</div>
    <p>Erreur d'authentification</p>
    <a href="/admin/">Retour à l'administration</a>
</body>
</html>