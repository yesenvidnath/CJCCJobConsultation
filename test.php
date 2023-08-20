<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Multiple Popups</title>
  <!-- Include Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Style the popup container */
    .popup-container {
      position: absolute;
      bottom: 100%; /* Adjust this value as needed */
      left: 50%;
      transform: translateX(-50%);
      background-color: white;
      border: 1px solid #ccc;
      padding: 20px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
      z-index: 1000;
    }

    /* Add more styling as needed */

    /* Dim the background when a popup is open */
    .overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: 999;
      display: none;
    }
  </style>
</head>
<body>
  <div class="container mt-5">
    <button class="btn btn-primary" data-popup-target="popup1">Open Popup 1</button>
    <button class="btn btn-primary" data-popup-target="popup2">Open Popup 2</button>
    <button class="btn btn-primary" data-popup-target="popup3">Open Popup 3</button>

    <div class="overlay" id="overlay"></div>

    <div id="popup1" class="popup-container d-none">
                                                    <?php 
                                                        include('admin/Users.php')
                                                    ?>
    </div>

    <div id="popup2" class="popup-container d-none">
      <!-- Popup 2 content -->
    </div>

    <div id="popup3" class="popup-container d-none">
    <?php 
                                                        include('admin/Users.php')
                                                    ?>
    </div>
  </div>

  <!-- Include Bootstrap JS and your custom script -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Open popup when a button is clicked
    const openPopupButtons = document.querySelectorAll('[data-popup-target]');
    const overlay = document.getElementById('overlay');

    openPopupButtons.forEach(button => {
      button.addEventListener('click', () => {
        const popupId = button.getAttribute('data-popup-target');
        const popupContainer = document.getElementById(popupId);
        popupContainer.classList.remove('d-none');
        overlay.style.display = 'block';
        document.cookie = `${popupId}=true; expires=Fri, 31 Dec 9999 23:59:59 GMT`;
      });
    });

    // Prevent closing when clicking inside the popup
    const popupContainers = document.querySelectorAll('.popup-container');
    popupContainers.forEach(popup => {
      popup.addEventListener('click', event => {
        event.stopPropagation();
      });
    });

    // Close popup when overlay is clicked
    overlay.addEventListener('click', () => {
      popupContainers.forEach(popup => {
        popup.classList.add('d-none');
      });
      overlay.style.display = 'none';
      const cookies = document.cookie.split('; ');
      for (const cookie of cookies) {
        const [name, value] = cookie.split('=');
        const popup = document.getElementById(name);
        if (popup && value === 'true') {
          popup.classList.remove('d-none');
          break;
        }
      }
    });
  </script>
</body>
</html>
