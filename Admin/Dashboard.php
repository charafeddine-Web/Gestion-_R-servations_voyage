<?php 
session_start();
if(!isset($_SESSION['user_id']) || (isset($_SESSION['role_id']) && $_SESSION['role_id'] == 3) ){
    header("Location: ../index.php");
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
            <a class="navbar-brand" href="#">Admin</a>
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
                        <i class="fas fa-calendar-check"></i>Reservations récentes
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

                <!-- Manage Activities Section -->
                <div class="card mb-4" id="activites">
                    <div class="card-header text-black">
                        <i class="fas fa-bars"></i> Gérer les activités
                    </div>
                    <div class="card-body">
                        <!-- Form to Add Activité -->
                        <form method="POST" action="manage_activities.php">
                            <input type="hidden" name="add_activity" value="1">
                            <div class="mb-3">
                                <label for="activite_name" class="form-label">Nom d'activité </label>
                                <input type="text" class="form-control" id="activite_name" name="activite_name"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="activite_description" class="form-label">Description</label>
                                <textarea class="form-control" id="activite_description" name="activite_description"
                                    rows="4" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="activite_destination" class="form-label">Destination</label>
                                <input type="text" class="form-control" id="activite_destination"
                                    name="activite_destination" required>
                            </div>
                            <div class="mb-3">
                                <label for="activite_price" class="form-label">Prix</label>
                                <input type="text" class="form-control" id="activite_price" name="activite_price"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="activite_start_date" class="form-label">date de début</label>
                                <input type="date" class="form-control" id="activite_start_date" name="start_date"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="activite_end_date" class="form-label">date de fin</label>
                                <input type="date" class="form-control" id="activite_end_date" name="end_date" required>
                            </div>
                            <button type="submit" class="btn custom-btn">Ajouter</button>
                        </form>

                        <!-- Liste des activités -->
                        <h3>Liste des Activités</h3>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nom</th>
                                    <th>Description</th>
                                    <th>Destination</th>
                                    <th>Prix</th>
                                    <th>Date de début</th>
                                    <th>Date de fin</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                require_once("../classes/activity.php");

                $activity = new Activity(null, null, null, null, null, null);
                $activites = $activity->allActivites();
                if (count($activites) > 0): ?>
                                <?php foreach ($activites as $act): ?>
                                <tr>
                                    <td><?= $act['id_activite']; ?></td>
                                    <td><?= $act['name']; ?></td>
                                    <td><?= $act['description']; ?></td>
                                    <td><?= $act['destination']; ?></td>
                                    <td><?= $act['price']; ?></td>
                                    <td><?= $act['start_date']; ?></td>
                                    <td><?= $act['end_date']; ?></td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-sm editActivityBtn"
                                            data-id="<?= $act['id_activite']; ?>" data-name="<?= $act['name']; ?>"
                                            data-description="<?= $act['description']; ?>"
                                            data-destination="<?= $act['destination']; ?>"
                                            data-price="<?= $act['price']; ?>"
                                            data-start-date="<?= $act['start_date']; ?>"
                                            data-end-date="<?= $act['end_date']; ?>">
                                            Modifier
                                        </button>
                                        <form method="POST" action="manage_activities.php" class="d-inline">
                                            <button type="submit" name="delete_activity"
                                                value="<?= $act['id_activite']; ?>"
                                                class="btn btn-danger btn-sm">Supprimer</button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center">Aucune activité trouvée.</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Modal Modifier Activité -->
                <div class="modal fade" id="editActivityModal" tabindex="-1" aria-labelledby="editActivityModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="manage_activities.php">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editActivityModalLabel">Modifier une Activité</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" id="edit_activity_id" name="id_act">
                                    <div class="mb-3">
                                        <label for="edit_activity_name" class="form-label">Nom d'activité</label>
                                        <input type="text" class="form-control" id="edit_activity_name" name="menu_name"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit_activity_description" class="form-label">Description</label>
                                        <textarea class="form-control" id="edit_activity_description"
                                            name="activite_description" rows="4" required></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit_activity_destination" class="form-label">Destination</label>
                                        <input type="text" class="form-control" id="edit_activity_destination"
                                            name="activite_destination" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit_activity_price" class="form-label">Prix</label>
                                        <input type="text" class="form-control" id="edit_activity_price"
                                            name="activite_price" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit_activity_start_date" class="form-label">Date de début</label>
                                        <input type="date" class="form-control" id="edit_activity_start_date"
                                            name="start_date" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit_activity_end_date" class="form-label">Date de fin</label>
                                        <input type="date" class="form-control" id="edit_activity_end_date"
                                            name="end_date" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Fermer</button>
                                    <button type="submit" name="edit_activity"
                                        class="btn btn-primary">Enregistrer</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.querySelectorAll('.editActivityBtn').forEach(button => {
        button.addEventListener('click', function () {
            document.getElementById('edit_activity_id').value = this.dataset.id;
            document.getElementById('edit_activity_name').value = this.dataset.name;
            document.getElementById('edit_activity_description').value = this.dataset.description;
            document.getElementById('edit_activity_destination').value = this.dataset.destination;
            document.getElementById('edit_activity_price').value = this.dataset.price;
            document.getElementById('edit_activity_start_date').value = this.dataset['start-date'];
            document.getElementById('edit_activity_end_date').value = this.dataset['end-date'];

            let editModal = new bootstrap.Modal(document.getElementById('editActivityModal'));
            editModal.show();
        });
    });
</script>

</body>

</html>