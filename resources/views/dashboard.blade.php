@extends('layout')

@section('content')
<div class="position-relative w-100 h-100" style="min-height: 92vh;">
    
    <div class="position-absolute top-0 start-50 translate-middle-x mt-4 p-4 bg-white rounded-4 shadow-lg" 
         style="z-index: 999; width: 90%; max-width: 800px; border-left: 6px solid var(--primary);">
        
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h5 class="fw-bold text-dark m-0"><i class="bi bi-search text-primary-custom me-2"></i>Localizar Fornecedores</h5>
            <span class="badge bg-dark text-white px-3 py-2"><i class="bi bi-broadcast"></i> Busca Regional</span>
        </div>
        
        <div class="row g-2">
            <div class="col-md-8">
                <div class="input-group">
                    <span class="input-group-text bg-light border-secondary"><i class="bi bi-layers-fill text-secondary"></i></span>
                    <select id="materialKeyword" class="form-select fw-bold text-secondary border-secondary" style="height: 50px;">
                        <option value="loja de material de construção">TODOS OS MATERIAIS</option>
                        <option value="depósito de cimento e argamassa">CIMENTO / ARGAMASSA</option>
                        <option value="distribuidora de areia e pedra">AREIA E PEDRA</option>
                        <option value="pedreira brita">BRITA / PEDREIRA</option>
                        <option value="madeireira construção">MADEIRAS E VIGAS</option>
                        <option value="fábrica de blocos de concreto">BLOCOS DE CONCRETO</option>
                        <option value="olaria tijolos">TIJOLOS CERÂMICOS</option>
                        <option value="usina de asfalto pavimentação">INSUMOS DE ASFALTO</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <button class="btn btn-dark w-100 h-100 fw-bold text-uppercase" onclick="performSearch()">
                    <i class="bi bi-geo-alt-fill me-2"></i>Buscar Agora
                </button>
            </div>
        </div>
    </div>

    <div id="map" style="height: 92vh; width: 100%;"></div>

</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    (g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce;m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})({
        // Add your own Google Maps API key here before running the map.
        key: "YOUR_GOOGLE_MAPS_API_KEY",
        v: "weekly",
    });
</script>

<script>
    let map, infoWindow;
    let markers = [];
    let currentPos = { lat: -23.550520, lng: -46.633308 }; 

    async function initMap() {
        const { Map } = await google.maps.importLibrary("maps");
        const { AdvancedMarkerElement, PinElement } = await google.maps.importLibrary("marker");

        map = new Map(document.getElementById("map"), {
            center: currentPos,
            zoom: 12,
            mapId: "DEMO_MAP_ID", 
            disableDefaultUI: false,
            mapTypeControl: false
        });

        infoWindow = new google.maps.InfoWindow();

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (pos) => {
                    currentPos = { lat: pos.coords.latitude, lng: pos.coords.longitude };
                    map.setCenter(currentPos);
                    
                    const userPin = new PinElement({
                        background: "#0d6efd",
                        borderColor: "#ffffff",
                        glyphColor: "white",
                    });

                    new AdvancedMarkerElement({
                        map,
                        position: currentPos,
                        title: "Você está aqui",
                        content: userPin.element
                    });
                },
                () => { console.log("Sem GPS"); }
            );
        }
    }

    async function performSearch() {
        const { Place } = await google.maps.importLibrary("places");
        const { AdvancedMarkerElement, PinElement } = await google.maps.importLibrary("marker");
        
        markers.forEach(m => m.map = null);
        markers = [];

        const keyword = document.getElementById('materialKeyword').value;

        if(!keyword) return showToast("Selecione um material para buscar!", "error");

        const request = {
            textQuery: keyword,
            fields: ['displayName', 'location', 'formattedAddress', 'rating', 'internationalPhoneNumber'],
            locationBias: { center: currentPos, radius: 50000 },
            isOpenNow: false,
            maxResultCount: 20,
        };

        try {
            // Places search is biased around the user's current map position.
            const { places } = await Place.searchByText(request);

            if (places.length) {
                const bounds = new google.maps.LatLngBounds();
                
                places.forEach((place) => {
                    if(place.location) {
                        createMarker(place, AdvancedMarkerElement, PinElement);
                        bounds.extend(place.location);
                    }
                });
                
                map.fitBounds(bounds);
            } else {
                showToast("Nenhum local encontrado para esta busca.", "error");
            }
        } catch (error) {
            console.error("Erro busca:", error);
            showToast("Erro ao conectar com o Google Maps.", "error");
        }
    }

    function createMarker(place, AdvancedMarkerElement, PinElement) {
        const pin = new PinElement({
            background: "#ff6b00",
            borderColor: "#cc5500",
            glyphColor: "white",
        });

        const marker = new AdvancedMarkerElement({
            map,
            position: place.location,
            title: place.displayName,
            content: pin.element,
        });

        markers.push(marker);

        marker.addListener("click", () => {
            const safeName = (place.displayName || "Loja").replace(/'/g, "\\'");
            const safeAddress = (place.formattedAddress || "").replace(/'/g, "\\'");
            const safePhone = (place.internationalPhoneNumber || "").replace(/'/g, "\\'"); 
            
            const lat = place.location.lat();
            const lng = place.location.lng();
            const rating = place.rating || "N/A";

            const content = `
                <div style="padding: 10px; min-width: 240px; color: black;">
                    <h6 style="font-weight:800; color: #ff6b00; margin-bottom: 5px;">${place.displayName}</h6>
                    <p style="margin-bottom:8px; font-size: 12px; color: #333;">${place.formattedAddress}</p>
                    <div style="margin-bottom: 10px;">
                         <span class="badge bg-secondary">⭐ ${rating}</span>
                         <span class="badge bg-success"><i class="bi bi-whatsapp"></i> ${safePhone || 'Sem tel'}</span>
                    </div>
                    <button class="btn btn-sm btn-dark w-100 mb-2" 
                        onclick="saveStore('${safeName}', '${safeAddress}', ${lat}, ${lng}, '${safePhone}')">
                        <i class="bi bi-bookmark-plus"></i> SALVAR
                    </button>
                    <a href="https://www.google.com/maps/dir/?api=1&destination=${lat},${lng}" target="_blank" class="btn btn-sm btn-outline-primary w-100">
                        <i class="bi bi-cursor-fill"></i> ROTA
                    </a>
                </div>
            `;
            infoWindow.setContent(content);
            infoWindow.open(map, marker);
        });
    }

    function saveStore(name, address, lat, lng, phone) {
        axios.post('{{ route("favorites.save") }}', {
            name: name, 
            address: address, 
            lat: lat, 
            lng: lng, 
            phone: phone, 
            _token: '{{ csrf_token() }}'
        })
        .then(() => {
            showToast('Fornecedor salvo nos favoritos!', 'success');
        })
        .catch((error) => {
            if(error.response && error.response.status === 409) {
                showToast('Esta loja já está na sua lista!', 'error');
            } else {
                showToast('Erro ao salvar o fornecedor.', 'error');
            }
        });
    }

    initMap();
</script>
@endsection
