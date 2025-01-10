<?php


require_once '../classes/Client.php';
session_start();

if (!isset($_SESSION['user_id']) || (isset($_SESSION['role_id']) && $_SESSION['role_id'] !== 3)) {
  header("Location: ../index.php");
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_reservation'])) {
    if (isset($_POST['id_activite'], $_POST['nbr_places'], $_POST['date_reservation']) && is_numeric($_POST['id_activite']) && is_numeric($_POST['nbr_places'])) {
        $id_activite = $_POST['id_activite'];
        $nbr_places = $_POST['nbr_places'];
        $date_reservation = $_POST['date_reservation'];  
        $status = 'En_attente';  

        $client = new Client($_SESSION['user_id'], null, null,null);
        if ($client->addReservation($id_activite, $date_reservation, $status, $nbr_places)) {
            header("Location: ./clientAuth.php?success=1");
            exit();
        } else {
            header("Location: ./clientAuth.php?error=1");
            exit();
        }
    } else {
        header("Location: ./clientAuth.php?warning=1");
        exit();
    }
}

// Fetch offers
$client = new Client("", "", "","");
$offers = $client->viewOffers();
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>VoyagePro - Popup Login/Register</title>
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fff;
            margin: 15% auto;
            padding: 20px;
            border-radius: 8px;
            width: 50%;
            text-align: center;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover {
            color: red;
        }
    
    ::-webkit-scrollbar {
      width: 8px;
    }

    ::-webkit-scrollbar-thumb {
      background: #3b82f6;
      border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
      background: #2563eb;
    }
  </style>
</head>

