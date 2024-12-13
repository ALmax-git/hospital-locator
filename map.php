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
    <h1 class="text-center mb-4"><?php echo "Hospitals "; echo $_GET['web'] == "search" ? "Location" : "Name"; ?></h1>

    <!-- Search Box -->
    <div class="row">
      <div class="col-8 mb-3">
        <input type="text" id="searchBox" class="form-control" placeholder="Search hospitals by <?php echo $_GET['web'] == "search" ? "Location" : "Name"; ?>">
      </div>
       <div class="col-4 mb-3">
         <button class="btn btn-primary" id="searchBtn">Search</button>
       </div>
    </div>
    <div class="mb-3" id="info" style="visibility: hidden; color: green;">Click on a row to view more info of the hospital...</div>

    <table class="table table-striped table-bordered" id="hospitalTable" style="visibility: hidden;">
        <thead class="table-<?php echo $_GET['web'] == "search" ? "dark" : "success"; ?>">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Address</th>
                <th>Ward</th>
                <th>City</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($hospitals as $hospital): ?>
                <tr>
                    <td><?= htmlspecialchars($hospital['id']) ?></td>
                    <td><?= htmlspecialchars($hospital['name']) ?></td>
                    <td><?= htmlspecialchars($hospital['address']) ?></td>
                    <td><?= htmlspecialchars($hospital['ward']) ?></td>
                    <td><?= htmlspecialchars($hospital['city']) ?></td>
                    <td><?= htmlspecialchars($hospital['status']) == 1 ? 'Active' : 'Inactive' ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Include Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Add JavaScript for Search Functionality -->
<script>
    document.getElementById('searchBtn').addEventListener('click', function() {
        const filter = document.getElementById('searchBox').value.toLowerCase().trim();
        const table = document.getElementById('hospitalTable');
        const rows = table.querySelectorAll('tbody tr');
        const info = document.getElementById('info');
        
        // Ensure table and info sections are visible
        table.style.visibility = 'visible';
        info.style.visibility = 'visible';

        // Check if there are rows to filter
        if (rows.length > 0) {
            let matchesFound = false;

            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                const rowText = Array.from(cells).map(cell => cell.textContent.toLowerCase()).join(' ');

                if (rowText.includes(filter)) {
                    row.style.display = ''; // Show matching rows
                    matchesFound = true;
                } else {
                    row.style.display = 'none'; // Hide non-matching rows
                }
            });

            // Display message if no matches are found
            if (!matchesFound) {
                info.textContent = 'No matching hospitals found.';
            } else {
                info.textContent = ''; // Clear message if matches are found
            }
        } else {
            console.log('No rows to filter.');
            info.textContent = 'No data available in the table.';
        }
    });
</script>

