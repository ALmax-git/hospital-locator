<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Hospital Locator</title>
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.css" />
        <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
        }

        nav input {
            padding: 10px;
            border: none;
            border-radius: 4px;
            width: 250px;
        }

        nav button {
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            background-color: white;
            color: #007bff;
            cursor: pointer;
            margin-left: 10px;
        }

        nav button:hover {
            background-color: #e9ecef;
        }

        #map {
            height: 400px;
            /* Increased height for better visibility */
        }
        </style>
    </head>

    <body>
        <!-- Navigation -->
        <nav>
            <div>
                <input type="text" id="location-input" placeholder="Search for a hospital...">
                <button id="search-button">Search</button>
            </div>
            <div>
                <button id="profile-button">Profile</button>
            </div>
        </nav>

        <!-- Map -->
        <div id="map"></div>

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Initialize the map centered at Maiduguri
            var map = L.map('map').setView([12.6729, 13.6160], 12);

            // Set up the Esri satellite tile layer
            L.tileLayer(
                'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                    attribution: 'Tiles © Esri'
                }).addTo(map);

            // Fetch hospitals from the server-side (update this if needed)
            fetch('api/hospital.php')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (!data.success) {
                        throw new Error(data.message || 'Failed to fetch hospitals.');
                    }

                    // Now hospitals are in data.hospitals
                    data.hospitals.forEach(hospital => {
                        L.marker([hospital.latitude, hospital.longitude]).addTo(map)
                            .bindPopup(
                                `<b>${hospital.name}</b><br />Coordinates: (${hospital.latitude}, ${hospital.longitude})`
                            );
                    });
                })
                .catch(error => {
                    console.error('Error fetching hospitals:', error);
                    Swal.fire({
                        title: 'Error',
                        text: 'An error occurred while fetching hospitals. Please check your API endpoint and try again later.',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    });
                });
        });

        // Search button click handler
        // Declare the markers array globally
        let markers = []; // Initialize markers as an empty array

        document.getElementById('search-button').addEventListener('click', function() {
            const locationInput = document.getElementById('location-input').value.trim();

            if (!locationInput) {
                Swal.fire('Warning', 'Please enter a location to search.', 'warning');
                return;
            }

            console.log('Searching for location:', locationInput); // Log the input to ensure it's correct

            fetch(`api/geocode.php?location=${encodeURIComponent(locationInput)}`)
                .then(response => {
                    console.log('Response received:', response); // Log the full response for debugging
                    if (!response.ok) {
                        throw new Error(
                            `Network response was not ok: ${response.status} - ${response.statusText}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Data received:', data); // Log the received data for debugging

                    // Check if the response indicates success
                    if (data.success) {
                        // Extract hospital information
                        const {
                            latitude,
                            longitude,
                            name,
                            address
                        } = data.hospital;

                        // Convert latitude and longitude to floats
                        const lat = parseFloat(latitude);
                        const lon = parseFloat(longitude);

                        // Check if latitude and longitude are valid numbers
                        if (!isNaN(lat) && !isNaN(lon)) {
                            Swal.fire('Success', 'Location found', 'success');
                        } else {
                            console.error('Invalid latitude or longitude:', latitude, longitude);
                            Swal.fire('Error', 'Invalid location coordinates.', 'error');
                        }
                    } else {
                        const errorMessage = 'No results found for this location.';
                        console.error('Error in data response:', errorMessage); // Log error details
                        Swal.fire('Error', errorMessage, 'error');
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error); // Log full error details for better debugging
                    Swal.fire('Error', 'An error occurred while fetching the location. Please try again.',
                        'error');
                });
        });

        //
        </script>
    </body>

</html>