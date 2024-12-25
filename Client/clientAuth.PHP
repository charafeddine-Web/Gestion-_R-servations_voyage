<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>VoyagePro - Popup Login/Register</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
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
      <li><a href="#about" class="hover:text-blue-500">À propos</a></li>
      <li><a href="#notre-public-cible" class="hover:text-blue-500">Notre Public</a></li>
      <li><a href="#mes-reservations" class="hover:text-blue-500">Mes Réservations</a></li>
    </ul>
    <!-- Action Buttons for Authenticated User -->
    <div class="hidden md:flex space-x-4">
      <button id="profileButton" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
        Mon Profil
      </button>
      <button id="logoutButton" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
        Déconnexion
      </button>
    </div>
  </nav>
  <!-- Dropdown Menu (Mobile) -->
  <div id="mobileMenu" class="hidden bg-white shadow-md">
    <ul class="flex flex-col space-y-2 py-4 px-6 text-gray-700">
      <li><a href="#home" class="hover:text-blue-500">Accueil</a></li>
      <li><a href="#offers" class="hover:text-blue-500">Offres</a></li>
      <li><a href="#about" class="hover:text-blue-500">À propos</a></li>
      <li><a href="#notre-public-cible" class="hover:text-blue-500">Notre Public</a></li>
      <li><a href="#mes-reservations" class="hover:text-blue-500">Mes Réservations</a></li>
    </ul>
    <div class="space-y-2 px-6">
      <button id="profileButtonMobile" class="w-full px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
        Mon Profil
      </button>
      <button id="logoutButtonMobile" class="w-full px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
        Déconnexion
      </button>
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
        <input type="email" id="email" name="email" class="w-full px-4 py-2 border rounded-lg" placeholder="Votre email">
      </div>
      <div class="mb-4">
        <label for="phone" class="block text-sm font-semibold text-gray-700">Téléphone</label>
        <input type="text" id="phone" name="phone" class="w-full px-4 py-2 border rounded-lg" placeholder="Votre téléphone">
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


  <!-- Mes Réservations Section -->
  <section id="mes-reservations" class="py-16 bg-gray-50">
    <div class="container mx-auto px-6 lg:px-16 text-center">
      <h2 class="text-3xl font-bold text-blue-600 mb-6">Mes Réservations</h2>
      <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-xl font-semibold text-gray-800 mb-2">Vol Paris - Tokyo</h3>
        <p class="text-gray-600">Réservé pour le 10 Janvier 2024</p>
        <p class="text-gray-600">Statut: Confirmé</p>
        <button class="mt-4 px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
          Annuler Réservation
        </button>
      </div>
    </div>
  </section>

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
    // Script for handling the modals and navigation
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
  
  // Open the modal when the "Mon Profil" button is clicked
  profileButton.addEventListener('click', () => {
    profileModal.classList.remove('hidden');
  });
  
  // Open the modal for mobile
  profileButtonMobile.addEventListener('click', () => {
    profileModal.classList.remove('hidden');
  });

  // Close the modal when the "Annuler" button is clicked
  closeModalButton.addEventListener('click', () => {
    profileModal.classList.add('hidden');
  });

  // Optionally, handle form submission to update the profile
  document.getElementById('profileForm').addEventListener('submit', (e) => {
    e.preventDefault();
    console.log('Profile updated');
    profileModal.classList.add('hidden');
  });
  </script>
</body>

</html>
