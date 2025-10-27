<x-layout>
    <div class="w-screen h-auto flex justify-center items-center flex-col bg-white gap-y-5">
        <!-- Maps -->
        <div id="map" class="h-[200px] flex w-full shadow-lg z-0"></div>
        <!-- AQI -->
        <div class="w-[95%] h-auto rounded-3xl flex">
            <div x-data="{ activeTab: 'barangay' }" class="w-full h-full">
                <!-- Tab header -->
                <div class="flex flex-row justify-between h-[50px] w-full">
                    <div class="flex flex-row bg-[#eceaea] rounded-t-lg w-60">
                        <button
                            class=" w-30 rounded-t-lg"
                            @click="activeTab = 'barangay'"
                            :class="activeTab === 'barangay'
                                    ? 'text-[#06402b] font-semibold bg-white border-[#06402b] border-t-4'
                                    : 'text-black border-b border-transparent hover:text-blue-500'">
                            Barangay 115
                        </button>
                        
                        <button
                            class=" w-30 rounded-t-lg"
                            @click="activeTab = 'ucc'"
                            :class="activeTab === 'ucc'
                                    ? 'text-[#06402b] font-semibold bg-white border-[#06402b] border-t-4'
                                    : 'text-[#06402b] border-b border-transparent hover:text-blue-500'">
                            UCC
                        </button>
                    </div>
                </div>

                <!-- Tab content -->
                <div class="border border-white rounded-b-3xl h-auto bg-white">
                    <div x-show="activeTab === 'barangay'" x-transition class="flex flex-col h-auto w-full justify-between items-center">
                        <div class="w-[98%] h-[100px] flex flex-col gap-y-1 justify-center items-start px-1">
                            <div class="w-14 h-4 flex justify-center items-center gap-x-2 bg-red-500 text-black text-center text-xs rounded-md"><span class="text-xl text-center">•</span>LIVE</div>
                            <span class="text-black font-bold text-lg tracking-wide uppercase">Air Quality Index | Sound Level</span>
                            <span class="text-[#919090] text-sm italic">Last Updated: 2025-09-25 06:52:16 PM (Local Time)</span>
                        </div>
                        <div id="aqi-back" class="">
                            <div class="w-[48%] flex flex-col h-auto justify-center items-center gap-y-6">
                                <div class="flex flex-row gap-y-5 w-[80%]"> 
                                    <div class="flex flex-col w-[30%] items-center justify-center">
                                        <div class="flex flex-row gap-x-2 items-center">
                                            <div class="w-4 h-4 rounded-full bg-red-600 animate-pulse duration-100"></div>
                                            <span class="text-sm font-semibold">Live AQI</span>
                                        </div>
                                        <span id="aqi-value">0</span>
                                    </div>
                                    <div class="flex flex-col w-[70%] gap-y-2 justify-center items-center">
                                        <span class="text-sm font-semibold">Air Quality is</span>
                                        <span id="aqi-category">Good</span>
                                    </div>        
                                </div>
                                <div class="w-[80%] h-auto flex mt-8">
                                    <div class="relative w-full max-w-xl mx-auto">
                                        <!-- Labels positioned along the same line -->
                                        <div class="absolute -top-6 left-0 w-full">
                                            <div class="relative w-full text-xs text-gray-700">

                                            <!-- Each span positioned by left percentage matching color stop -->
                                            <span class="absolute -translate-x-1/2 left-[12.5%] text-center text-black">0-25</span>
                                            <span class="absolute -translate-x-1/2 left-[30%]  text-center text-black">25.1-35</span>
                                            <span class="absolute -translate-x-1/2 left-[40%]  text-center text-black">35.1-45</span>
                                            <span class="absolute -translate-x-1/2 left-[50%]  text-center text-black">45.1-55</span>
                                            <span class="absolute -translate-x-1/2 left-[72.5%] text-center text-black">55.1-90</span>
                                            <span class="absolute -translate-x-1/2 left-[95%]  text-center text-black">90.1+</span>

                                            </div>
                                        </div>
                                        <!-- AQI slider with multicolor track -->
                                        <input
                                            id="aqi-slider"
                                            type="range"
                                            min="0"
                                            max="100"
                                            value="0"
                                            disabled
                                            class="w-full h-3 rounded-lg appearance-none"
                                            style="
                                            background: linear-gradient(
                                                to right,
                                                #00E400 0%,  #00E400 25%,
                                                #FFFF00 25%, #FFFF00 35%,
                                                #FF7E00 35%, #FF7E00 45%,
                                                #FF0000 45%, #FF0000 55%,
                                                #8F3F97 55%, #8F3F97 90%,
                                                #7E0023 90%, #7E0023 100%
                                            );
                                            "
                                        >

                                        <!-- Labels positioned along the same line -->
                                        <div class="absolute top-6 left-0 w-full">
                                            <div class="relative w-full text-xs text-gray-700">
                                            <!-- Each span positioned by left percentage matching color stop -->
                                            <span class="absolute -translate-x-1/2 left-[12.5%] text-center text-black">Good</span>
                                            <span class="absolute -translate-x-1/2 left-[30%]  text-center text-black">Fair</span>
                                            <span class="absolute -translate-x-1/2 left-[40%]  text-center text-black">Unhealthy</span>
                                            <span class="absolute -translate-x-1/2 left-[50%]  text-center text-black">Very<br>Unhealthy</span>
                                            <span class="absolute -translate-x-1/2 left-[72.5%] text-center text-black">Acutely Unhealthy</span>
                                            <span class="absolute -translate-x-1/2 left-[95%]  text-center text-black">Emergency</span>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="flex flex-row justify-evenly w-[80%] mt-6">
                                    <span class="text-sm text-black font-bold">PM2.5: <span class="text-black font-normal">16 µg/m³</span></span>
                                    <div class="h-4 border border-white"></div>
                                    <span class="text-sm text-black font-bold">PM10: <span class="text-black font-normal">18 µg/m³</span></span>
                                    <div class="h-4 border border-white"></div>
                                    <span class="text-sm text-black font-bold">CO: <span class="text-black font-normal">62 pbb</span></span>
                                    <div class="h-4 border border-white"></div>
                                    <span class="text-sm text-black font-bold">NO2: <span class="text-black font-normal">7 pbb</span></span>
                                </div>
                            </div>
                            <div class="w-[48%] flex flex-col h-auto justify-center items-center gap-y-6">
                                <div class="flex flex-row bg-white/20 border border-white w-[80%] h-[70%] rounded-xl items-center justify-evenly">
                                    <div class="w-[40%] h-full flex flex-col items-center justify-center">
                                        <span class="text-gray-500 font-semibold uppercase">Sound Level</span>
                                        <span class="text-black font-bold text-6xl">70<span class="text-base">db</span></span>
                                    </div>
                                    <div class="h-full border border-white"></div>
                                    <div class="w-[60%] h-full flex flex-col items-center justify-center gap-y-5">
                                        <div class="w-full justify-center items-center flex flex-row gap-x-3">
                                            <span class="text-sm text-center font-semibold">Average dB:</span>
                                            <span class="text-3xl text-center font-bold text-green-600">70</span>
                                        </div>
                                        <div class="w-full justify-center items-center flex flex-row gap-x-3">
                                            <span class="text-sm text-center font-semibold">Peak dB:</span>
                                            <span class="text-3xl text-center font-bold text-red-600">80</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-full h-[400px] flex flex-row gap-x-3 mt-5">
                            <div class="w-[50%] mx-auto bg-white p-4 rounded-xl shadow-md">
                                <h1 class="text-xl font-semibold mb-4 text-center">Air Monitoring Chart</h1>
                                <canvas id="airChart" class="w-full h-64"></canvas>
                            </div>
                            <div class="w-[50%] mx-auto bg-white p-4 rounded-xl shadow-md">
                                <h1 class="text-xl font-semibold mb-4 text-center">Sound Monitoring Chart</h1>
                                <canvas id="soundChart" class="w-full h-64"></canvas>
                            </div>
                        </div>         
                    </div>
                    <div x-show="activeTab === 'ucc'" x-transition class="flex flex-col h-full w-full justify-center items-center">
                        Content for UCC
                    </div>
                </div>
            </div>
        </div>
            <button id="send-reading-btn">Send Reading</button>

        <!-- Weather Forecast -->
        <div id="weather" class="h-[400px] bg-white flex flex-col justify-center items-center w-full shadow-xl z-0 gap-y-5 border-t-2 border-b-2 border-[#06402b]"></div>
    </div>
