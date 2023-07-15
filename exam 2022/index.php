<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            background: linear-gradient(135deg, #FF9A44, #A86537) no-repeat center center fixed;
            background-size: cover;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
            /* Prevent scrollbars due to blur */
        }

        .form-container {
            max-width: 400px;
            padding: 20px;
            background: #FFFFFF;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease-in-out;
        }

        .form-container:hover {
            transform: translateY(-5px);
        }

        .form-container input[type="text"],
        .form-container input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: none;
            border-radius: 4px;
            box-sizing: border-box;
            transition: background-color 0.3s ease-in-out;
        }

        .form-container input[type="text"]:hover,
        .form-container input[type="email"]:hover {
            background-color: #F6F6F6;
        }

        .form-container input[type="submit"] {
            background-color: #FF7F50;
            color: #FFFFFF;
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        .form-container input[type="submit"]:hover {
            background-color: #A86537;
        }

        /* Styling for the pop-up window */
        .popup-container {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease-in-out;
        }

        .popup-container.active {
            opacity: 1;
            pointer-events: auto;
        }

        .popup-content {
            width: 300px;
            padding: 20px;
            background: #FFFFFF;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            animation: popup-anim 0.3s ease-in-out;
        }

        .popup-close {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 18px;
            color: #333333;
            cursor: pointer;
        }

        /* Animation keyframes for the pop-up window */
        @keyframes popup-anim {
            0% {
                transform: translate(-50%, -50%) scale(0.5);
            }

            100% {
                transform: translate(-50%, -50%) scale(1);
            }
        }
    </style>
</head>

<body>
    <div class="form-container">
        <form method="post">
            <input type="text" name="RefProduit" placeholder="Réference de Produit">
            <input type="text" name="quantite_demander" placeholder="Quantite Demmandée">
            <input type="submit" name="chercher" value="Submit">
        </form>
    </div>

    <?php
    if (isset($_POST['chercher'])) {
        //recuperation des donnee d´entrée 
        $RefProduit = $_POST['RefProduit'];
        $quantite_demander = $_POST['quantite_demander'];
        //connecter a la base de donnée
        $pdo = new PDO("mysql:host=localhost;dbname=exam 2022", "root", "");
        //prepartion et execution 
        $requete = $pdo->prepare("SELECT Quatstock from produit where produit.Refproduit = ? ");
        $requete->execute([$RefProduit]);
        $requete->setFetchMode(PDO::FETCH_ASSOC);
        $Quantite_en_stock = $requete->fetchAll();
        //affichage de resultas
        echo '<div id="popup-container" class="popup-container">
                <div class="popup-content">
                    <span class="popup-close">&times;</span>
                    <p>La quantité commandée est : ' . $quantite_demander . '</p>
                    <p>La quantité en stock est: ' . $Quantite_en_stock[0]['Quatstock'] . '</p>';

        if ($Quantite_en_stock[0]['Quatstock'] > $quantite_demander) {
            echo "<p>Le produit " . $RefProduit . " est disponible</p>";
        } else {
            echo "<p>Le produit " . $RefProduit . " n'est pas disponible</p>";
        }

        echo '</div>
            </div>';
    }
    ?>

    <script>
        // JavaScript code to handle pop-up window
        const popupContainer = document.getElementById('popup-container');
        const popupClose = document.querySelector('.popup-close');
        const body = document.querySelector('body');


        // Show the pop-up window
        function showPopup() {
            popupContainer.classList.add('active');
            body.style.overflow = 'hidden';
            body.style.filter = 'blur(10px)';
            popupContainer.style.filter = 'none';
        }

        // Hide the pop-up window
        function hidePopup() {
            popupContainer.classList.remove('active');
            body.style.overflow = 'auto';
        }

        // Close the pop-up window when the close button is clicked
        popupClose.addEventListener('click', hidePopup);
        window.addEventListener('load', showPopup);
    </script>
</body>

</html>