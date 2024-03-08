<x-front-layout title="Checkout">

    <x-slot name="breadcrumb">
        <div class="breadcrumbs">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="breadcrumbs-content">
                            <h1 class="page-title">order # {{ $order->number }}</h1>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <ul class="breadcrumb-nav">
                            <li><a href="{{ route('home') }}"><i class="lni lni-home"></i> Home</a></li>
                            <li><a href="#">Orders</a></li>
                            <li>order # {{ $order->number }}</li>
                            <section>

                            </section>
                        </ul>
                    </div>
                </div>
            </div>
            <div id='map' style="height: 100vh;"></div>
        </div>
    </x-slot>

    <head>
        <meta charset="utf-8">
        <title>Add a default marker to a web map</title>
        <meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no">
        <link href="https://api.mapbox.com/mapbox-gl-js/v2.13.0/mapbox-gl.css" rel="stylesheet">
        <script src="https://api.mapbox.com/mapbox-gl-js/v2.13.0/mapbox-gl.js"></script>
        <style>
            body {
                margin: 0;
                padding: 0;
            }

            #map {
                position: absolute;
                top: 0;
                bottom: 0;
                width: 100%;
            }

            #instructions {
                position: absolute;
                margin: 20px;
                width: 25%;
                top: 0;
                bottom: 20%;
                padding: 20px;
                background-color: #d5aeae;
                overflow-y: scroll;
                font-family: sans-serif;
            }
        </style>
    </head>

    <body>
        <div id="map"></div>

        <script>
            mapboxgl.accessToken = 'pk.eyJ1IjoiZXNyYTI2MjYiLCJhIjoiY2w4bHE2bm9wMWp5ZjNvbzV0aTZ6Zml0aCJ9.8KQ41nW0IvAkgEwmZ5NrCQ';
            const map = new mapboxgl.Map({
                container: 'map',
                // Choose from Mapbox's core styles, or make your own style with Mapbox Studio
                style: 'mapbox://styles/mapbox/streets-v12',
                center: [36.295343, 33.640930],
                zoom: 15.7
            });

            // Create a default Marker and add it to the map.
            // const marker1 = new mapboxgl.Marker()
            //     .setLngLat([36.295343, 33.640930])
            //     .addTo(map);

            //  Create a default Marker, colored black, rotated 45 degrees.
            const marker2 = new mapboxgl.Marker({
                    color: 'black',
                    rotation: 45
                })
                .setLngLat([36.295343, 33.640930])
                .addTo(map);
        </script>
     <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
     <script>
   
       // Enable pusher logging - don't include this in production
       Pusher.logToConsole = true;
   
       var pusher = new Pusher('7dd69fada7ab7db35db5', {
         cluster: 'ap2'
       });
   
       var channel = pusher.subscribe('my-channel');
       channel.bind('location-updated', function(data) {
         alert(JSON.stringify(data));
       });
     </script>
    </body>


</x-front-layout>
