<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel Google Maps</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <style>
            /* Coloca tu CSS aquí */
            #my-location {
                height: 100vh; /* Asegúrate de que el div del mapa tenga altura */
            }
        </style>
    </head>
    <body class="font-sans antialiased dark:bg-black dark:text-white/50">
        <div id="my-location"></div>
        <script>
            let map
            let mark

            function initMap() {
                map = new google.maps.Map(document.getElementById('my-location'), {
                    center: { lat: -34.397, lng: 150.644 },
                    zoom: 17
                });

                mark = new google.maps.Marker({
                    map: map
                });

                updateLocation();
                setInterval(updateLocation, 5000)
            }

            function updateLocation() {
                console.log("Actualizando ubicación...")
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition((position) => {
                        const pos = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };

                        mark.setPosition(pos);
                        map.setCenter(pos);
                    }, () => {
                        handleLocationError(true, map.getCenter())
                    });
                } else {
                    handleLocationError(false, map.getCenter())
                }
            }

            function handleLocationError(browserHasGeolocation, pos) {
                const infoWindow = new google.maps.InfoWindow({
                    position: pos,
                    content: browserHasGeolocation ?
                        'Error al mostrar la geolocalización' :
                        'Error al cargar la localización'
                });
                infoWindow.open(map);
            }
        </script>
        <script async src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}&callback=initMap"></script>
    </body>
</html>
