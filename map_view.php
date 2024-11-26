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


    </body>

</html>