<body class="bg-gradient-to-b from-blue-50 via-white to-gray-100 font-sans">
  <header class="bg-white shadow-md sticky top-0 z-50">
    <nav class="container mx-auto flex justify-between items-center py-4 px-6">
      <div class="text-2xl font-extrabold text-blue-600">🌍 VoyagePro</div>
      <button id="menuToggle" class="md:hidden text-gray-700 focus:outline-none">
        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
        </svg>
      </button>
      <ul id="navLinks" class="hidden md:flex space-x-6 text-gray-700">
        <li><a href="#home" class="hover:text-blue-500">Accueil</a></li>
        <li><a href="#offers" class="hover:text-blue-500">Offres</a></li>
        <li><a href="#mes-reservations" class="hover:text-blue-500">Mes Réservations</a></li>
      </ul>
      <div class="hidden md:flex space-x-4">
        <button id="profileButton" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
          Mon Profil
        </button>
        <form action="../logout.php" method="POST">
          <button id="logoutButtonMobile" type="submit" name="submit"
            class="w-full px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
            Déconnexion
          </button>
        </form>
      </div>
    </nav>
    <div id="mobileMenu" class="hidden bg-white shadow-md">
      <ul class="flex flex-col space-y-2 py-4 px-6 text-gray-700">
        <li><a href="#home" class="hover:text-blue-500">Accueil</a></li>
        <li><a href="#offers" class="hover:text-blue-500">Offres</a></li>
        <li><a href="#mes-reservations" class="hover:text-blue-500">Mes Réservations</a></li>
      </ul>
      <div class="space-y-2 px-6">
        <button id="profileButtonMobile" class="w-full px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
          Mon Profil
        </button>
        <form action="../logout.php" method="POST">
          <button id="logoutButtonMobile" type="submit" name="submit"
            class="w-full px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
            Déconnexion
          </button>
        </form>
      </div>
    </div>
  </header>

  <div id="profileModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center hidden">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
      <h2 class="text-xl font-bold mb-4">Modifier Mon Profil</h2>
      <form id="profileForm">
        <div class="mb-4">
          <label for="name" class="block text-sm font-semibold text-gray-700">Nom</label>
          <input type="text" id="name" name="name" class="w-full px-4 py-2 border rounded-lg" placeholder="Votre nom">
        </div>
        <div class="mb-4">
          <label for="email" class="block text-sm font-semibold text-gray-700">Email</label>
          <input type="email" id="email" name="email" class="w-full px-4 py-2 border rounded-lg"
            placeholder="Votre email">
        </div>

        <div class="flex justify-end space-x-4">
          <button type="button" id="closeModal" class="px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500">
            Annuler
          </button>
          <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
            Sauvegarder
          </button>
        </div>
      </form>
    </div>
  </div>


  <section id="mes-reservations" class="py-16 bg-gray-50">
    <div class="container mx-auto px-6 lg:px-16 text-center">
      <h2 class="text-3xl font-bold text-blue-600 mb-6">Mes Réservations</h2>
      <div class="flex gap-2 flex-wrap justify-center"><?php
      require_once '../classes/reservation.php';
      $client = new Reservation("", "", "", "");
      $offersreservé = $client->showRes_client($_SESSION['user_id']);
      if (!empty($offersreservé)) {
        foreach ($offersreservé as $offer) {
          echo '
                    <div class="bg-gray-50 rounded-lg shadow-lg hover:shadow-xl transition duration-300 overflow-hidden">
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">' . htmlspecialchars($offer['name_activite']) . '</h3>
                            <p class="text-gray-600"> <span class="text-yellow-500 font-bold">' . htmlspecialchars($offer['name_client']) . '</span></p>
                            <p class="text-gray-600"> <span class="text-yellow-500 font-extrabold">' . htmlspecialchars($offer['date_reservation']) . '</span></p>
                            <p class="text-gray-600"> <span class="text-yellow-500 font-extrabold">' . htmlspecialchars($offer['nbr_places']) . '</span></p>
                            <p class="text-gray-600"> <span class="text-black font-bold">' . htmlspecialchars($offer['status']) . '</span></p>
                            <form action="canceledRes.php" method="POST">
                                <input type="hidden" name="id_res" value="' . htmlspecialchars($offer['id_reservation']) . '">
                                <button type="submit" name="cancel_reservation" class="mt-4 px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                                    Annuler Réservation
                                </button>
                            </form>

                        </div>
                    </div>
                    ';
        }
      } else {
        echo '<p class="text-center text-gray-600">Aucune offre disponible pour le moment.</p>';
      }
      ?>

      </div>
    </div>
  </section>

  <section id="offers" class="bg-white py-16">
    <div class="container mx-auto px-6 lg:px-16">
      <h2 class="text-3xl font-bold text-center text-blue-600 mb-8">Nos top Offres Populaires</h2>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php
        require_once '../classes/Client.php';
        $client = new Client("", "", "","");
        $offers = $client->viewOffers();
        if (!empty($offers)) {
          foreach ($offers as $offer) {
            echo '
                    <div class="bg-gray-50 rounded-lg shadow-lg hover:shadow-xl transition duration-300 overflow-hidden">
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-blue-600">' . htmlspecialchars($offer['name']) . '</h3>
                            <p class="text-gray-600 mb-4"> <span class="text-yellow-500 font-bold">' . htmlspecialchars($offer['description']) . '</span></p>
                             <p class="text-gray-600 mb-4"> <span class="text-yellow-500 font-extrabold">' . htmlspecialchars($offer['destination']) . '</span></p>
                            <p class="text-gray-600 mb-4">À partir de <span class="text-yellow-500 font-bold">' . htmlspecialchars($offer['price']) . '€</span></p>
                          <button type="button" onclick="openModal(' . htmlspecialchars($offer['id_activite']) . ')" class="mt-4 px-4 py-2 bg-indigo-500 text-white rounded-lg hover:bg-indigo-600">
                                Réservez Maintenant ->
                            </button>
                        </div>
                    </div>
                    ';
          }
        } else {
          echo '<p class="text-center text-gray-600">Aucune offre disponible pour le moment.</p>';
        }
        ?>
      </div>
    </div>
  </section>

  <div id="reservationModal" class="modal  px-4 py-2">
        <div class="modal-content " >
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Réserver une activité</h2>
            <form id="reservationForm"  action="Add_res.php" method="POST">
                <input type="hidden" name="id_activite" id="modal_id_activite">
                <label for="nbr_places">Nombre de places:</label>
                <input type="number" name="nbr_places" id="nbr_places" class="border-2 bg-gray-200 rounded" required> 
                <label for="date_reservation">Date de réservation:</label>
                <input type="date" name="date_reservation" id="date_reservation" class="border-2 bg-gray-200 rounded" required>
                <button type="submit" name="add_reservation" class="mt-4 px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">
                    Confirmer
                </button>
            </form>
        </div>
    </div>

    
  <footer class="bg-gray-800 text-gray-300 py-10">
    <div class="container mx-auto px-6 lg:px-16">
      <div class="flex flex-col md:flex-row justify-between items-center">
        <div class="mb-6 md:mb-0">
          <div class="text-2xl font-extrabold text-white">🌍 VoyagePro</div>
          <p class="mt-2 text-gray-400">Votre compagnon pour des voyages inoubliables.</p>
        </div>
        <ul class="flex space-x-4">
          <li><a href="#" class="text-gray-400 hover:text-white">Mentions Légales</a></li>
          <li><a href="#" class="text-gray-400 hover:text-white">Politique de Confidentialité</a></li>
          <li><a href="#" class="text-gray-400 hover:text-white">Nous Contacter</a></li>
        </ul>
      </div>
      <div class="text-center mt-8 text-gray-500">© 2024 VoyagePro. Tous droits réservés.</div>
    </div>
  </footer>

  <script>
    const menuToggle = document.getElementById('menuToggle');
    const mobileMenu = document.getElementById('mobileMenu');
    const navLinks = document.getElementById('navLinks');
    menuToggle.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
    });


    const profileButton = document.getElementById('profileButton');
    const closeModalButton = document.getElementById('closeModal');
    const profileModal = document.getElementById('profileModal');
    const profileButtonMobile = document.getElementById('profileButtonMobile');

    profileButton.addEventListener('click', () => {
      profileModal.classList.remove('hidden');
    });

    profileButtonMobile.addEventListener('click', () => {
      profileModal.classList.remove('hidden');
    });

    closeModalButton.addEventListener('click', () => {
      profileModal.classList.add('hidden');
    });

    document.getElementById('profileForm').addEventListener('submit', (e) => {
      e.preventDefault();
      console.log('Profile updated');
      profileModal.classList.add('hidden');
    });
    
  //model pour add reservation 
    const modal = document.getElementById('reservationModal');
        const modalInput = document.getElementById('modal_id_activite');

        function openModal(id) {
            modal.style.display = 'block';
            modalInput.value = id;
        }

        function closeModal() {
            modal.style.display = 'none';
        }

        window.onclick = function(event) {
            if (event.target === modal) {
                closeModal();
            }
        };
</script>

</body>

</html>