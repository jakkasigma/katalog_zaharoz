import './bootstrap';
import 'maplibre-gl/dist/maplibre-gl.css';
import maplibregl from 'maplibre-gl';

const lightMapStyle = {
    version: 8,
    sources: {
        carto: {
            type: 'raster',
            tiles: ['https://a.basemaps.cartocdn.com/light_all/{z}/{x}/{y}.png'],
            tileSize: 256,
            attribution: '&copy; OpenStreetMap contributors &copy; CARTO',
        },
    },
    layers: [{ id: 'carto', type: 'raster', source: 'carto' }],
};

const darkMapStyle = {
    version: 8,
    sources: {
        carto: {
            type: 'raster',
            tiles: ['https://a.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}.png'],
            tileSize: 256,
            attribution: '&copy; OpenStreetMap contributors &copy; CARTO',
        },
    },
    layers: [{ id: 'carto', type: 'raster', source: 'carto' }],
};

const defaultLocation = {
    latitude: -6.9175,
    longitude: 107.6191,
    zoom: 12,
};

function currentMapStyle() {
    const hasDarkClass = document.documentElement.classList.contains('dark');
    const prefersDark = window.matchMedia?.('(prefers-color-scheme: dark)').matches ?? false;

    return hasDarkClass || prefersDark ? darkMapStyle : lightMapStyle;
}

function formatCoordinate(value) {
    return Number(value).toFixed(7);
}

function showAlert(container, message, type = 'info') {
    container.classList.remove('hidden', 'border-green-700', 'bg-green-950', 'text-green-200', 'border-red-700', 'bg-red-950', 'text-red-200', 'border-rose-700', 'bg-rose-950', 'text-rose-100');

    const classes = {
        success: ['border-green-700', 'bg-green-950', 'text-green-200'],
        error: ['border-red-700', 'bg-red-950', 'text-red-200'],
        info: ['border-rose-700', 'bg-rose-950', 'text-rose-100'],
    }[type];

    container.classList.add(...classes);
    container.textContent = message;
}

