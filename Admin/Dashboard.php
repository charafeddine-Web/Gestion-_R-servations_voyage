<?php 
session_start();
if(!isset($_SESSION['user_id']) || (isset($_SESSION['role_id']) && $_SESSION['role_id'] == 3) ){
    header("Location: login.php");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
    .custom-btn {
        background-color: #ce1212;
        color: #fff;
    }
    </style>
</head>

<body>
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Chef Admin</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#reservations">Reservations</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#activites">Activités</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">


            <!-- Main Content -->
            <main class="col-md-12 ms-sm-auto col-lg-12 px-md-4 mt-10">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom ">
                    <h1 class="h2">Dashboard</h1>
                </div>

                <!-- Reservations Table -->
                <div class="card mb-4" id="reservations">
                    <div class="card-header">
                        <i class="fas fa-calendar-check"></i> Recent Reservations
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nom de client</th>
                                    <th>Activité</th>
                                    <th>Date</th>
                                    <th>Nombre de places </th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                require_once("../classes/reservation.php");
                                
                                $reservation = new Reservation(null, null, null, null);
                                $reservations = $reservation->showRes();
                if (count($reservations)> 0) {
                    foreach($reservations as $res){                        
                    echo "<tr>
                            <td>{$res['id_reservation']}</td>
                            <td>{$res['name_client']}</td>
                            <td>{$res['name_activite']}</td>
                            <td>{$res['date_reservation']}</td>
                            <td>{$res['nbr_places']}</td>
                            <td>
                                <span class='badge bg-info'>{$res['status']}</span>
                            </td>
                            <td>
                            <form method=\"POST\" action=\"update_status.php\">
                                <input type=\"hidden\" name=\"reservation_id\" value=\"{$res['id_reservation']}\">
                                <button type=\"submit\" name=\"action\" value=\"accept\" class=\"btn btn-sm btn-success\">Accept</button>
                                <button type=\"submit\" name=\"action\" value=\"refuse\" class=\"btn btn-sm btn-danger\">Refuse</button>
                            </form>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7' class='text-center'>No reservations found.</td></tr>";
                }
                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Manage Menus Section -->
                <div class="card mb-4" id="menus">
                    <div class="card-header text-black">
                        <i class="fas fa-bars"></i> Manage Menus
                    </div>
                    <div class="card-body">
                        <!-- Form to Add Menu -->
                        <form method="POST" action="manage_menus.php">
                            <div class="mb-3">
                                <label for="menu_name" class="form-label">Menu Name</label>
                                <input type="text" class="form-control" id="menu_name" name="menu_name" required>
                            </div>
                            <div class="mb-3">
                                <label for="menu_description" class="form-label">Description</label>
                                <textarea class="form-control" id="menu_description" name="menu_description" rows="4"
                                    required></textarea>
                            </div>
                            <button type="submit" class="btn custom-btn">Add Menu</button>
                        </form>

                        <!-- Existing Menus List -->
                        <h5 class="mt-4">Existing Menus</h5>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Menu Name</th>
                                    <th>Description</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $menus = $conn->query("SELECT id_menu, name, description FROM menus");
                                while ($menu = $menus->fetch_assoc()) {
                                    echo "<tr>
                                            <td>{$menu['id_menu']}</td>
                                            <td>{$menu['name']}</td>
                                            <td>{$menu['description']}</td>
                                            <td>
                                                <a href='edit_menu.php?id={$menu['id_menu']}' class='btn btn-secondary btn-sm'>Edit</a>
                                                <a href='delete_menu.php?id={$menu['id_menu']}' class='btn btn-danger btn-sm'>Delete</a>
                                            </td>
                                          </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Manage plats Section -->
                <div class="card mb-4" id="plats">
                    <div class="card-header">
                        <i class="fas fa-utensils"></i> Manage plats
                    </div>
                    <div class="card-body">
                        <!-- Form to Add Multiple plats -->
                        <form method="POST" action="manage_plats.php" enctype="multipart/form-data" id="platsForm">
                            <div id="plats-container">
                                <div class="plat-item">
                                    <div class="mb-3">
                                        <input name="nbr_plat" id="nbr_plat" class="d-none">
                                        <label for="menu_id_0" class="form-label">Menu</label>
                                        <select class="form-select" id="menu_id_0" name="menu_id_0" required>
                                            <option value="">-- Select a Menu --</option>
                                            <?php
                            $menus = $conn->query("SELECT id_menu, name FROM menus");
                            while ($menu = $menus->fetch_assoc()) {
                                echo "<option value='{$menu['id_menu']}'>{$menu['name']}</option>";
                            }
                            ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="name_0" class="form-label">plat Name</label>
                                        <input type="text" class="form-control" id="name_0" name="name_0" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="ingredients_0" class="form-label">Ingredients</label>
                                        <textarea class="form-control" id="ingredients_0" name="ingredients_0" rows="4"
                                            required></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="image_0" class="form-label">plat Image</label>
                                        <input type="file" class="form-control" id="image_0" name="image_0"
                                            accept="image/*" required>
                                    </div>
                                    <hr>
                                </div>
                            </div>
                            <button type="button" class="btn btn-secondary" id="add_plat">Add Another Plat</button>
                            <button type="submit" class="btn custom-btn">Add plats</button>
                        </form>
                    </div>
                </div> <!-- List of Existing plats -->


                <h5 class="mt-4">Existing plats</h5>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>plat Name</th>
                            <th>Menu</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                                $plats = $conn->query("SELECT p.id_plat, p.name, m.name as menu_name FROM plats p JOIN menus m ON p.menu_id = m.id_menu");
                                while ($plat = $plats->fetch_assoc()) {
                                    echo "<tr>
                                            <td>{$plat['id_plat']}</td>
                                            <td>{$plat['name']}</td>
                                            <td>{$plat['menu_name']}</td>
                                            <td>
                                                <a href='delete_plat.php?id={$plat['id_plat']}' class='btn btn-danger btn-sm'>Delete</a>
                                            </td>
                                          </tr>";
                                }
                                ?>
                    </tbody>
                </table>
        </div>
    </div>

    <!-- Statistics Section -->
    <div class="card mt-10" id="statistics">
        <div class="card-header text-black">
            <i class="fas fa-bars"></i> Statistics
        </div>
        <div class="row b-flex justify-content-center">
            <div class="col-md-3">
                <div class="card text-white bg-info mb-3">
                    <div class="card-header">Total Reservations</div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $totalReservations; ?></h5>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-success mb-3">
                    <div class="card-header">Satisfied Customers</div>
                    <div class="card-body">
                        <h5 class="card-title">89%</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-header">Pending Reservations</div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $pendingReservations; ?></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </main>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
</body>

</html>