<?php include 'includes/header.php';?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/modules/alimento.css">
    <link rel="stylesheet" href="css/temqteremtudo.css">
    <link rel="stylesheet" href="css/pop_up.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Alimentos</title>
</head>

<body>
    <header>
        <h1>Doação de Alimentos</h1>
    </header>
    <div id="popupContainer"></div>

    <div id="map"></div>
    
    <!-- prettier-ignore -->
    <script>
                ( g => {
                    var h, a, k, p = "The Google Maps JavaScript API",
                        c = "google",
                        l = "importLibrary",
                        q = "__ib__",
                        m = document,
                        b = window;
                    b = b[ c ] || ( b[ c ] = {} );
                    var d = b.maps || ( b.maps = {} ),
                        r = new Set,
                        e = new URLSearchParams,
                        u = () => h || ( h = new Promise( async ( f, n ) => {
                            await ( a = m.createElement( "script" ) );
                            e.set( "libraries", [ ...r ] + "" );
                            for ( k in g ) e.set( k.replace( /[A-Z]/g, t => "_" + t[ 0 ].toLowerCase() ), g[ k ] );
                            e.set( "callback", c + ".maps." + q );
                            a.src = `https://maps.${ c }apis.com/maps/api/js?` + e;
                            d[ q ] = f;
                            a.onerror = () => h = n( Error( p + " could not load." ) );
                            a.nonce = m.querySelector( "script[nonce]" )?.nonce || "";
                            m.head.append( a );
                        } ) );
                    d[ l ] ? console.warn( p + " only loads once. Ignoring:", g ) : d[ l ] = ( f, ...n ) => r.add( f ) && u().then( () => d[ l ]( f, ...n ) );
                } )( { key: "AIzaSyBP9WaLXE4AXU4u_-zJNUOOprBUSe7ObKE", v: "weekly" } );

        let map;

        async function initMap () {
            const { Map } = await google.maps.importLibrary( "maps" );

            // Inicializa o mapa
            map = new Map( document.getElementById( "map" ), {
                center: { lat: -22.90946578677424, lng: -47.08399707485706 },
                zoom: 14,
            } );

                        // Inicializa o geocoder para converter CEP em coordenadas
                        geocoder = new google.maps.Geocoder();
                    }

                    // Função para centralizar o mapa baseado no CEP
                    function centralizarMapaPorCEP ( cep ) {
                        geocoder.geocode( { address: cep }, ( results, status ) => {
                            if ( status === "OK" ) {
                                // Obtém as coordenadas do primeiro resultado
                                const location = results[ 0 ].geometry.location;

                                // Centraliza o mapa nas coordenadas obtidas
                                map.setCenter( location );
                                map.setZoom( 14 );

                                // Adiciona um marcador na localização
                                new google.maps.Marker( {
                                    map: map,
                                    position: location,
                                    title: "Localização do CEP: " + cep,
                                } );
                            } else {
                                console.error( "Geocodificação falhou devido a: " + status );
                            }
                        } );

                        // Lista de coordenadas para os pontos específicos
                        const pontos = [
                            { lat: -22.9046949496147, lng: -47.06844035443394, title: "Hospital Vera Cruz" },
                            // Adicione mais pontos aqui, se necessário
                        ];

                        // Cria os marcadores no mapa após o mapa estar inicializado
                        pontos.forEach( ponto => {
                            new google.maps.Marker( {
                                position: { lat: ponto.lat, lng: ponto.lng },
                                map: map,
                                title: ponto.title,
                            } );
            } );
        }

        initMap();
    </script>
    
    <?php include 'includes/footer.php'; ?>
    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>