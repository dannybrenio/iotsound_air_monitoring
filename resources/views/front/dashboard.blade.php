<x-layout>
  <div class="w-full h-auto flex justify-center items-center flex-col bg-white gap-y-5">
    <!-- Maps -->
    <div id="map" class="h-[300px] flex w-full shadow-lg z-0"></div>
    <!-- AQI -->
    <div class="w-[95%] h-auto rounded-3xl flex">
      <div x-data="{ activeTab: 'barangay' }" class="w-full h-full">

<!-- Tab header -->
<div x-data="{ activeTab: 'barangay' }" class="w-full h-full">
  <div class="flex flex-row justify-between h-[50px] w-full">
    {{-- Left: hardware tabs --}}
    <div class="flex flex-row bg-[#eceaea] rounded-t-lg overflow-x-auto">
      @foreach($hardwares as $hw)
        @php $isSelected = $selectedHardwareId === $hw->hardware_id; @endphp

        <a href="{{ route('dashboard', ['hardware' => $hw->public_hash]) }}"
           class="px-4 h-[50px] flex items-center rounded-t-lg cursor-pointer transition-all duration-200 whitespace-nowrap
            {{ $isSelected
              ? 'text-[#06402b] font-semibold bg-white border-t-4 border-[#06402b]'
              : 'text-black border-b border-transparent hover:text-blue-500' }}">
          {{ $hw->location_name ?? $hw->hardware_id }}
        </a>
      @endforeach
    </div>

    {{-- Right: Weather tab --}}
    <button type="button"
            class="w-30 rounded-full cursor-pointer px-4"
            @click="activeTab = 'weather'"
            :class="activeTab === 'weather'
              ? 'text-white font-semibold bg-[#06402b]'
              : 'text-[#06402b] bg-[#eceaea] hover:text-white hover:bg-[#06402b]'">
      Weather
    </button>
  </div>

  {{-- Barangay content --}}
  {{-- <div x-show="activeTab === 'barangay'" x-transition>
    ...
  </div> --}}

  {{-- Weather content --}}
  <div x-show="activeTab === 'weather'" x-transition
       class="flex flex-col h-full w-full justify-center items-center py-3">
    <div id="weather"
         class="h-auto bg-white flex flex-col justify-center rounded-b-2xl items-center w-full shadow-xl z-0 py-10 lg:gap-y-5">
    </div>
  </div>