function initAddressMap(wrapper) {
    const canvas = wrapper.querySelector('[data-map-canvas]');
    const locationButton = wrapper.querySelector('[data-current-location]');
    const alertBox = wrapper.querySelector('[data-map-alert]');
    const display = wrapper.querySelector('[data-coordinate-display]');
    const latitudeInput = document.getElementById('latitude');
    const longitudeInput = document.getElementById('longitude');

    // Komponen Input Form Alamat
    const provinceInput = document.getElementById('province');
    const cityInput = document.getElementById('city');
    const districtInput = document.getElementById('district');
    const postalCodeInput = document.getElementById('postal_code');
    const fullAddressInput = document.getElementById('full_address');

    if (!canvas || !latitudeInput || !longitudeInput) {
        return;
    }

    const savedLatitude = parseFloat(wrapper.dataset.latitude || latitudeInput.value);
    const savedLongitude = parseFloat(wrapper.dataset.longitude || longitudeInput.value);
    const hasSavedLocation = Number.isFinite(savedLatitude) && Number.isFinite(savedLongitude);
    const center = hasSavedLocation
        ? [savedLongitude, savedLatitude]
        : [defaultLocation.longitude, defaultLocation.latitude];

    const map = new maplibregl.Map({
        container: canvas,
        style: currentMapStyle(),
        center,
        zoom: hasSavedLocation ? 15 : defaultLocation.zoom,
    });

    map.addControl(new maplibregl.NavigationControl({ showCompass: true }), 'top-right');

    const marker = new maplibregl.Marker({ draggable: true, color: '#e11d48' })
        .setLngLat(center)
        .addTo(map);

    // Fungsi reverse geocoding menggunakan Nominatim OpenStreetMap (Gratis)
    async function reverseGeocode(longitude, latitude) {
        showAlert(alertBox, 'Mendeteksi alamat dari titik lokasi...', 'info');

        try {
            const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${latitude}&lon=${longitude}&accept-language=id,en`, {
                headers: {
                    'User-Agent': 'EyesOfZaharozLaravelApp/1.0'
                }
            });

            if (!response.ok) {
                throw new Error('Gagal memanggil API Geocoding.');
            }

            const data = await response.json();

            if (data && data.address) {
                const addr = data.address;

                // Ekstraksi komponen alamat
                const province = addr.state || addr.region || '';
                const city = addr.city || addr.city_district || addr.county || addr.municipality || addr.town || '';
                const district = addr.suburb || addr.village || addr.district || '';
                const postalCode = addr.postcode || '';

                // Formulasi Alamat Lengkap
                const road = addr.road || '';
                const neighbourhood = addr.neighbourhood || addr.suburb || '';
                const hamlet = addr.hamlet || '';

                let streetAddress = road;
                if (neighbourhood && neighbourhood !== district) {
                    streetAddress += (streetAddress ? ', ' : '') + neighbourhood;
                }
                if (hamlet) {
                    streetAddress += (streetAddress ? ', ' : '') + hamlet;
                }

                // Fallback ke display_name jika jalan kosong
                const fullAddress = streetAddress || data.display_name;

                // Isi otomatis semua input di form
                if (provinceInput) {
                    provinceInput.value = province.replace('Daerah Khusus Ibukota ', 'DKI ');
                }
                if (cityInput) {
                    cityInput.value = city.replace('Kota ', '').replace('Kabupaten ', '');
                }
                if (districtInput) {
                    districtInput.value = district;
                }
                if (postalCodeInput && postalCode) {
                    postalCodeInput.value = postalCode;
                }
                if (fullAddressInput && fullAddress) {
                    fullAddressInput.value = fullAddress;
                }

                showAlert(alertBox, 'Alamat otomatis terdeteksi dan diisi.', 'success');
            } else {
                showAlert(alertBox, 'Koordinat terekam. Gagal mendeteksi teks alamat wilayah.', 'info');
            }
        } catch (error) {
            console.error('Geocoding error:', error);
            showAlert(alertBox, 'Gagal mengambil alamat otomatis. Silakan isi form manual.', 'error');
        }
    }

    function updateCoordinates(longitude, latitude, shouldMoveMarker = true, shouldGeocode = true) {
        latitudeInput.value = formatCoordinate(latitude);
        longitudeInput.value = formatCoordinate(longitude);
        display.textContent = `${formatCoordinate(latitude)}, ${formatCoordinate(longitude)}`;

        if (shouldMoveMarker) {
            marker.setLngLat([longitude, latitude]);
        }

        if (shouldGeocode) {
            reverseGeocode(longitude, latitude);
        }
    }

    if (hasSavedLocation) {
        // Jangan timpa data editan user ketika membuka halaman edit
        updateCoordinates(savedLongitude, savedLatitude, false, false);
    }

    map.on('click', (event) => {
        updateCoordinates(event.lngLat.lng, event.lngLat.lat, true, true);
    });

    marker.on('dragend', () => {
        const position = marker.getLngLat();
        updateCoordinates(position.lng, position.lat, false, true);
    });

    locationButton?.addEventListener('click', () => {
        if (!navigator.geolocation) {
            showAlert(alertBox, 'Browser Anda belum mendukung geolocation.', 'error');
            return;
        }

        const originalText = locationButton.textContent;
        locationButton.disabled = true;
        locationButton.textContent = 'Mencari lokasi...';
        showAlert(alertBox, 'Mengambil lokasi GPS. Izinkan akses lokasi jika diminta browser.', 'info');

        navigator.geolocation.getCurrentPosition(
            (position) => {
                const latitude = position.coords.latitude;
                const longitude = position.coords.longitude;

                map.flyTo({ center: [longitude, latitude], zoom: 16 });
                updateCoordinates(longitude, latitude, true, true);
                locationButton.disabled = false;
                locationButton.textContent = originalText;
            },
            (error) => {
                const messages = {
                    1: 'Izin lokasi ditolak. Pilih titik lokasi langsung dari peta.',
                    2: 'Lokasi GPS tidak tersedia. Coba lagi atau pilih dari peta.',
                    3: 'Permintaan lokasi terlalu lama. Coba lagi atau pilih dari peta.',
                };

                showAlert(alertBox, messages[error.code] || 'Gagal mengambil lokasi. Pilih titik dari peta.', 'error');
                locationButton.disabled = false;
                locationButton.textContent = originalText;
            },
            {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0,
            },
        );
    });
}

document.querySelectorAll('[data-address-map]').forEach(initAddressMap);
