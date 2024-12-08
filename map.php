<?php
// Display errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include the Hospital model
require_once './models/Hospital.php';

// Database configuration
$host = "127.0.0.1";
$db_name = "hospital_log";
$username = "root";
$password = "";
$conn = null;

// Database connection
try {
    $conn = new mysqli($host, $username, $password, $db_name);
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
} catch (Exception $e) {
    die(json_encode(['success' => false, 'message' => "Database connection error: " . $e->getMessage()]));
}

$hospitals = new Hospital($conn);
$hospitals = $hospitals->read();

?>


<div class="container mt-5">
    <h1 class="text-center mb-4">Hospital List</h1>

    <!-- Search Box -->
    <div class="mb-3">
        <input type="text" id="searchBox" class="form-control" placeholder="Search hospitals by name, address, or city">
    </div>

    <table class="table table-striped table-bordered" id="hospitalTable">
        <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Longitude</th>
            <th>Latitude</th>
            <th>Address</th>
            <th>City</th>
            <th>Status</th>
            <th>Created At</th>
            <th>Updated At</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($hospitals as $hospital): ?>
            <tr>
                <td><?= htmlspecialchars($hospital['id']) ?></td>
                <td><?= htmlspecialchars($hospital['name']) ?></td>
                <td><?= htmlspecialchars($hospital['longitude']) ?></td>
                <td><?= htmlspecialchars($hospital['latitude']) ?></td>
                <td><?= htmlspecialchars($hospital['address']) ?></td>
                <td><?= htmlspecialchars($hospital['city']) ?></td>
                <td><?= htmlspecialchars($hospital['status']) == 1 ? 'Active' : 'Inactive' ?></td>
                <td><?= htmlspecialchars($hospital['created_at']) ?></td>
                <td><?= htmlspecialchars($hospital['updated_at']) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Include Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Add JavaScript for Search Functionality -->
<script>
    document.getElementById('searchBox').addEventListener('input', function () {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll('#hospitalTable tbody tr');

        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            const rowText = Array.from(cells).map(cell => cell.textContent.toLowerCase()).join(' ');
            row.style.display = rowText.includes(filter) ? '' : 'none';
        });
    });
</script>

