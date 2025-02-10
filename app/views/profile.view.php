<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>MagicDB - Trade your cards</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <style>
        .profile-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            /* Centers vertically */
            text-align: center;
        }

        .profile-img {
            width: 150px;
            /* Adjust image size */
            height: 150px;
            border-radius: 50%;
            /* Makes the image circular */
            object-fit: cover;
            margin-top: 10px;
            border: 3px solid #333;
            /* Optional border */
        }

        .profile-container p {
            font-size: 1.2rem;
            color: #333;
        }
    </style>


</head>

<body>


    <div class="profile-container">
        <h2>Perfil de Usuario</h2>
        <p><strong>Nombre de Usuario:</strong> <?= htmlspecialchars($username); ?></p>
        <?php if (!empty($imagen) || $imagen === null): ?>
            <img src="/public/img/img_perfil/<?= htmlspecialchars($imagen); ?>" alt="Imagen de perfil" class="profile-img">
        <?php else: ?>
            <p>No hay imagen de perfil disponible.</p>
        <?php endif; ?>
        <a href="profile/edit-picture">
            <button>Cambiar imagen de perfil</button>
        </a>
        <a href="profile/edit-username">
            <button>Cambiar nombre de perfil</button>
        </a>
    </div>



    <script src="../js/main.js"></script>
</body>

</html>