@php
  $aqi_value = 100;   
//  np

  //dump($readings);
@endphp

    <script>
        const RECEIVE_URL = @json(route('hardware.receive_data'));
        console.log(RECEIVE_URL)
        document.addEventListener("DOMContentLoaded", () => {
             window.Echo.channel('readings')
                .listen('.reading.received', (e) => {
                console.log('✅ reading.received', e);   // e.reading is your payload
              });

            const btn = document.getElementById("send-reading-btn");
            if (btn) {
                btn.addEventListener("click", async () => {
                                    console.log("sending");

                    try {
                       const res = await fetch("api/receive-data", {   // note: underscore to match your route
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",          // CSRF not needed for routes/api.php
                            },
                            body: JSON.stringify({
                                "hardware_info": 1,
                                "pm2_5": 27.6,
                                "pm10": 45.2,
                                "co": 0.31,
                                "no2": 18.4,
                                "decibels": 62.5,
                                "realtime_stamp": "2025-10-24T09:10:11.123Z"   // or your own timestamp
                            }),
                        });
                     console.log('Reading dispatched! HTTP', res.status);
                    } catch (err) {
                        console.error("Error sending reading:", err);
                    }
                });
            }
        });

        // Initialize map centered on a location
        const map = L.map('map').setView([14.6458, 120.9865], 18);

        // Add OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            // attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OSM</a>'
        }).addTo(map);

        // Add markers
        const locations = [
            {name: 'Barangay 115', coords: [14.6458, 120.9865]},
        ];
        locations.forEach(loc => {
            L.marker(loc.coords).addTo(map).bindPopup(`<b>${loc.name}</b>`);
        });

        // Weather
        document.addEventListener('DOMContentLoaded', () => {
            const city = "Caloocan";
            const lat = 14.6514, lon = 120.97; // coordinates for Caloocan
            let currentUnit = "C"; // default
            let forecastData = null;

            const weatherCodeMap = {
                0:  { text: "Sunny", icon: "https://cdn.weatherapi.com/weather/64x64/day/113.png" },
                1:  { text: "Mainly clear", icon: "https://cdn.weatherapi.com/weather/64x64/day/116.png" },
                2:  { text: "Partly cloudy", icon: "https://cdn.weatherapi.com/weather/64x64/day/119.png" },
                3:  { text: "Cloudy", icon: "https://cdn.weatherapi.com/weather/64x64/day/122.png" },
                45: { text: "Fog", icon: "https://cdn.weatherapi.com/weather/64x64/day/248.png" },
                48: { text: "Freezing fog", icon: "https://cdn.weatherapi.com/weather/64x64/day/260.png" },
                51: { text: "Light drizzle", icon: "https://cdn.weatherapi.com/weather/64x64/day/266.png" },
                53: { text: "Moderate drizzle", icon: "https://cdn.weatherapi.com/weather/64x64/day/296.png" },
                55: { text: "Heavy drizzle", icon: "https://cdn.weatherapi.com/weather/64x64/day/302.png" },
                56: { text: "Freezing drizzle", icon: "https://cdn.weatherapi.com/weather/64x64/day/281.png" },
                57: { text: "Heavy freezing drizzle", icon: "https://cdn.weatherapi.com/weather/64x64/day/284.png" },
                61: { text: "Light rain", icon: "https://cdn.weatherapi.com/weather/64x64/day/308.png" },
                63: { text: "Moderate rain", icon: "https://cdn.weatherapi.com/weather/64x64/day/308.png" },
                65: { text: "Heavy rain", icon: "https://cdn.weatherapi.com/weather/64x64/day/314.png" },
                66: { text: "Light freezing rain", icon: "https://cdn.weatherapi.com/weather/64x64/day/311.png" },
                67: { text: "Heavy freezing rain", icon: "https://cdn.weatherapi.com/weather/64x64/day/314.png" },
                71: { text: "Light snow", icon: "https://cdn.weatherapi.com/weather/64x64/day/332.png" },
                73: { text: "Moderate snow", icon: "https://cdn.weatherapi.com/weather/64x64/day/338.png" },
                75: { text: "Heavy snow", icon: "https://cdn.weatherapi.com/weather/64x64/day/338.png" },
                77: { text: "Snow grains", icon: "https://cdn.weatherapi.com/weather/64x64/day/338.png" },
                80: { text: "Light rain showers", icon: "https://cdn.weatherapi.com/weather/64x64/day/353.png" },
                81: { text: "Moderate rain showers", icon: "https://cdn.weatherapi.com/weather/64x64/day/356.png" },
                82: { text: "Heavy rain showers", icon: "https://cdn.weatherapi.com/weather/64x64/day/359.png" },
                85: { text: "Light snow showers", icon: "https://cdn.weatherapi.com/weather/64x64/day/368.png" },
                86: { text: "Heavy snow showers", icon: "https://cdn.weatherapi.com/weather/64x64/day/371.png" },
                95: { text: "Rain with lightning", icon: "https://cdn.weatherapi.com/weather/64x64/day/386.png" },
                96: { text: "Showers with lightning", icon: "https://cdn.weatherapi.com/weather/64x64/day/389.png" },
                99: { text: "Stormy rain", icon: "https://cdn.weatherapi.com/weather/64x64/day/389.png" }
            };

            const toF = c => (c * 9/5 + 32).toFixed(1);

            async function loadWeather() {
                const url = `https://api.open-meteo.com/v1/forecast?latitude=${lat}&longitude=${lon}&current_weather=true&daily=temperature_2m_max,temperature_2m_min,weathercode&timezone=auto`;
                const res = await fetch(url);
                forecastData = await res.json();
                renderWeather();
            }

            function renderWeather() {
                const container = document.getElementById('weather');
                const daily = forecastData.daily;
                const current = forecastData.current_weather;

                const currentInfo = weatherCodeMap[current.weathercode] || {text:"Unknown",icon:"❓"};
                const currentTemp = currentUnit === "C" ? `${current.temperature}°C` : `${toF(current.temperature)}°F`;

                const todayStr = new Date().toISOString().split('T')[0];

                const cards = daily.time.map((dateStr, i) => {
                    const dateObj = new Date(dateStr);
                    const weekday = dateObj.toLocaleDateString('en-US', { weekday: 'long' });
                    const code = daily.weathercode[i];
                    const info = weatherCodeMap[code] || {text:"Unknown",icon:"❓"};

                    const max = currentUnit === "C" ? `${daily.temperature_2m_max[i]}°C` : `${toF(daily.temperature_2m_max[i])}°F`;
                    const min = currentUnit === "C" ? `${daily.temperature_2m_min[i]}°C` : `${toF(daily.temperature_2m_min[i])}°F`;

                    const highlight = dateStr === todayStr ? 'bg-blue-200' : 'bg-white';

                    return `
                        <div class="flex flex-col justify-between items-center border-2 border-[#06402b] rounded-xl p-5 w-44 text-center shadow-xl hover:scale-105 duration-300 ${highlight}">
                            <span class="font-semibold text-blue-700">${weekday}</span>
                            <span class="text-sm text-gray-500 mb-1">${dateStr}</span>
                            <img src="${info.icon}" alt="icon" class="size-20">
                            <span class="text-red-600">High ${max}</span>
                            <span class="text-blue-600">Low ${min}</span>
                            <span class="text-sm text-gray-600 text-center uppercase">${info.text}</span>
                        </div>
                    `;
                }).join('');

                container.innerHTML = `
                    <div class="flex flex-col justify-center items-center mb-4">
                        <h2 class="text-2xl font-bold text-[#06402b] uppercase">${city}, Philippines</h2>
                        <p class="text-lg text-[#a8a8a8]">( Current: ${currentTemp} – ${currentInfo.text} )</p>
                        <button id="toggleUnit" class="mt-2 bg-green-700 text-white px-3 py-1 rounded-lg hover:bg-green-800 transition">Switch to °${currentUnit === "C" ? "F" : "C"}</button>
                    </div>
                    <div class="flex flex-wrap justify-center gap-4">
                        ${cards}
                    </div>
                `;

                document.getElementById("toggleUnit").addEventListener("click", () => {
                    currentUnit = currentUnit === "C" ? "F" : "C";
                    renderWeather();
                });
            }

            loadWeather();
       });


        // Treshold Slider
        const aqi = {{ $aqi_value }}
        ; // change this dynamically if needed

        const slider   = document.getElementById('aqi-slider');
        const valueEl  = document.getElementById('aqi-value');
        const catEl    = document.getElementById('aqi-category');
        const backColor = document.getElementById('aqi-back');

        const categories = [
        { max: 25, label: 'Good',                        color: 'text-[#00E400] bg-[#00E400]' },
        { max: 35, label: 'Fair',                        color: 'text-[#FFFF00] bg-[#FFFF00]' },
        { max: 45, label: 'Unhealthy for Sensitive',     color: 'text-[#FF7E00] bg-[#FF7E00]' },
        { max: 55, label: 'Very Unhealthy',              color: 'text-[#FF0000] bg-[#FF0000]' },
        { max: 90, label: 'Acutely Unhealthy',           color: 'text-[#8F3F97] bg-[#8F3F97]' },
        { min: 91, label: 'Emergency',                   color: 'text-[#7E0023] bg-[#7E0023]' },
        ];

        // Determine category based on AQI
        const category = categories.find(c => aqi <= c.max) || categories[categories.length - 1];

        // Update UI
        slider.value = aqi;
        valueEl.textContent = aqi;
        catEl.textContent = category.label;
        valueEl.className = `text-7xl font-bold bg-transparent text-center ${category.color}`;
        catEl.className = `text-2xl font-bold p-2 w-[81%] bg-white/20 h-14 flex justify-center items-center text-center rounded-xl ${category.color}`;
        backColor.className = `w-full h-[350px] flex flex-row h-[300px] bg-gradient-to-t from-${category.color} to-white rounded-3xl`;

        // Chart Analysis
        const labels = ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];

        // Air monitoring data
        const airData = {
        labels: labels,
        datasets: [
            {
            label: 'PM2.5 (µg/m³)',
            data: [12, 19, 14, 20, 15, 25, 18],
            borderColor: 'rgb(59,130,246)',
            backgroundColor: 'rgba(59,130,246,0.2)',
            tension: 0.3,
            fill: true
            },
            {
            label: 'PM10 (µg/m³)',
            data: [20, 30, 28, 35, 32, 40, 33],
            borderColor: 'rgb(34,197,94)',
            backgroundColor: 'rgba(34,197,94,0.2)',
            tension: 0.3,
            fill: true
            },
            {
            label: 'CO₂ (ppm)',
            data: [400, 420, 460, 500, 480, 530, 490],
            borderColor: 'rgb(239,68,68)',
            backgroundColor: 'rgba(239,68,68,0.2)',
            tension: 0.3,
            fill: true
            },
            {
            label: 'NO (ppb)',
            data: [15, 18, 22, 25, 20, 28, 24],
            borderColor: 'rgb(168,85,247)',
            backgroundColor: 'rgba(168,85,247,0.2)',
            tension: 0.3,
            fill: true
            }
        ]
        };

        const airConfig = {
        type: 'line',
        data: airData,
        options: {
            responsive: true,
            plugins: {
            legend: { position: 'top' },
            title: { display: true, text: 'Weekly Air Quality' }
            }
        }
        };

        new Chart(document.getElementById('airChart').getContext('2d'), airConfig);

        // Sound monitoring data
        const soundData = {
        labels: labels,
        datasets: [
            {
            label: 'Average dB',
            data: [55, 60, 58, 62, 65, 70, 68],
            borderColor: 'rgb(245,158,11)',
            backgroundColor: 'rgba(245,158,11,0.2)',
            tension: 0.3,
            fill: true
            },
            {
            label: 'Peak dB',
            data: [70, 75, 72, 78, 80, 85, 82],
            borderColor: 'rgb(99,102,241)',
            backgroundColor: 'rgba(99,102,241,0.2)',
            tension: 0.3,
            fill: true
            }
        ]
        };

        const soundConfig = {
        type: 'line',
        data: soundData,
        options: {
            responsive: true,
            plugins: {
            legend: { position: 'top' },
            title: { display: true, text: 'Weekly Sound Levels' }
            },
            scales: {
            y: {
                title: { display: true, text: 'Decibels (dB)' }
            }
            }
        }
        };

        new Chart(document.getElementById('soundChart').getContext('2d'), soundConfig);
    </script>
    
</x-layout>