</div>



        <!-- Tab content -->
        <div class="border border-white rounded-b-3xl h-auto bg-white py-3">
            <div x-show="activeTab === 'barangay'" x-transition
                class="flex flex-col h-auto w-full justify-between items-center gap-y-2">
                <div class="w-[98%] h-[120px] flex flex-row justify-between items-center px-1">
                    <div class="flex flex-col w-full h-auto gap-y-1 items-start justify-center">
                        <div
                          class="w-14 h-4 flex justify-center items-center gap-x-2 bg-red-500 text-black text-center text-xs rounded-md">
                          <span class="text-center">•</span>LIVE
                        </div>
                        <span class="text-black font-bold text-lg tracking-wide uppercase">Air Quality Index | Sound Level</span>
                        <span class="text-[#919090] text-sm italic" id="lastUpdatedLbl">Last Updated: 2025-09-25 06:52:16 PM (Local Time)</span>
                    </div>
                </div>
                <div id="aqi-back" class="">
                  <!--  <div class="absolute flex overflow-hidden whitespace-nowrap w-full h-full">
                            <div class="inline-block animate-marquee w-[200%] h-full">
                                <div class="flex w-full h-full">
                                   
                                    <img src="{{ asset('newcloud1.png') }}" alt="" class="h-full object-cover">
                                    <img src="{{ asset('newcloud1.png') }}" alt="" class="w-1/3 h-full object-cover">
                                    <img src="{{ asset('newcloud1.png') }}" alt="" class="mx-10 w-1/3 h-full object-cover">
    
                                    <img src="{{ asset('newcloud1.png') }}" alt="" class="mx-10 w-1/3 h-full object-cover">
                                    <img src="{{ asset('newcloud1.png') }}" alt="" class="mx-10 w-1/3 h-full object-cover">
                                    <img src="{{ asset('newcloud1.png') }}" alt="" class="mx-10 w-1/3 h-full object-cover">
                                </div>
                            </div>
                        </div> -->
                  <div class="w-full lg:w-[48%] flex flex-col h-full justify-center items-center gap-y-6 z-10">
                <div class="flex items-center justify-center flex-row w-[90%] lg:w-[80%]">
                  <div class="flex flex-col w-[45%] lg:w-[30%] items-center justify-center lg:gap-y-0 gap-y-3">
                    <div class="flex flex-row gap-x-2 items-center">
                      <div class="w-4 h-4 rounded-full bg-red-600 animate-pulse duration-100">
                      </div>
                      <span class="text-sm font-semibold">Live AQI</span>
                    </div>
                    <span id="aqi-value">0</span>
                  </div>
                  <div class="flex flex-col w-[55%] lg:w-[70%] gap-y-2 justify-center items-center">
                    <span class="text-sm font-semibold">Air Quality is</span>
                    <span id="aqi-category">Good</span>
                  </div>
                  <div class="flex flex-col w-[45%] lg:w-[30%] items-center justify-center lg:gap-y-0 gap-y-3">
                    <div class="flex flex-row gap-x-2 items-center">
                      <span class="text-sm font-semibold">Predictive AQI</span>
                    </div>
                    <span id="aqiPredictionMarquee" class="text-5xl lg:text-7xl font-bold"></span>
                  </div>
                </div>
                <div class="w-[90%] lg:w-[80%] h-auto flex mt-10">
                  <div class="relative w-full max-w-3xl mx-auto">

                    <!-- Top Numeric Range Labels -->
                    <div class="absolute -top-5 left-0 w-full flex text-[10px] font-semibold text-gray-700">
                      <span class="text-center truncate" style="width:10%;">0–50</span>
                      <span class="text-center truncate" style="width:10%;">51–100</span>
                      <span class="text-center truncate" style="width:10%;">101–150</span>
                      <span class="text-center truncate" style="width:10%;">151–200</span>
                      <span class="text-center truncate" style="width:20%;">201–300</span>
                      <span class="text-center truncate" style="width:40%;">301–500</span>
                    </div>

                    <!-- Slider -->
                    <input id="aqi-slider" type="range" min="0" max="500" value="0" disabled
                      class="w-full h-3 rounded-lg appearance-none border border-[#FFFFFF]" style="
                                        background: linear-gradient(
                                          to right,
                                          #00E400 0%,   #00E400 10%,
                                          #FFFF00 10%,  #FFFF00 20%,
                                          #FF7E00 20%,  #FF7E00 30%,
                                          #FF0000 30%,  #FF0000 40%,
                                          #8F3F97 40%,  #8F3F97 60%,
                                          #7E0023 60%,  #7E0023 100%
                                        );
                                    ">

                    <!-- Bottom Category Labels -->
                    <div class="absolute top-7 left-0 w-full flex text-xs font-semibold text-gray-700">
                      <span class="text-center truncate" style="width:10%;">Good</span>
                      <span class="text-center truncate" style="width:10%;">Fair</span>
                      <span class="text-center truncate" style="width:10%;">Poor</span>
                      <span class="text-center truncate" style="width:10%;">Unhealthy</span>
                      <span class="text-center truncate" style="width:25%;">Acutely Unhealthy</span>
                      <span class="text-center truncate" style="width:30%;">Emergency</span>
                    </div>

                  </div>
                </div>

                <div class="flex flex-row justify-evenly w-[90%] lg:w-[80%] mt-6">
                  <span class="text-center text-sm text-black font-bold">PM2.5: <span class="text-black font-normal"
                      id="pm2Label">16 µg/m³</span></span>
                  <div class="h-4 border border-white"></div>
                  <span class="text-center text-sm text-black font-bold">PM10: <span class="text-black font-normal"
                      id="pm10Label">18 µg/m³</span></span>
                  <div class="h-4 border border-white"></div>
                  <span class="text-center text-sm text-black font-bold">CO: <span class="text-black font-normal"
                      id="coLabel">62 ppm</span></span>
                  <div class="h-4 border border-white"></div>
                  <span class="text-center text-sm text-black font-bold">NO₂: <span class="text-black font-normal"
                      id="noLabel">7 ppb</span></span>
                </div>

              </div>
              <div class="w-full lg:w-[48%] flex flex-row h-full justify-center items-center gap-x-2 z-10">
                <div
                  class="flex flex-row bg-white/70 border border-white w-[90%] h-[90%] lg:h-[50%] rounded-xl items-center justify-evenly">
                  <div class="w-[30%] h-full flex flex-col items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14 lg:h-24 lg:w-24 animate-pulse duration-100 text-black" viewBox="0 0 512 512"><path fill="# 000000" d="M468.53 236.03H486v39.94h-17.47v-39.94zm-34.426 51.634h17.47v-63.328h-17.47v63.328zm-33.848 32.756h17.47V191.58h-17.47v128.84zm-32.177 25.276h17.47V167.483h-17.47v178.17zm-34.448-43.521h17.47v-92.35h-17.47v92.35zm-34.994 69.879h17.47v-236.06h-17.525v236.06zM264.2 405.9h17.47V106.1H264.2v299.8zm-33.848-46.284h17.47V152.383h-17.47v207.234zm-35.016-58.85h17.47v-87.35h-17.47v87.35zm-33.847-20.823h17.47V231.98h-17.47v48.042zm-33.848 25.66h17.47v-99.24h-17.47v99.272zm-33.302 48.04h17.47V152.678H94.34v201zm-33.847-30.702h17.47V187.333h-17.47v135.642zM26 287.664h17.47v-63.328H26v63.328z"/>
                    </svg>
                  </div>
                  <div class="h-full border border-white"></div>
                  <div class="w-[60%] h-full flex flex-col items-center justify-center">
                    <div
                      class="flex flex-row w-full h-[40%] lg:h-[50%] justify-center items-center gap-x-2 lg:gap-x-5 px-1">
                      <span class="text-black font-semibold text-sm lg:text-xl uppercase">Sound Level</span>
                      <span class="text-blue-500 font-bold text-xl lg:text-4xl" id="latestDbLbl">20<span
                          class="text-xs lg:text-lg text-black">db</span></span>
                    </div>
                    <div class="w-full border border-white"></div>
                    <div class="flex flex-col w-full h-[60%] lg:h-[50%] justify-evenly items-center py-3">
                      <div class="flex w-full h-auto justify-center items-center">
                        <span class="text-gray-500 text-xs italic" id="asOfLbl">As of this Date:
                          2025-09-25</span>
                      </div>
                      <div class="flex flex-col md:flex-row w-full h-auto justify-evenly items-center">
                        <div class="w-full justify-center items-center flex flex-row gap-x-3">
                          <span class="text-xs lg:text-base text-center font-semibold uppercase">Average
                            dB:</span>
                          <span class="text-xl text-center font-bold text-green-600" id="avgDbLbl">20</span>
                        </div>
                        <div class="w-[50%] h-0 md:w-0 md:h-[50%] border border-white"></div>
                        <div class="w-full justify-center items-center flex flex-row gap-x-3">
                          <span class="text-xs lg:text-base text-center font-semibold uppercase">Peak
                            dB:</span>
                          <span class="text-xl text-center font-bold text-red-600" id="peakDbLbl">20</span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="h-full border border-white"></div>
                  <div class="flex flex-col w-[10%] h-[40%] lg:h-[50%] justify-center items-center gap-y-2 lg:gap-x-5">
                    <span class="text-black font-semibold text-sm lg:text-lg uppercase text-center w-[70%]">Predictive Sound Level</span>
                    <span class="font-bold text-xl lg:text-3xl" id="noisePredictionMarquee">20</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="w-full h-auto mx-auto bg-white p-4 rounded-xl shadow-md">
              <div class="flex flex-col md:flex-row justify-between items-center lg:px-5">
                <h1 class="text-xl font-semibold mb-4 text-center">Air Monitoring Chart</h1>
                <div class="flex flex-row gap-x-5">
                  <!-- Time range dropdown -->
                  <div class="mb-4 text-center">
                    <select id="aqiTimeSelect"
                      class="border border-[#06402b] rounded-md p-2 text-sm text-[#06402b] focus:ring-0 focus:outline-none cursor-pointer">
                      <option value="12h">12 Hrs</option>
                      <option value="24h">24 Hrs</option>
                      <option value="7d">7 Days</option>
                      <option value="30d">30 Days</option>
                    </select>
                  </div>
                  <!-- Pollutant dropdown (NO Alpine binding) -->
                  <div class="mb-4 text-center">
                    <select id="gasSelect"
                      class="border border-[#06402b] text-[#06402b] rounded-md p-2 text-sm focus:ring-0 focus:outline-none cursor-pointer">
                      <option value="all">All</option>
                      <option value="pm2">PM 2.5</option>
                      <option value="pm10">PM 10</option>
                      <option value="co">CO</option>
                      <option value="no">NO₂</option>
                    </select>
                  </div>
                </div>
              </div>
              <!-- Single canvas only -->
              <canvas id="airChart" height="400" class="w-full"></canvas>
            </div>
            <div class="w-full h-auto mx-auto bg-white p-4 rounded-xl shadow-md">
              <div class="flex flex-col md:flex-row justify-between items-center lg:px-5">
                <h1 class="text-xl font-semibold mb-4 text-center">Sound Monitoring Chart</h1>
                <div class="flex flex-row gap-x-5">
                  <div class="mb-4 text-center">
                    <select id="timeRangeSelect"
                      class="border border-[#06402b] rounded-md p-2 text-sm text-[#06402b] focus:ring-0 focus:outline-none cursor-pointer">
                      <option class="text-start" value="12h">12 Hrs</option>
                      <option class="text-start" value="24h">24 Hrs</option>
                      <option class="text-start" value="7d">7 Days</option>
                      <option class="text-start" value="30d">30 Days</option>
                    </select>
                  </div>
                </div>
              </div>
              <canvas id="soundChart" height="400" class="w-full"></canvas>
            </div>
          </div>
          <!-- <div x-data="{ open: false }" class="flex flex-col mt-1 bg-white w-full gap-y-3 mb-3">
                            <div x-show="open" x-transition class="flex flex-col gap-y-2">
                                <div class="w-full h-auto lg:h-[400px] flex flex-col lg:flex-row gap-y-3 gap-x-3">
                                    <div class="w-full lg:w-[50%] mx-auto bg-white p-4 rounded-xl shadow-md">
                                        <h1 class="text-xl font-semibold mb-4 text-center">PM 2.5 Chart</h1>
                                        <canvas id="pmTwoChart1" class="w-full h-64"></canvas>
                                    </div>
                                    <div class="w-full lg:w-[50%] mx-auto bg-white p-4 rounded-xl shadow-md">
                                        <h1 class="text-xl font-semibold mb-4 text-center">PM 10 Chart</h1>
                                        <canvas id="pmTenChart1" class="w-full h-64"></canvas>
                                    </div>
                                </div>
                                <div class="w-full h-auto lg:h-[400px] flex flex-col lg:flex-row gap-y-3 gap-x-3">
                                    <div class="w-full lg:w-[50%] mx-auto bg-white p-4 rounded-xl shadow-md">
                                        <h1 class="text-xl font-semibold mb-4 text-center">CO Chart</h1>
                                        <canvas id="coChart1" class="w-full h-64"></canvas>
                                    </div>
                                    <div class="w-full lg:w-[50%] mx-auto bg-white p-4 rounded-xl shadow-md">
                                        <h1 class="text-xl font-semibold mb-4 text-center">NO₂ Chart</h1>W
                                        <canvas id="noChart1" class="w-full h-64"></canvas>
                                    </div>
                                </div>
                            </div>
                            <button
                                class="flex w-auto gap-x-2 justify-center items-center h-10 text-left text-[#06402b]">
                                <span @click="open = !open"
                                    class="uppercase font-bold cursor-pointer group hover:text-blue-500">See more data
                                    <i x-show="!open"
                                        class="fa-chevron-down fa-solid text-[#06402b] group-hover:text-blue-500"></i>
                                    <i x-show="open"
                                        class="fa-solid fa-chevron-up text-[#06402b] group-hover:text-blue-500"></i>
                                </span>
                            </button>
                        </div> -->
        </div>
        <div x-show="activeTab === 'ucc'" x-transition class="flex flex-col h-full w-full justify-center items-center">
          Content for UCC
        </div>
        <!-- Weather -->
        <div x-show="activeTab === 'weather'" x-transition
          class="flex flex-col h-full w-full justify-center items-center py-3">
          <div id="weather"
            class="h-auto bg-white flex flex-col justify-center rounded-b-2xl items-center w-full shadow-xl z-0 py-10 lg:gap-y-5">
          </div>
        </div>
      </div>
    </div>
  </div>
  <button id="send-reading-btn" hidden>Send Reading</button>
  <!--<button id="send-status-btn">Send Status</button>-->
  <!-- Weather Forecast -->
  <!-- <div id="weather"
            class="h-auto bg-white flex flex-col justify-center items-center w-full shadow-xl z-0 py-5 lg:gap-y-5 border-t-2 border-b-2 border-[#06402b]">
        </div> -->
  </div>

  <script>
    /* =========================
    * SEGMENTS FROM CONTROLLER
    * ========================= */
    const seg12h = @json($seg12h);
    const seg24h = @json($seg24h);
    const seg7d = @json($seg7d);
    const seg30d = @json($seg30d);
    // console.table(seg12h);
    /* ---------- ordering & labels (use server labels/timestamps) ---------- */
    const byStart = (a, b) => new Date(a.start) - new Date(b.start);
    const fmtTime = iso =>
      new Date(iso).toLocaleTimeString('en-US', {
        hour: '2-digit',
        minute: '2-digit',
        hour12: true,          // ✅ force AM/PM
      });
    const fmtDate = iso => new Date(iso).toLocaleDateString('en-CA'); // YYYY-MM-DD


    const sorted12h = seg12h.slice().sort(byStart);
    const sorted24h = seg24h.slice().sort(byStart);
    const sorted7d = seg7d.slice().sort(byStart);
    const sorted30d = seg30d.slice().sort(byStart);

    // console.table(sorted12h);

    /* ✅ CHANGED: build labels directly from the segments */
    const labels12h = sorted12h.map(s => s.label || fmtTime(s.start));
    const labels24hRaw = sorted24h.map(s => s.label || fmtTime(s.start));  // ✅ AM/PM
    const labels7d = sorted7d.map(s => s.label || fmtDate(s.start));
    const labels30d = sorted30d.map(s => s.label || fmtDate(s.start));

    /* =========================
    * “TODAY” CARDS / LABELS
    * ========================= */
    const latestAqi = @json($latest_aqi);
    const latestNowcast = @json($latest_nowcast);
    const latestDateTime = @json($latest_datetime);
    const latestDecibel = Math.floor(@json($latest_decibel));
    const peakDecibel = Math.floor(@json($peak_decibel));
    const averageDecibel = Math.floor(@json($avgDecibelToday));
    const latestVals = @json($latest_vals);
    
    const selectedHardware = @json($selectedHardware);
    const selectedLat = Number(@json($selectedLat));
    const selectedLon = Number(@json($selectedLon));
    const selectedHardwareId = @json($selectedHardwareId);
    // console.table(latestVals);
      console.log(selectedHardwareId);
    document.addEventListener('DOMContentLoaded', () => {
      // Format a value with unit; show an em dash if null/undefined/NaN
      const fmt = (v, unit) => (v == null || Number.isNaN(v) ? '—' : `${Math.floor(Number(v))} ${unit}`);

      // ---- Last Updated (date + time with AM/PM) ----
      let formatted = '—';
      if (typeof latestDateTime === 'string' && latestDateTime.trim()) {
        // Make "YYYY-MM-DD HH:mm:ss" ISO-like for safe parsing
        const dt = new Date(latestDateTime.replace(' ', 'T'));
        if (!Number.isNaN(dt.getTime())) {
          formatted = dt.toLocaleString('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric',
            hour: 'numeric',
            minute: '2-digit',
            second: '2-digit',
            hour12: true
          });
        }
      }

      const lastUpdatedEl = document.getElementById('lastUpdatedLbl');
      if (lastUpdatedEl) lastUpdatedEl.textContent = formatted;
      // ---- Pollutant labels (match your HTML IDs) ----

    //   console.table(latestNowcast);

      const pairs = [
        ['pm2Label', latestVals?.pm2_5, 'µg/m³'],
        ['pm10Label', latestVals?.pm10, 'µg/m³'],
        ['coLabel', latestVals?.co, 'ppm'],
        ['noLabel', latestVals?.no2, 'ppb'],
      ];
      for (const [id, value, unit] of pairs) {
        const el = document.getElementById(id);
        if (el) el.textContent = fmt(value, unit);
      }

      // ---- Decibel labels ----
      const dbLbl = document.getElementById('latestDbLbl');
      if (dbLbl) dbLbl.textContent = (latestDecibel == null || isNaN(latestDecibel)) ? '—' : `${Math.floor(latestDecibel)} dB`;

      const avgEl = document.getElementById('avgDbLbl');
      if (avgEl) avgEl.textContent = (averageDecibel == null || isNaN(averageDecibel)) ? '—' : Math.floor(averageDecibel);

      const peakEl = document.getElementById('peakDbLbl');
      if (peakEl) peakEl.textContent = (peakDecibel == null || isNaN(peakDecibel)) ? '—' : Math.floor(peakDecibel);

      // ---- "As of this Date" (date only) ----
      const asOfEl = document.getElementById('asOfLbl');
      if (asOfEl) {
        let dateText = '—';
        if (typeof latestDateTime === 'string' && latestDateTime.trim()) {
          const dt = new Date(latestDateTime.replace(' ', 'T'));
          if (!Number.isNaN(dt.getTime())) {
            dateText = dt.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
          }
        }
        asOfEl.textContent = `As of this Date: ${dateText}`;
      }

      // ---- Debug logs (optional) ----
    //   if (typeof latestAqi !== 'undefined') // console.log('Latest AQI:', latestAqi);
    });
    /* =========================
    * MAP
    * ========================= */
    const map = L.map('map').setView([selectedLat, selectedLon], 18);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      minZoom: 15,
      maxZoom: 18
    }).addTo(map);

    const marker = L.marker([selectedLat, selectedLon]).addTo(map);

    const markerName =
      selectedHardware?.location_name
      ?? selectedHardware?.hardware_id
      ?? 'Selected Location';

    marker.bindPopup(`<b>${markerName}</b>`).openPopup();

    /* =========================
    * WEATHER (unchanged)
    * ========================= */
    document.addEventListener('DOMContentLoaded', () => {
      const city =
        selectedHardware?.location_name
        ?? selectedHardware?.hardware_id
        ?? "Selected Location";

      const lat = selectedLat;
      const lon = selectedLon;

      let currentUnit = "C";
      let forecastData = null;

      const weatherCodeMap = {
        0: { text: "Sunny", icon: "https://cdn.weatherapi.com/weather/64x64/day/113.png" },
        1: { text: "Mainly clear", icon: "https://cdn.weatherapi.com/weather/64x64/day/116.png" },
        2: { text: "Partly cloudy", icon: "https://cdn.weatherapi.com/weather/64x64/day/119.png" },
        3: { text: "Cloudy", icon: "https://cdn.weatherapi.com/weather/64x64/day/122.png" },
        45: { text: "Fog", icon: "https://cdn.weatherapi.com/weather/64x64/day/248.png" },
        48: { text: "Freezing fog", icon: "https://cdn.weatherapi.com/weather/64x64/day/260.png" },
        51: { text: "Light drizzle", icon: "https://cdn.weatherapi.com/weather/64x64/day/266.png" },
        53: { text: "Moderate drizzle", icon: "https://cdn.weatherapi.com/weather/64x64/day/296.png" },
        55: { text: "Heavy drizzle", icon: "https://cdn.weatherapi.com/weather/64x64/day/302.png" },
        56: { text: "Light freezing rain", icon: "https://cdn.weatherapi.com/weather/64x64/day/311.png" },
        57: { text: "Heavy freezing rain", icon: "https://cdn.weatherapi.com/weather/64x64/day/314.png" },
        61: { text: "Light rain", icon: "https://cdn.weatherapi.com/weather/64x64/day/308.png" },
        63: { text: "Moderate rain", icon: "https://cdn.weatherapi.com/weather/64x64/day/308.png" },
        65: { text: "Heavy rain", icon: "https://cdn.weatherapi.com/weather/64x64/day/314.png" },
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

      const toF = c => (c * 9 / 5 + 32).toFixed(1);

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
        theInfo = weatherCodeMap[current.weathercode] || { text: "Unknown", icon: "❓" };
        const currentTemp = currentUnit === "C" ? `${current.temperature}°C` : `${toF(current.temperature)}°F`;
        const todayStr = new Date().toISOString().split('T')[0];

        const cards = daily.time.map((dateStr, i) => {
          const weekday = new Date(dateStr).toLocaleDateString('en-US', { weekday: 'long' });
          const info = weatherCodeMap[daily.weathercode[i]] || { text: "Unknown", icon: "❓" };
          const max = currentUnit === "C" ? `${daily.temperature_2m_max[i]}°C` : `${toF(daily.temperature_2m_max[i])}°F`;
          const min = currentUnit === "C" ? `${daily.temperature_2m_min[i]}°C` : `${toF(daily.temperature_2m_min[i])}°F`;
          const highlight = dateStr === todayStr ? 'bg-[#E0EBDC]' : 'bg-white';
          return `
            <div class="flex flex-col justify-between items-center border-2 border-[#06402b] rounded-xl p-5 w-40 text-center shadow-xl hover:scale-105 duration-300 ${highlight}">
              <span class="font-bold text-[#06402b]">${weekday}</span>
              <span class="text-sm text-gray-500 mb-1">${dateStr}</span>
              <img src="${info.icon}" alt="icon" class="size-20">
              <span class="text-red-600">High ${max}</span>
              <span class="text-blue-600">Low ${min}</span>
              <span class="text-sm text-gray-600 text-center uppercase">${info.text}</span>
            </div>
          `;
        }).join('');

        container.innerHTML = `
          <div class="flex flex-col justify-center items-center mb-5 lg:mb-1">
            <h2 class="text-2xl font-bold text-[#06402b] uppercase">${city}, Philippines</h2>
            <p class="text-lg text-[#a8a8a8]">( Current: ${currentTemp} – ${theInfo.text} )</p>
            <button id="toggleUnit" class="mt-2 bg-green-700 text-white px-3 py-1 rounded-lg hover:bg-green-800 transition">
              Switch to °${currentUnit === "C" ? "F" : "C"}
            </button>
          </div>
          <div class="flex flex-wrap justify-center gap-4">${cards}</div>
        `;

        document.getElementById("toggleUnit").addEventListener("click", () => {
          currentUnit = currentUnit === "C" ? "F" : "C";
          renderWeather();
        });
      }
      loadWeather();
    });

    /* =========================
    * AQI SLIDER / CATEGORY
    * ========================= */
    const slider = document.getElementById('aqi-slider');
    const valueEl = document.getElementById('aqi-value');
    const catEl = document.getElementById('aqi-category');
    const backColor = document.getElementById('aqi-back');

    const categories = [
      { max: 50, label: 'Good', color: 'text-[#00E400] bg-[#00E400]' },
      { max: 100, label: 'Fair', color: 'text-[#FFC000] bg-[#FFFF00]' },
      { max: 150, label: 'Poor', color: 'text-[#FF7E00] bg-[#FF7E00]' },
      { max: 200, label: 'Unhealthy', color: 'text-[#FF0000] bg-[#FF0000]' },
      { max: 300, label: 'Acutely Unhealthy', color: 'text-[#8F3F97] bg-[#8F3F97]' },
      { min: 301, label: 'Emergency', color: 'text-[#7E0023] bg-[#7E0023]' },
    ];

    const category = categories.find(c => latestAqi <= c.max) || categories[categories.length - 1];
    slider.value = Math.floor(latestAqi);
    valueEl.textContent = Math.floor(latestAqi);
    catEl.textContent = category.label;
    valueEl.className = `text-5xl lg:text-7xl font-bold bg-transparent text-center ${category.color}`;
    catEl.className = `text-lg lg:text-2xl font-bold p-2 w-[81%] bg-white/20 h-14 flex justify-center items-center text-center rounded-xl ${category.color}`;
    backColor.className = `w-full h-[500px] lg:h-[350px] relative flex flex-col lg:flex-row bg-gradient-to-t from-${category.color} to-white rounded-3xl gap-y-5 py-5 lg:py-0 shadow-lg`;

    /* =========================
    * CHARTS: single canvas (airChart)
    * ========================= */
    const toNum = v => (v == null ? null : Math.floor(v));

    function buildDataset(segments) {
      return {
        pm2: segments.map(s => toNum(s.pm2_5)),
        pm10: segments.map(s => toNum(s.pm10)),
        co: segments.map(s => toNum(s.co)),
        no: segments.map(s => toNum(s.no2)),
      };
    }

    const aqiDataSets = {
      "12h": buildDataset(sorted12h),
      "24h": buildDataset(sorted24h),
      "7d": buildDataset(sorted7d),
      "30d": buildDataset(sorted30d),
    };

    function emptyLineChart(ctx, title) {
      return new Chart(ctx, {
        type: 'line',
        data: {
          labels: [],
          datasets: [
            { label: 'PM2.5 (µg/m³)', data: [], borderColor: 'rgb(59,130,246)', backgroundColor: 'rgba(59,130,246,0.2)', tension: 0.3, fill: true },
            { label: 'PM10 (µg/m³)', data: [], borderColor: 'rgb(34,197,94)', backgroundColor: 'rgba(34,197,94,0.2)', tension: 0.3, fill: true },
            { label: 'CO (ppm)', data: [], borderColor: 'rgb(239,68,68)', backgroundColor: 'rgba(239,68,68,0.2)', tension: 0.3, fill: true },
            { label: 'NO₂ (ppb)', data: [], borderColor: 'rgb(168,85,247)', backgroundColor: 'rgba(168,85,247,0.2)', tension: 0.3, fill: true }
          ]
        },
        options: {
          responsive: false,
          spanGaps: true,
          animation: { duration: 600, easing: 'easeInOutQuart' },
          plugins: {
            legend: {
                onClick: null,
                position: 'top',
                labels: {
                filter: (legendItem, chartOrData) => {
                  const chart = chartOrData && chartOrData.config ? chartOrData : null;
                  if (chart && typeof chart.getDatasetMeta === 'function') {
                    const meta = chart.getDatasetMeta(legendItem.datasetIndex);
                    if (meta && typeof meta.hidden !== 'undefined') return meta.hidden !== true;
                  }
                  if (typeof legendItem.hidden !== 'undefined') return legendItem.hidden !== true;
                  const dsList = chartOrData?.datasets || chart?.data?.datasets || [];
                  const ds = dsList[legendItem.datasetIndex];
                  return !(ds && ds.hidden === true);
                },
              },
            },
            title: { display: true, text: title }
          },
          scales: { y: { beginAtZero: true } }
        }
      });
    }

    const airChart = emptyLineChart(document.getElementById('airChart').getContext('2d'), 'Air Quality');

    /* =========================
    * SOUND CHART
    * ========================= */
    function buildSoundDs(segments) {
      return {
        avg_decibel: segments.map(s => toNum(s.avg_decibel)),
        peak_decibel: segments.map(s => toNum(s.peak_decibel))
      };
    }
    const soundChart = new Chart(document.getElementById('soundChart').getContext('2d'), {
      type: 'line',
      data: {
        labels: [], datasets: [
          { label: 'Average dB', data: [], borderColor: 'rgb(245,158,11)', backgroundColor: 'rgba(245,158,11,0.2)', tension: 0.3, fill: true },
          { label: 'Peak dB', data: [], borderColor: 'rgb(99,102,241)', backgroundColor: 'rgba(99,102,241,0.2)', tension: 0.3, fill: true }
        ]
      },
      options: {
        responsive: false,
        spanGaps: true,
        animation: { duration: 600, easing: 'easeInOutQuart' },
        plugins: { legend: {onClick: null, position: 'top' }, title: { display: true, text: 'Sound Levels' } },
        scales: { y: { beginAtZero: true } } 
      }
    });

    /* =========================
    * BUFFERS (now driven by segment labels)
    * ========================= */

    /* ✅ CHANGED: coerce 24h to 12 × 2h buckets (and give matching labels) */
    function coerceTo2Hour(arrValues, arrLabels) {
      // if already 12 points, just pass through
      if (arrValues.length === 12 && arrLabels.length === 12) return { values: arrValues.map(toNum), labels: arrLabels };

      // if 24 points, average pairs and keep the *second* label (e.g., "02:31 AM" for 01–02 bucket)
      if (arrValues.length === 24 && arrLabels.length === 24) {
        const values = [];
        const labels = [];
        for (let i = 0; i < 24; i += 2) {
          const a = toNum(arrValues[i]), b = toNum(arrValues[i + 1]);
          const v = (a == null && b == null) ? null : Math.round(((a ?? b) + (b ?? a)) / (a != null && b != null ? 2 : 1));
          values.push(v);
          labels.push(arrLabels[i + 1]); // use the latter slot's label so it matches the UI table you logged
        }
        return { values, labels };
      }

      // fallback: trim/pad
      const v = arrValues.map(toNum);
      const lbl = arrLabels.slice();
      while (v.length < 12) v.unshift(null);
      while (lbl.length < 12) lbl.unshift('');
      return { values: v.slice(-12), labels: lbl.slice(-12) };
    }

    /* Seed “live” buffers using server data (labels come from segments) */
    const live = {
      "12h": {
        labels: labels12h.slice(),
        pm2: sorted12h.map(s => toNum(s.pm2_5)),
        pm10: sorted12h.map(s => toNum(s.pm10)),
        co: sorted12h.map(s => toNum(s.co)),
        no: sorted12h.map(s => toNum(s.no2)),
        avgDb: sorted12h.map(s => toNum(s.avg_decibel)),
        peakDb: sorted12h.map(s => toNum(s.peak_decibel)),
      },
      "24h": (() => {
        const pm2R = sorted24h.map(s => s.pm2_5);
        const pm10R = sorted24h.map(s => s.pm10);
        const coR = sorted24h.map(s => s.co);
        const noR = sorted24h.map(s => s.no2);
        const avgR = sorted24h.map(s => s.avg_decibel);
        const peakR = sorted24h.map(s => s.peak_decibel);

        const cPm2 = coerceTo2Hour(pm2R, labels24hRaw);
        const cPm10 = coerceTo2Hour(pm10R, labels24hRaw);
        const cCo = coerceTo2Hour(coR, labels24hRaw);
        const cNo = coerceTo2Hour(noR, labels24hRaw);
        const cAvg = coerceTo2Hour(avgR, labels24hRaw);
        const cPeak = coerceTo2Hour(peakR, labels24hRaw);

        return {
          labels: cPm2.labels, // same across all coerced series
          pm2: cPm2.values,
          pm10: cPm10.values,
          co: cCo.values,
          no: cNo.values,
          avgDb: cAvg.values,
          peakDb: cPeak.values
        };
      })(),
    };

    /* Static buffers (daily) */
    const staticBuf = {
      "7d": {
        labels: labels7d.slice(),
        pm2: sorted7d.map(s => toNum(s.pm2_5)),
        pm10: sorted7d.map(s => toNum(s.pm10)),
        co: sorted7d.map(s => toNum(s.co)),
        no: sorted7d.map(s => toNum(s.no2)),
        avgDb: sorted7d.map(s => toNum(s.avg_decibel)),
        peakDb: sorted7d.map(s => toNum(s.peak_decibel)),
      },
      "30d": {
        labels: labels30d.slice(),
        pm2: sorted30d.map(s => toNum(s.pm2_5)),
        pm10: sorted30d.map(s => toNum(s.pm10)),
        co: sorted30d.map(s => toNum(s.co)),
        no: sorted30d.map(s => toNum(s.no2)),
        avgDb: sorted30d.map(s => toNum(s.avg_decibel)),
        peakDb: sorted30d.map(s => toNum(s.peak_decibel)),
      }
    };

    function renderFromBuffer(rangeKey, chartKind) {
      const src = live[rangeKey] ?? staticBuf[rangeKey];
      if (!src) return;

      if (chartKind === "air") {
        airChart.data.labels = src.labels.slice();
        airChart.data.datasets[0].data = src.pm2.slice();
        airChart.data.datasets[1].data = src.pm10.slice();
        airChart.data.datasets[2].data = src.co.slice();
        airChart.data.datasets[3].data = src.no.slice();
        airChart.update({ duration: 300, easing: 'easeOutQuad' });
      } else {
        soundChart.data.labels = src.labels.slice();
        soundChart.data.datasets[0].data = src.avgDb.slice();
        soundChart.data.datasets[1].data = src.peakDb.slice();
        soundChart.update({ duration: 300, easing: 'easeOutQuad' });
      }
    }

    /* Initial render */
    renderFromBuffer("12h", "air");
    renderFromBuffer("12h", "sound");

    /* =========================
    * RANGE DROPDOWNS
    * ========================= */
    function setRangeAndRender(val, type) {
      if (!(val === "12h" || val === "24h" || val === "7d" || val === "30d")) return;

      const chart = type === "air" ? airChart : soundChart;
      const canvas = chart.canvas || chart.ctx?.canvas;

      canvas.style.transition = 'opacity 150ms ease-in-out';
      canvas.style.opacity = '0';

      setTimeout(() => {
        renderFromBuffer(val, type);
        canvas.style.transition = 'opacity 200ms ease-in-out';
        canvas.style.opacity = '1';
      }, 150);
    }

    document.getElementById("aqiTimeSelect")?.addEventListener("change", function () {
      setRangeAndRender(this.value, "air");
    });
    document.getElementById("timeRangeSelect")?.addEventListener("change", function () {
      setRangeAndRender(this.value, "sound");
    });

    /* =========================
    * GAS FILTER (single-canvas)
    * ========================= */
    const DATASET_INDEX = { pm2: 0, pm10: 1, co: 2, no: 3 };
    const GAS_CHOICE_MAP = {
      "all": new Set(["pm2", "pm10", "co", "no"]),
      "pm2": new Set(["pm2"]),
      "pm10": new Set(["pm10"]),
      "co": new Set(["co"]),
      "no": new Set(["no"]),
    };

    function fadeUpdate(chart, updater, {
      fadeOutMs = 180,
      fadeInMs = 220,
      updateMs = 500,
      easing = 'ease-in-out'
    } = {}) {
      const canvas = chart.canvas || chart.ctx?.canvas;
      if (!canvas) { updater(); chart.update(); return; }
      canvas.style.transition = `opacity ${fadeOutMs}ms ${easing}`;
      canvas.style.opacity = '0';
      setTimeout(() => {
        updater();
        chart.update({ duration: updateMs, easing: 'easeInOutCubic' });
        canvas.style.transition = `opacity ${fadeInMs}ms ${easing}`;
        canvas.style.opacity = '1';
      }, fadeOutMs);
    }

    function applyGasFilter(choice) {
      const show = GAS_CHOICE_MAP[choice] ?? GAS_CHOICE_MAP["all"];
      const rangeKey = document.getElementById("aqiTimeSelect")?.value || "12h";
      const src = live[rangeKey] ?? staticBuf[rangeKey];
      if (!src) return;

      const dataMap = { pm2: src.pm2, pm10: src.pm10, co: src.co, no: src.no };
      const doUpdate = () => {
        Object.entries(DATASET_INDEX).forEach(([key, idx]) => {
          const visible = show.has(key);
          if (typeof airChart.setDatasetVisibility === 'function') airChart.setDatasetVisibility(idx, visible);
          const ds = airChart.data.datasets[idx];
          if (ds) ds.hidden = !visible;
          const meta = airChart.getDatasetMeta?.(idx);
          if (meta) meta.hidden = !visible;
          airChart.data.datasets[idx].data = (dataMap[key] ?? []).slice();
        });
        const labelMap = { all: "Air Quality", pm2: "PM2.5 (µg/m³)", pm10: "PM10 (µg/m³)", co: "CO (ppm)", no: "NO₂ (ppb)" };
        airChart.options.plugins.title.text = labelMap[choice] ?? "Air Quality";
      };

      fadeUpdate(airChart, doUpdate, { fadeOutMs: 150, fadeInMs: 200, updateMs: 450 });
    }

    (function initGasFilter() {
      const dd = document.getElementById("gasSelect");
      if (!dd) return;
      applyGasFilter(dd.value);
      dd.addEventListener("change", () => applyGasFilter(dd.value));
    })();

    /* =========================
    * ECHO + LIVE UPDATES (append using segment-style label)
    * ========================= */
    const AQI_BANDS = [
      { max: 50.0, label: 'Good', hex: '#00E400', bg: '#00E400' },
      { max: 100.0, label: 'Fair', hex: '#FFC000', bg: '#FFFF00' },
      { max: 150.0, label: 'Poor', hex: '#FF7E00', bg: '#FF7E00' },
      { max: 200.0, label: 'Unhealthy', hex: '#FF0000', bg: '#FF0000' },
      { max: 300.0, label: 'Acutely Unhealty', hex: '#8F3F97', bg: '#8F3F97' },
      { min: 301.0, label: 'Emergency', hex: '#7E0023', bg: '#7E0023' },
    ];
    
    const pickBand = aqi =>
      AQI_BANDS.find(b => (b.max != null ? aqi <= b.max : aqi >= (b.min ?? 0))) || AQI_BANDS[AQI_BANDS.length - 1];

    /* ✅ CHANGED: simple buffer updater that shifts & pushes using the same label format */
    function appendPoint(rangeKey, iso, nowcast, decibel) {
      const buf = live[rangeKey];
      if (!buf) return;

      const label = fmtTime(iso);
      const lastLbl = buf.labels.at(-1);

      // If the new reading belongs to a new slot, shift arrays and push label
      if (label !== lastLbl) {
        const shiftPush = (arr, v) => { arr.shift(); arr.push(v); };
        shiftPush(buf.labels, label);
        shiftPush(buf.pm2, null);
        shiftPush(buf.pm10, null);
        shiftPush(buf.co, null);
        shiftPush(buf.no, null);
        shiftPush(buf.avgDb, null);
        shiftPush(buf.peakDb, null);
      }

      const i = buf.labels.length - 1;
      if (nowcast) {
        buf.pm2[i] = toNum(nowcast.pm2_5);
        buf.pm10[i] = toNum(nowcast.pm10);
        buf.co[i] = toNum(nowcast.co);
        buf.no[i] = toNum(nowcast.no2);
      }
      if (decibel != null) {
        buf.avgDb[i] = toNum(decibel);
        buf.peakDb[i] = toNum(decibel) != null ? toNum(decibel) + 5 : null; // placeholder
      }
    }

    function attachEcho() {
      if (!window.Echo) { console.warn('Echo not found'); return; }

      window.Echo.channel('dashboard')
        .listen('DashboardUpdated', (d) => {
          if (d.hardware_id == selectedHardwareId){
              console.log("Updating nyehehe");
              // Cards
              const fmt = (v, unit) => (v == null ? '—' : `${Math.floor(v)} ${unit}`);
              //   const pmNodes = document.querySelectorAll('span[id="pm2.5Label"]');
              //   if (pmNodes[0]) pmNodes[0].textContent = fmt(d.latest_nowcast?.pm2_5, 'µg/m³');
              //   if (pmNodes[1]) pmNodes[1].textContent = fmt(d.latest_nowcast?.pm10,  'µg/m³');
              //   if (pmNodes[2]) pmNodes[2].textContent = fmt(d.latest_nowcast?.co,    'ppm');
              //   if (pmNodes[3]) pmNodes[3].textContent = fmt(d.latest_nowcast?.no2,   'ppb');

              const pairs = [
                ['pm2Label', d.latest_vals?.pm2_5, 'µg/m³'],
                ['pm10Label', d.latest_vals?.pm10, 'µg/m³'],
                ['coLabel', d.latest_vals?.co, 'ppm'],
                ['noLabel', d.latest_vals?.no2, 'ppb'],
              ];

              for (const [id, value, unit] of pairs) {
                const el = document.getElementById(id);
                if (el) el.textContent = fmt(value, unit);
              }

              const avgEl = document.getElementById('avgDbLbl');
              if (avgEl) avgEl.textContent = (d.average_decibel == null || isNaN(d.average_decibel)) ? '—' : Math.floor(d.average_decibel);

              const peakEl = document.getElementById('peakDbLbl');
              if (peakEl) peakEl.textContent = (d.peak_decibel == null || isNaN(d.peak_decibel)) ? '—' : Math.floor(d.peak_decibel);

              const dbEl = document.getElementById('latestDbLbl');
              if (dbEl) dbEl.textContent = fmt(d.latest_decibel, 'Db');

              const asOf = document.getElementById('asOfLbl');
              if (asOf) {
                let dateText = '—';
                if (d.latest_datetime) {
                  const dt = new Date(d.latest_datetime);
                  dateText = `${dt.toLocaleDateString()} ${dt.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}`;
                }
                asOf.textContent = `As of: ${dateText}`;
              }

              // AQI slider + background
              const aqi = Math.floor(d.latest_aqi ?? 0);
              const band = pickBand(aqi);
              if (slider) { slider.value = aqi; slider.style.accentColor = band.hex; }
              if (valueEl) { valueEl.textContent = aqi; valueEl.style.color = band.hex; }
              if (catEl) { catEl.textContent = band.label; catEl.style.color = band.hex; }
              if (backColor) backColor.style.backgroundImage = `linear-gradient(to top, ${band.bg} 0%, white 100%)`;
            //   console.log("Insidee");
              // ✅ Update 12h & 24h live buffers using the SAME label format as the segments
              //   if (d.latest_datetime) {
              //     appendPoint("12h", d.latest_datetime, d.latest_nowcast, d.latest_decibel);
              //     appendPoint("24h", d.latest_datetime, d.latest_nowcast, d.latest_decibel);
              //   }

              let formatted = '—';
              if (typeof d.latest_datetime === 'string' && d.latest_datetime.trim()) {
                // Make "YYYY-MM-DD HH:mm:ss" ISO-like for safe parsing
                const dt = new Date(d.latest_datetime.replace(' ', 'T'));
                if (!Number.isNaN(dt.getTime())) {
                  formatted = dt.toLocaleString('en-US', {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric',
                    hour: 'numeric',
                    minute: '2-digit',
                    second: '2-digit',
                    hour12: true
                  });
                }
              }

              const lastUpdatedEl = document.getElementById('lastUpdatedLbl');
              if (lastUpdatedEl) lastUpdatedEl.textContent = formatted;
          }


          // Re-render whichever range is active
          //   const airRange = document.getElementById("aqiTimeSelect")?.value || "12h";
          //   const soundRange = document.getElementById("timeRangeSelect")?.value || "12h";
          //   renderFromBuffer(airRange, "air");
          //   renderFromBuffer(soundRange, "sound");
        });

      window.Echo.channel('sensor-malfunctioned')
        .listen('.sensor.status', (e) => console.log('✅ .sensor.status', e.reading ?? e));
    }

    /* =========================
    * TEST BUTTONS / ECHO
    * ========================= */
    document.addEventListener("DOMContentLoaded", () => {
      attachEcho();

      const RECEIVE_URL = @json(route('hardware.receive_data'));
      const btn = document.getElementById("send-reading-btn");
      if (btn) {
        btn.addEventListener("click", async () => {
          try {
            const realtime_stamp = new Date(Date.now() - 4 * 60 * 1000).toISOString();

            const res = await fetch(RECEIVE_URL, {
              method: "POST",
              headers: { "Content-Type": "application/json" },
              body: JSON.stringify({
                hardware_info: "hw-aeroson-001", pm2_5: 2.4, pm10: 4.2, co: 2.1, no2: 1.5, decibels: 75.5, peak_db: 80.0,
                realtime_stamp: realtime_stamp, longitude: "12.4", latitude: "32.4"
              }),
            });
            if (res.ok) console.log("✅ Reading dispatched successfully!");
            else console.error("❌ Failed to send reading, HTTP", res.status);
          } catch (err) { console.error("⚠️ Error sending reading:", err); }
        });
      }

      const SENSOR_URL = @json(route('hardware.receive_status'));
      const sensorBtn = document.getElementById("send-status-btn");
      if (sensorBtn) {
        sensorBtn.addEventListener("click", async () => {
          try {
            const res = await fetch(SENSOR_URL, {
              method: "POST",
              headers: { "Content-Type": "application/json" },
              body: JSON.stringify({ hardware_info: 1, sensor_type: "mq7", sensor_status: "inactive" }),
            });
            if (res.ok) console.log("✅ Status dispatched successfully!");
            else console.error("❌ Failed to send status, HTTP", res.status);
          } catch (err) { console.error("⚠️ Error sending status:", err); }
        });
      }
    });
    
    // async function loadPrediction() {
    //   const el = document.getElementById('aqiPredictionMarquee');
    //   if (!el) return;
    
    //   // Optional: show a temporary message while fetching
    //   el.textContent = "Loading prediction…";
    
    //   try {
    //     const res = await fetch(`/api/predict-latest?t=${Date.now()}`, {
    //       headers: { "Accept": "application/json" }
    //     });
    
    //     // Try to parse JSON even for errors (Laravel often returns JSON errors too)
    //     let data = null;
    //     try { data = await res.json(); } catch (_) {}
    
    //     if (!res.ok || !data) {
    //       el.textContent = "For the next hour, the average AQI will be: — and the average noise level will be: —";
    //       console.warn("Prediction failed:", res.status, data);
    //       return;
    //     }
    
    //     const aqi = data.aqi_next_hour_avg ?? data.aqi_next_hour_avg_1h ?? data.aqi_pred;
    //     const noise = data.noise_next_hour_avg ?? data.noise_next_hour_avg_1h ?? data.noise_pred;
    
    //     const aqiText = (aqi == null || Number.isNaN(Number(aqi))) ? "—" : Math.round(Number(aqi));
    //     const noiseText = (noise == null || Number.isNaN(Number(noise))) ? "—" : Math.round(Number(noise));
    
    //     el.textContent = `For the next hour, the average AQI will be: ${aqiText} and the average noise level will be: ${noiseText}`;
    //   } catch (err) {
    //     console.error("Prediction fetch error:", err);
    //     el.textContent = "For the next hour, the average AQI will be: — and the average noise level will be: —";
    //   }
    // }
    
    async function loadPrediction() {
          const aqiEl = document.getElementById('aqiPredictionMarquee');
          const noiseEl = document.getElementById('noisePredictionMarquee');
        console.log("loading-prediction");
          if (!aqiEl || !noiseEl) return;
        
          // Temporary loading messages
          aqiEl.innerHTML = `
                <div class="w-70 h-auto flex justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24">
                      <circle cx="12" cy="3.5" r="1.5" fill="#000000" opacity="0">
                        <animateTransform
                          attributeName="transform"
                          calcMode="discrete"
                          dur="2.4s"
                          repeatCount="indefinite"
                          type="rotate"
                          values="0 12 12;90 12 12;180 12 12;270 12 12"/>
                        <animate
                          attributeName="opacity"
                          dur="0.6s"
                          keyTimes="0;0.5;1"
                          repeatCount="indefinite"
                          values="1;1;0"/>
                      </circle>
                    
                      <circle cx="12" cy="3.5" r="1.5" fill="#000000" opacity="0">
                        <animateTransform
                          attributeName="transform"
                          begin="0.2s"
                          calcMode="discrete"
                          dur="2.4s"
                          repeatCount="indefinite"
                          type="rotate"
                          values="30 12 12;120 12 12;210 12 12;300 12 12"/>
                        <animate
                          attributeName="opacity"
                          begin="0.2s"
                          dur="0.6s"
                          keyTimes="0;0.5;1"
                          repeatCount="indefinite"
                          values="1;1;0"/>
                      </circle>
                    
                      <circle cx="12" cy="3.5" r="1.5" fill="#000000" opacity="0">
                        <animateTransform
                          attributeName="transform"
                          begin="0.4s"
                          calcMode="discrete"
                          dur="2.4s"
                          repeatCount="indefinite"
                          type="rotate"
                          values="60 12 12;150 12 12;240 12 12;330 12 12"/>
                        <animate
                          attributeName="opacity"
                          begin="0.4s"
                          dur="0.6s"
                          keyTimes="0;0.5;1"
                          repeatCount="indefinite"
                          values="1;1;0"/>
                      </circle>
                    </svg>
                </div>
                `;
          noiseEl.innerHTML = `
                <div class="w-70 h-auto flex justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24">
                      <circle cx="12" cy="3.5" r="1.5" fill="#000000" opacity="0">
                        <animateTransform
                          attributeName="transform"
                          calcMode="discrete"
                          dur="2.4s"
                          repeatCount="indefinite"
                          type="rotate"
                          values="0 12 12;90 12 12;180 12 12;270 12 12"/>
                        <animate
                          attributeName="opacity"
                          dur="0.6s"
                          keyTimes="0;0.5;1"
                          repeatCount="indefinite"
                          values="1;1;0"/>
                      </circle>
                    
                      <circle cx="12" cy="3.5" r="1.5" fill="#000000" opacity="0">
                        <animateTransform
                          attributeName="transform"
                          begin="0.2s"
                          calcMode="discrete"
                          dur="2.4s"
                          repeatCount="indefinite"
                          type="rotate"
                          values="30 12 12;120 12 12;210 12 12;300 12 12"/>
                        <animate
                          attributeName="opacity"
                          begin="0.2s"
                          dur="0.6s"
                          keyTimes="0;0.5;1"
                          repeatCount="indefinite"
                          values="1;1;0"/>
                      </circle>
                    
                      <circle cx="12" cy="3.5" r="1.5" fill="#000000" opacity="0">
                        <animateTransform
                          attributeName="transform"
                          begin="0.4s"
                          calcMode="discrete"
                          dur="2.4s"
                          repeatCount="indefinite"
                          type="rotate"
                          values="60 12 12;150 12 12;240 12 12;330 12 12"/>
                        <animate
                          attributeName="opacity"
                          begin="0.4s"
                          dur="0.6s"
                          keyTimes="0;0.5;1"
                          repeatCount="indefinite"
                          values="1;1;0"/>
                      </circle>
                    </svg>
                </div>
                `;
        
          try {
            const res = await fetch(
              `/api/predict-latest?hardware_id=${selectedHardwareId}&t=${Date.now()}`,
              {
                headers: { "Accept": "application/json" }
              }
            );
        
            let data = null;
            try { data = await res.json(); } catch (_) {}
        
            if (!res.ok || !data) {
              aqiEl.textContent = "—";
              noiseEl.textContent = "—";
              console.warn("Prediction failed:", res.status, data);
              return;
            }
        
            const aqi =
              data.aqi_next_hour_avg ??
              data.aqi_next_hour_avg_1h ??
              data.aqi_pred;
        
            const noise =
              data.noise_next_hour_avg ??
              data.noise_next_hour_avg_1h ??
              data.noise_pred;
        
            const aqiText =
              (aqi == null || Number.isNaN(Number(aqi))) ? "—" : Math.round(Number(aqi));
        
            const noiseText =
              (noise == null || Number.isNaN(Number(noise))) ? "—" : Math.round(Number(noise));
        
            // Separate outputs
            aqiEl.textContent = `${aqiText}`;
            noiseEl.textContent = `${noiseText} dB`;
        
          } catch (err) {
            console.error("Prediction fetch error:", err);
            aqiEl.textContent = "—";
            noiseEl.textContent = "—";
          }
    }

    
    document.addEventListener('DOMContentLoaded', () => {
      loadPrediction();
      setInterval(loadPrediction, 5 * 60 * 1000); // refresh every 5 minutes
    });
    
  </script>


</x-layout>