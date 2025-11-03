<x-layout>
    <div class="w-full h-auto flex justify-center items-center flex-col bg-white gap-y-5">
        <!-- Maps -->
        <div id="map" class="h-[200px] flex w-full shadow-lg z-0"></div>
        <!-- AQI -->
        <div class="w-[95%] h-auto rounded-3xl flex">
            <div x-data="{ activeTab: 'barangay' }" class="w-full h-full">
                <!-- Tab header -->
                <div class="flex flex-row justify-between h-[50px] w-full">
                    <div class="flex flex-row bg-[#eceaea] rounded-t-lg w-60">
                        <button class=" w-30 rounded-t-lg cursor-pointer" @click="activeTab = 'barangay'" :class="activeTab === 'barangay'
                                    ? 'text-[#06402b] font-semibold bg-white border-[#06402b] border-t-4'
                                    : 'text-black border-b border-transparent hover:text-blue-500'">
                            Barangay 115
                        </button>

                        <button class=" w-30 rounded-t-lg cursor-pointer" @click="activeTab = 'ucc'" :class="activeTab === 'ucc'
                                    ? 'text-[#06402b] font-semibold bg-white border-[#06402b] border-t-4'
                                    : 'text-[#06402b] border-b border-transparent hover:text-blue-500'">
                            UCC
                        </button>
                    </div>
                    <button class=" w-30 rounded-full cursor-pointer" @click="activeTab = 'weather'" :class="activeTab === 'weather'
                                ? 'text-white font-semibold bg-[#06402b]'
                                : 'text-[#06402b] bg-[#eceaea] hover:text-white hover:bg-[#06402b]'">
                        Weather
                    </button>
                </div>

                <!-- Tab content -->
                <div class="border border-white rounded-b-3xl h-auto bg-white">
                    <div x-show="activeTab === 'barangay'" x-transition
                        class="flex flex-col h-auto w-full justify-between items-center gap-y-2">
                        <div class="w-[98%] h-[120px] flex flex-row justify-between items-center px-1">
                            <div class="flex flex-col w-auto h-full gap-y-1 items-start justify-center">
                                <div
                                    class="w-14 h-4 flex justify-center items-center gap-x-2 bg-red-500 text-black text-center text-xs rounded-md">
                                    <span class="text-xl text-center">•</span>LIVE
                                </div>
                                <span class="text-black font-bold text-lg tracking-wide uppercase">Air Quality Index |
                                    Sound
                                    Level</span>
                                <span class="text-[#919090] text-sm italic">Last Updated: 2025-09-25 06:52:16 PM (Local
                                    Time)</span>
                                <div class="overflow-hidden whitespace-nowrap">
                                    <div class="inline-block animate-marquee">
                                        <span class="mx-4 text-xs italic uppercase tracking-widest">For the next hour,
                                            the aqi will be: 48</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex w-[50%] h-full items-center justify-end">
                            </div>
                        </div>
                        <div id="aqi-back" class="">
                            <!-- <div class="absolute flex overflow-hidden whitespace-nowrap w-full h-full">
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
                            <div
                                class="w-full lg:w-[48%] flex flex-col h-full justify-center items-center gap-y-6 z-10">
                                <div class="flex flex-row gap-y-5 w-[90%] lg:w-[80%]">
                                    <div class="flex flex-col w-[30%] items-center justify-center">
                                        <div class="flex flex-row gap-x-2 items-center">
                                            <div class="w-4 h-4 rounded-full bg-red-600 animate-pulse duration-100">
                                            </div>
                                            <span class="text-sm font-semibold">Live AQI</span>
                                        </div>
                                        <span id="aqi-value">0</span>
                                    </div>
                                    <div class="flex flex-col w-[70%] gap-y-2 justify-center items-center">
                                        <span class="text-sm font-semibold">Air Quality is</span>
                                        <span id="aqi-category">Good</span>
                                    </div>
                                </div>
                                <div class="w-[90%] lg:w-[80%] h-auto flex mt-8">
                                    <div class="relative w-full max-w-xl mx-auto">
                                        <!-- Labels positioned along the same line -->
                                        <div class="absolute -top-6 left-0 w-full">
                                            <div class="relative w-full text-xs text-gray-700">

                                                <!-- Each span positioned by left percentage matching color stop -->
                                                <span
                                                    class="absolute -translate-x-1/2 left-[12.5%] text-center text-black">0-25</span>
                                                <span
                                                    class="absolute -translate-x-1/2 left-[30%]  text-center text-black">25.1-35</span>
                                                <span
                                                    class="absolute -translate-x-1/2 left-[40%]  text-center text-black">35.1-45</span>
                                                <span
                                                    class="absolute -translate-x-1/2 left-[50%]  text-center text-black">45.1-55</span>
                                                <span
                                                    class="absolute -translate-x-1/2 left-[72.5%] text-center text-black">55.1-90</span>
                                                <span
                                                    class="absolute -translate-x-1/2 left-[95%]  text-center text-black">90.1+</span>

                                            </div>
                                        </div>
                                        <!-- AQI slider with multicolor track -->
                                        <input id="aqi-slider" type="range" min="0" max="100" value="0" disabled
                                            class="w-full h-3 rounded-lg appearance-none" style="
                                            background: linear-gradient(
                                                to right,
                                                #00E400 0%,  #00E400 25%,
                                                #FFFF00 25%, #FFFF00 35%,
                                                #FF7E00 35%, #FF7E00 45%,
                                                #FF0000 45%, #FF0000 55%,
                                                #8F3F97 55%, #8F3F97 90%,
                                                #7E0023 90%, #7E0023 100%
                                            );
                                            ">

                                        <!-- Labels positioned along the same line -->
                                        <div class="absolute top-6 left-0 w-full">
                                            <div class="relative w-full text-xs text-gray-700">

                                                <!-- Each span positioned by left percentage matching color stop -->
                                                <span
                                                    class="absolute -translate-x-1/2 left-[12.5%] text-center text-black">Good</span>
                                                <span
                                                    class="absolute -translate-x-1/2 left-[30%]  text-center text-black">Fair</span>
                                                <span
                                                    class="absolute -translate-x-1/2 left-[40%]  text-center text-black">Poor</span>
                                                <span
                                                    class="absolute -translate-x-1/2 left-[50%]  text-center text-black">Unhealthy</span>
                                                <span
                                                    class="absolute -translate-x-1/2 left-[72.5%] text-center text-black">Severe</span>
                                                <span
                                                    class="absolute -translate-x-1/2 left-[95%]  text-center text-black">Emergency</span>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex flex-row justify-evenly w-[90%] lg:w-[80%] mt-6">
                                    <span class="text-sm text-black font-bold">PM2.5: <span
                                            class="text-black font-normal" id="pm2.5Label">16 µg/m³</span></span>
                                    <div class="h-4 border border-white"></div>
                                    <span class="text-sm text-black font-bold">PM10: <span
                                            class="text-black font-normal" id="pm2.5Label">18 µg/m³</span></span>
                                    <div class="h-4 border border-white"></div>
                                    <span class="text-sm text-black font-bold">CO: <span
                                            class="text-black font-normal" id="pm2.5Label">62 ppm</span></span>
                                    <div class="h-4 border border-white"></div>
                                    <span class="text-sm text-black font-bold">NO₂: <span
                                            class="text-black font-normal" id="pm2.5Label">7 ppb</span></span>
                                </div>
                            </div>
                            <div
                                class="w-full lg:w-[48%] flex flex-col h-full justify-center items-center gap-y-6 z-10">
                                <div
                                    class="flex flex-row bg-white/70 border border-white w-[80%] h-[90%] lg:h-[50%] rounded-xl items-center justify-evenly">
                                    <div class="w-[30%] h-full flex flex-col items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="size-12 animate-pulse duration-100 text-black" viewBox="0 0 100 100"
                                            fill="currentColor">
                                            <path fill="currentColor"
                                                d="M45.697 45.697a6.083 6.083 0 0 0-.002 8.603a6.082 6.082 0 0 0 8.606.001a6.08 6.08 0 0 0 0-8.607a6.08 6.08 0 0 0-8.604.003zm30.852 33.468c15.972-16.109 15.934-42.207-.122-58.263c-.023-.023-.05-.037-.073-.059l.006-.006l-1.696-1.698l-.02.02a2.38 2.38 0 0 0-3.136.141l-.003-.003l-.026.026l-.008.007l-.006.008l-2.773 2.772l-.002.002a.002.002 0 0 1-.002.002l-.2.2l.02.02a2.376 2.376 0 0 0 .01 2.951l-.019.019l.19.19v.001h.001L70.196 27l.027-.027c.022.023.037.05.06.073C82.95 39.714 82.99 60.3 70.405 73.02l-.017-.017l-1.504 1.504l-.003.002l-.002.003l-.188.188l.019.019a2.38 2.38 0 0 0 .141 3.136l-.003.003l.031.031l.002.003l.003.002l1.396 1.396l.002.003l.003.002l1.376 1.376l.002.003l.003.002l.198.198l.02-.02a2.377 2.377 0 0 0 2.952-.009l.019.019l1.567-1.568a.018.018 0 0 1 .005-.004l.018-.019l.107-.107l-.003-.001z" />
                                            <path fill="currentColor"
                                                d="M64.923 67.54c9.561-9.699 9.523-25.365-.123-35.01c-.023-.023-.05-.037-.073-.06l.007-.007l-1.697-1.698l-.02.02a2.382 2.382 0 0 0-3.136.141l-.003-.003l-.029.029l-.005.004l-.004.005l-2.774 2.774l-.004.003l-.003.004l-.198.198l.02.02a2.376 2.376 0 0 0 .009 2.951l-.019.019l.189.189l.002.002l.002.002l1.504 1.505l.027-.027c.022.023.037.05.06.073c6.258 6.257 6.293 16.407.119 22.717l-.013-.013l-1.505 1.505l-.002.001l-.001.002l-.189.189l.019.019a2.38 2.38 0 0 0 .141 3.135l-.004.004l2.816 2.815l.201.201l.02-.02a2.378 2.378 0 0 0 2.951-.009l.02.02l1.572-1.572l.125-.125l-.002-.003z" />
                                            <g fill="currentColor">
                                                <path
                                                    d="M54.305 45.7a6.083 6.083 0 0 0-8.606-.001a6.08 6.08 0 0 0 0 8.605a6.08 6.08 0 0 0 8.605-.001a6.084 6.084 0 0 0 .001-8.603z" />
                                                <path
                                                    d="m43.109 63.089l.019-.019l-.188-.188l-.003-.004l-.003-.003l-1.503-1.504l-.027.027c-.022-.023-.037-.05-.059-.072c-6.258-6.258-6.293-16.408-.119-22.718l.013.013l1.697-1.696l-.02-.02a2.38 2.38 0 0 0-.141-3.135l.004-.004l-3.018-3.017l-.02.02a2.376 2.376 0 0 0-2.951.009l-.019-.019l-.191.191l-1.381 1.381l-.125.125l.003.003c-9.562 9.699-9.523 25.365.123 35.011c.022.022.049.037.072.059l-.006.006l1.697 1.698l.02-.02a2.382 2.382 0 0 0 3.135-.141l.003.003l.029-.029l.005-.004l.004-.005l2.775-2.775l.003-.002l.002-.002l.199-.199l-.02-.02a2.374 2.374 0 0 0-.009-2.95z" />
                                                <path
                                                    d="m31.483 74.715l.019-.019l-.19-.19l-.001-.001l-.001-.001l-1.506-1.505l-.027.027c-.022-.023-.037-.05-.059-.073C17.05 60.284 17.012 39.7 29.597 26.98l.016.016l1.504-1.504l.003-.002l.002-.003l.188-.188l-.019-.019a2.38 2.38 0 0 0-.141-3.136l.004-.004l-1.434-1.434l-.001-.001l-.001-.001l-1.581-1.581l-.02.021a2.376 2.376 0 0 0-2.951.009l-.02-.02l-1.696 1.697l.003.003c-15.974 16.11-15.936 42.209.121 58.265c.023.023.05.037.073.059l-.007.007l1.697 1.698l.02-.02a2.382 2.382 0 0 0 3.136-.142l.003.003l.033-.033l2.778-2.779l.005-.004l.004-.005l.196-.196l-.02-.02a2.376 2.376 0 0 0-.009-2.951z" />
                                            </g>
                                        </svg>
                                    </div>
                                    <div class="h-full border border-white"></div>
                                    <div class="w-[70%] h-full flex flex-col items-center justify-center">
                                        <div class="flex flex-row w-full h-[50%] justify-center items-center gap-x-5">
                                            <span class="text-black font-semibold text-xl uppercase">Sound Level</span>
                                            <span class="text-blue-500 font-bold text-4xl" id="latestDbLbl">70<span
                                                    class="text-lg text-black">db</span></span>
                                        </div>
                                        <div class="w-full border border-white"></div>
                                        <div class="flex flex-col w-full h-[50%] justify-evenly items-center py-3">
                                            <div class="flex w-full h-[30%] justify-center items-center">
                                                <span class="text-black text-xs italic" id="asOfLbl">As of this Date:
                                                    2025-09-25</span>
                                            </div>
                                            <div class="flex flex-row w-full h-[70%] justify-evenly items-center">
                                                <div class="w-full justify-center items-center flex flex-row gap-x-3">
                                                    <span
                                                        class="text-xs lg:text-base text-center font-semibold uppercase">Average
                                                        dB:</span>
                                                    <span class="text-xl text-center font-bold text-green-600" id="avgDbLbl">70</span>
                                                </div>
                                                <div class="h-[50%] border border-white"></div>
                                                <div class="w-full justify-center items-center flex flex-row gap-x-3">
                                                    <span
                                                        class="text-xs lg:text-base text-center font-semibold uppercase">Peak
                                                        dB:</span>
                                                    <span class="text-xl text-center font-bold text-red-600" id="peakDbLbl">80</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-full h-auto flex flex-col gap-y-3 mt-2 mb-5">
                            <div x-data="{ selectedChart: 'air' }"
                                class="w-full h-auto mx-auto bg-white p-4 rounded-xl shadow-md">
                                <div class="flex flex-row justify-between items-center px-5">
                                    <h1 class="text-xl font-semibold mb-4 text-center">Air Monitoring Chart</h1>
                                    <div class="flex flex-row gap-x-5">
                                        <!-- Time range dropdown -->
                                        <div class="mb-4 text-center">
                                            <select id="aqiTimeSelect"
                                                class="border border-[#06402b] rounded-md p-2 text-sm text-[#06402b] focus:ring-0 focus:outline-none">
                                                <option value="12h">12 Hrs</option>
                                                <option value="24h">24 Hrs</option>
                                                <option value="7d">7 Days</option>
                                                <option value="30d">30 Days</option>
                                            </select>
                                        </div>
                                        <!-- Pollutant dropdown -->
                                        <div class="mb-4 text-center">
                                            <select id="gasSelect" x-model="selectedChart"
                                                class="border border-[#06402b] text-[#06402b] rounded-md p-2 text-sm focus:ring-0 focus:outline-none">
                                                <option value="air">All</option>
                                                <option value="pm2">PM 2.5</option>
                                                <option value="pm10">PM 10</option>
                                                <option value="co">CO</option>
                                                <option value="no">NO₂</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Chart canvases -->
                                <div x-show="selectedChart === 'air'" x-transition><canvas id="airChart" height="300"
                                        class="w-full"></canvas></div>
                                <div x-show="selectedChart === 'pm2'" x-transition><canvas id="pmTwoChart" height="300"
                                        class="w-full"></canvas></div>
                                <div x-show="selectedChart === 'pm10'" x-transition><canvas id="pmTenChart" height="300"
                                        class="w-full"></canvas></div>
                                <div x-show="selectedChart === 'co'" x-transition><canvas id="coChart" height="300"
                                        class="w-full"></canvas></div>
                                <div x-show="selectedChart === 'no'" x-transition><canvas id="noChart" height="300"
                                        class="w-full"></canvas></div>
                            </div>
                            <div class="w-full h-auto mx-auto bg-white p-4 rounded-xl shadow-md">
                                <div class="flex flex-row justify-between items-center px-5">
                                    <h1 class="text-xl font-semibold mb-4 text-center">Sound Monitoring Chart</h1>
                                    <div class="flex flex-row gap-x-5">
                                        <div class="mb-4 text-center">
                                            <select id="timeRangeSelect"
                                                class="border border-[#06402b] rounded-md p-2 text-sm text-[#06402b] focus:ring-0 focus:outline-none">
                                                <option class="text-start" value="12h">12 Hrs</option>
                                                <option class="text-start" value="24h">24 Hrs</option>
                                                <option class="text-start" value="7d">7 Days</option>
                                                <option class="text-start" value="30d">30 Days</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <canvas id="soundChart" height="300" class="w-full"></canvas>
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
                    <div x-show="activeTab === 'ucc'" x-transition
                        class="flex flex-col h-full w-full justify-center items-center">
                        Content for UCC
                    </div>
                    <!-- Weather -->
                    <div x-show="activeTab === 'weather'" x-transition
                        class="flex flex-col h-full w-full justify-center items-center">
                        <div id="weather"
                            class="h-auto bg-white flex flex-col justify-center items-center w-full shadow-xl z-0 py-5 lg:gap-y-5">
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <button id="send-reading-btn">Send Reading</button>
            <button id="send-status-btn">Send Status</button>
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
        const seg7d  = @json($seg7d);
        const seg30d = @json($seg30d);
        
        /* ---------- ordering & labels (use real timestamps) ---------- */
        const byStart = (a, b) => new Date(a.start) - new Date(b.start);
        const fmtTime = iso => new Date(iso).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        const fmtDate = iso => new Date(iso).toLocaleDateString('en-CA'); // YYYY-MM-DD
        
        const sorted12h = seg12h.slice().sort(byStart);
        const sorted24h = seg24h.slice().sort(byStart);
        const sorted7d  = seg7d.slice().sort(byStart);
        const sorted30d = seg30d.slice().sort(byStart);
        
        const labelSets = {
          "12h": sorted12h.map(s => fmtTime(s.start)),  // 12 × 1h bins
          "24h": sorted24h.map(s => fmtTime(s.start)),  // 12 × 2h bins
          "7d" : sorted7d .map(s => fmtDate(s.start)),  // 7 × daily bins
          "30d": sorted30d.map(s => fmtDate(s.start)),  // 30 × daily bins
        };
        
        /* =========================
         * “TODAY” CARDS / LABELS
         * ========================= */
        const latestAqi      = Math.floor(@json($latest_aqi));
        const latestNowcast  = @json($latest_nowcast);
        const latestDateTime = @json($latest_datetime);
        const latestDecibel  = Math.floor(@json($latest_decibel));
        const peakDecibel    = Math.floor(@json($peak_decibel));
        const averageDecibel = Math.floor(@json($avgDecibelToday));
        
        document.addEventListener('DOMContentLoaded', () => {
          const fmt = (v, unit) => (v == null ? '—' : `${Math.floor(v)} ${unit}`);
        
          // there are 4 spans sharing id="pm2.5Label" in your markup (kept as-is)
          const nodes = document.querySelectorAll('span[id="pm2.5Label"]');
          if (nodes[0]) nodes[0].textContent = fmt(latestNowcast.pm2_5, 'µg/m³');
          if (nodes[1]) nodes[1].textContent = fmt(latestNowcast.pm10,  'µg/m³');
          if (nodes[2]) nodes[2].textContent = fmt(latestNowcast.co,    'ppm');
          if (nodes[3]) nodes[3].textContent = fmt(latestNowcast.no2,   'ppb');
        
          if (document.getElementById('latestDbLbl'))
            document.getElementById('latestDbLbl').textContent = (isNaN(latestDecibel) ? '—' : `${latestDecibel} Db`);
        
          if (document.getElementById('avgDbLbl'))
            document.getElementById('avgDbLbl').textContent = isNaN(averageDecibel) ? '—' : averageDecibel;
        
          if (document.getElementById('peakDbLbl'))
            document.getElementById('peakDbLbl').textContent = isNaN(peakDecibel) ? '—' : peakDecibel;
        
          if (document.getElementById('asOfLbl')) {
            let dateText = '—';
            if (latestDateTime) dateText = new Date(latestDateTime).toISOString().split('T')[0];
            document.getElementById('asOfLbl').textContent = `As of this Date: ${dateText}`;
          }
        });
        
        /* =========================
         * MAP (unchanged)
         * ========================= */
        const map = L.map('map').setView([14.6458, 120.9865], 18);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { minZoom: 15, maxZoom: 18 }).addTo(map);
        [{ name: 'Barangay 115', coords: [14.6458, 120.9865] }].forEach(loc => {
          L.marker(loc.coords).addTo(map).bindPopup(`<b>${loc.name}</b>`);
        });
        
        /* =========================
         * WEATHER (unchanged logic)
         * ========================= */
        document.addEventListener('DOMContentLoaded', () => {
          const city = "Caloocan";
          const lat = 14.6514, lon = 120.97;
          let currentUnit = "C";
          let forecastData = null;
        
          const weatherCodeMap = { 0:{text:"Sunny",icon:"https://cdn.weatherapi.com/weather/64x64/day/113.png"},
            1:{text:"Mainly clear",icon:"https://cdn.weatherapi.com/weather/64x64/day/116.png"},
            2:{text:"Partly cloudy",icon:"https://cdn.weatherapi.com/weather/64x64/day/119.png"},
            3:{text:"Cloudy",icon:"https://cdn.weatherapi.com/weather/64x64/day/122.png"},
            45:{text:"Fog",icon:"https://cdn.weatherapi.com/weather/64x64/day/248.png"},
            48:{text:"Freezing fog",icon:"https://cdn.weatherapi.com/weather/64x64/day/260.png"},
            51:{text:"Light drizzle",icon:"https://cdn.weatherapi.com/weather/64x64/day/266.png"},
            53:{text:"Moderate drizzle",icon:"https://cdn.weatherapi.com/weather/64x64/day/296.png"},
            55:{text:"Heavy drizzle",icon:"https://cdn.weatherapi.com/weather/64x64/day/302.png"},
            56:{text:"Light freezing rain",icon:"https://cdn.weatherapi.com/weather/64x64/day/311.png"},
            57:{text:"Heavy freezing rain",icon:"https://cdn.weatherapi.com/weather/64x64/day/314.png"},
            61:{text:"Light rain",icon:"https://cdn.weatherapi.com/weather/64x64/day/308.png"},
            63:{text:"Moderate rain",icon:"https://cdn.weatherapi.com/weather/64x64/day/308.png"},
            65:{text:"Heavy rain",icon:"https://cdn.weatherapi.com/weather/64x64/day/314.png"},
            71:{text:"Light snow",icon:"https://cdn.weatherapi.com/weather/64x64/day/332.png"},
            73:{text:"Moderate snow",icon:"https://cdn.weatherapi.com/weather/64x64/day/338.png"},
            75:{text:"Heavy snow",icon:"https://cdn.weatherapi.com/weather/64x64/day/338.png"},
            77:{text:"Snow grains",icon:"https://cdn.weatherapi.com/weather/64x64/day/338.png"},
            80:{text:"Light rain showers",icon:"https://cdn.weatherapi.com/weather/64x64/day/353.png"},
            81:{text:"Moderate rain showers",icon:"https://cdn.weatherapi.com/weather/64x64/day/356.png"},
            82:{text:"Heavy rain showers",icon:"https://cdn.weatherapi.com/weather/64x64/day/359.png"},
            85:{text:"Light snow showers",icon:"https://cdn.weatherapi.com/weather/64x64/day/368.png"},
            86:{text:"Heavy snow showers",icon:"https://cdn.weatherapi.com/weather/64x64/day/371.png"},
            95:{text:"Rain with lightning",icon:"https://cdn.weatherapi.com/weather/64x64/day/386.png"},
            96:{text:"Showers with lightning",icon:"https://cdn.weatherapi.com/weather/64x64/day/389.png"},
            99:{text:"Stormy rain",icon:"https://cdn.weatherapi.com/weather/64x64/day/389.png"} };
        
          const toF = c => (c * 9 / 5 + 32).toFixed(1);
        
          async function loadWeather() {
            const url = `https://api.open-meteo.com/v1/forecast?latitude=${lat}&longitude=${lon}&current_weather=true&daily=temperature_2m_max,temperature_2m_min,weathercode&timezone=auto`;
            const res = await fetch(url);
            forecastData = await res.json();
            renderWeather();
          }
        console.log("test");
          function renderWeather() {
            const container = document.getElementById('weather');
            const daily = forecastData.daily;
            const current = forecastData.current_weather;
            console.log(current.weathercode);
            const currentInfo = weatherCodeMap[current.weathercode] || { text: "Unknown", icon: "❓" };
            const currentTemp = currentUnit === "C" ? `${current.temperature}°C` : `${toF(current.temperature)}°F`;
            const todayStr = new Date().toISOString().split('T')[0];
        
            const cards = daily.time.map((dateStr, i) => {
              const weekday = new Date(dateStr).toLocaleDateString('en-US', { weekday: 'long' });
              const info = weatherCodeMap[daily.weathercode[i]] || { text: "Unknown", icon: "❓" };
              const max = currentUnit === "C" ? `${daily.temperature_2m_max[i]}°C` : `${toF(daily.temperature_2m_max[i])}°F`;
              const min = currentUnit === "C" ? `${daily.temperature_2m_min[i]}°C` : `${toF(daily.temperature_2m_min[i])}°F`;
              const highlight = dateStr === todayStr ? 'bg-yellow-200' : 'bg-white';
              return `
                <div class="flex flex-col justify-between items-center border-2 border-[#06402b] rounded-xl p-5 w-40 text-center shadow-xl hover:scale-105 duration-300 ${highlight}">
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
        const slider    = document.getElementById('aqi-slider');
        const valueEl   = document.getElementById('aqi-value');
        const catEl     = document.getElementById('aqi-category');
        const backColor = document.getElementById('aqi-back');
        
        const categories = [
          { max: 25, label: 'Good',                        color: 'text-[#00E400] bg-[#00E400]' },
          { max: 35, label: 'Moderate',                        color: 'text-[#FFC000] bg-[#FFFF00]' },
          { max: 45, label: 'Poor',     color: 'text-[#FF7E00] bg-[#FF7E00]' },
          { max: 55, label: 'Unhealthy',              color: 'text-[#FF0000] bg-[#FF0000]' },
          { max: 90, label: 'Severe',           color: 'text-[#8F3F97] bg-[#8F3F97]' },
          { min: 91, label: 'Emergency',                   color: 'text-[#7E0023] bg-[#7E0023]' },
        ];
        
        const category = categories.find(c => latestAqi <= c.max) || categories[categories.length - 1];
        slider.value = latestAqi;
        valueEl.textContent = latestAqi;
        catEl.textContent = category.label;
        valueEl.className = `text-7xl font-bold bg-transparent text-center ${category.color}`;
        catEl.className   = `text-2xl font-bold p-2 w-[81%] bg-white/20 h-14 flex justify-center items-center text-center rounded-xl ${category.color}`;
        backColor.className = `w-full h-[500px] lg:h-[350px] flex flex-col lg:flex-row bg-gradient-to-t from-${category.color} to-white rounded-3xl gap-y-5 py-5 lg:py-0 shadow-lg`;
        
        /* =========================
         * CHARTS (spanGaps + proper order)
         * ========================= */
        let currentRange = "12h";
        const toNum = v => (v == null ? null : Math.floor(v));
        
        function buildDataset(segments) {
          return {
            pm2:  segments.map(s => toNum(s.pm2_5)),
            pm10: segments.map(s => toNum(s.pm10)),
            co:   segments.map(s => toNum(s.co)),
            no:   segments.map(s => toNum(s.no2)),
          };
        }
        const aqiDataSets = {
          "12h": buildDataset(sorted12h),
          "24h": buildDataset(sorted24h),
          "7d" : buildDataset(sorted7d),
          "30d": buildDataset(sorted30d),
        };
        
        function createChart(ctx, label, data, color, bg, title) {
          return new Chart(ctx, {
            type: 'line',
            data: {
              labels: labelSets[currentRange],
              datasets: [{
                label, data, borderColor: color, backgroundColor: bg, tension: 0.3, fill: true
              }]
            },
            options: {
              responsive: false,
              spanGaps: true,                          // ← prevents visual breaks
              plugins: { legend: { position: 'top' }, title: { display: true, text: title } }
            }
          });
        }
        
        const airChart = new Chart(document.getElementById('airChart').getContext('2d'), {
          type: 'line',
          data: {
            labels: labelSets[currentRange],
            datasets: [
              { label: 'PM2.5 (µg/m³)', data: aqiDataSets[currentRange].pm2,  borderColor: 'rgb(59,130,246)',  backgroundColor: 'rgba(59,130,246,0.2)',  tension: 0.3, fill: true },
              { label: 'PM10 (µg/m³)', data: aqiDataSets[currentRange].pm10, borderColor: 'rgb(34,197,94)',   backgroundColor: 'rgba(34,197,94,0.2)',   tension: 0.3, fill: true },
              { label: 'CO (ppm)',     data: aqiDataSets[currentRange].co,   borderColor: 'rgb(239,68,68)',  backgroundColor: 'rgba(239,68,68,0.2)',  tension: 0.3, fill: true },
              { label: 'NO₂ (ppb)',    data: aqiDataSets[currentRange].no,   borderColor: 'rgb(168,85,247)', backgroundColor: 'rgba(168,85,247,0.2)', tension: 0.3, fill: true }
            ]
          },
          options: {
            responsive: false,
            spanGaps: true,                          // ← prevents visual breaks
            animation: { duration: 1000, easing: 'easeInOutQuart' },
            plugins: { legend: { position: 'top' }, title: { display: true, text: 'Air Quality' } }
          }
        });
        
        const pm2Chart  = createChart(document.getElementById('pmTwoChart').getContext('2d'), 'PM2.5 (µg/m³)', aqiDataSets[currentRange].pm2,  'rgb(59,130,246)', 'rgba(59,130,246,0.2)', 'PM2.5');
        const pm10Chart = createChart(document.getElementById('pmTenChart').getContext('2d'), 'PM10 (µg/m³)',  aqiDataSets[currentRange].pm10, 'rgb(34,197,94)',  'rgba(34,197,94,0.2)',  'PM10');
        const coChart   = createChart(document.getElementById('coChart').getContext('2d'),   'CO (ppm)',       aqiDataSets[currentRange].co,   'rgb(239,68,68)', 'rgba(239,68,68,0.2)', 'CO');
        const noChart   = createChart(document.getElementById('noChart').getContext('2d'),   'NO₂ (ppb)',      aqiDataSets[currentRange].no,   'rgb(168,85,247)', 'rgba(168,85,247,0.2)', 'NO₂');
        
        document.getElementById("aqiTimeSelect").addEventListener("change", function () {
          currentRange = this.value;
          const data   = aqiDataSets[currentRange];
          const labels = labelSets[currentRange];
        
          airChart.data.labels              = labels;
          airChart.data.datasets[0].data    = data.pm2;
          airChart.data.datasets[1].data    = data.pm10;
          airChart.data.datasets[2].data    = data.co;
          airChart.data.datasets[3].data    = data.no;
          airChart.update({ duration: 1000, easing: 'easeInOutQuart' });
        
          pm2Chart.data.labels = labels; pm2Chart.data.datasets[0].data = data.pm2; pm2Chart.update({ duration: 1000, easing: 'easeInOutQuart' });
          pm10Chart.data.labels = labels; pm10Chart.data.datasets[0].data = data.pm10; pm10Chart.update({ duration: 1000, easing: 'easeInOutQuart' });
          coChart.data.labels = labels;  coChart.data.datasets[0].data = data.co;    coChart.update({ duration: 1000, easing: 'easeInOutQuart' });
          noChart.data.labels = labels;  noChart.data.datasets[0].data = data.no;    noChart.update({ duration: 1000, easing: 'easeInOutQuart' });
        });
        
        /* =========================
         * SOUND CHART
         * ========================= */
        let soundRange = "12h";
        function buildSoundDs(segments) {
          return {
            avg_decibel: segments.map(s => toNum(s.avg_decibel)),
            peak_decibel: segments.map(s => toNum(s.peak_decibel))
          };
        }
        const soundSets = {
          "12h": buildSoundDs(sorted12h),
          "24h": buildSoundDs(sorted24h),
          "7d" : buildSoundDs(sorted7d),
          "30d": buildSoundDs(sorted30d),
        };
        const soundData = {
          labels: labelSets[soundRange],
          datasets: [
            { label: 'Average dB', data: soundSets[soundRange].avg_decibel, borderColor: 'rgb(245,158,11)', backgroundColor: 'rgba(245,158,11,0.2)', tension: 0.3, fill: true },
            { label: 'Peak dB',    data: soundSets[soundRange].peak_decibel, borderColor: 'rgb(99,102,241)', backgroundColor: 'rgba(99,102,241,0.2)', tension: 0.3, fill: true }
          ]
        };
        const soundChart = new Chart(document.getElementById('soundChart').getContext('2d'), {
          type: 'line',
          data: soundData,
          options: {
            responsive: false,
            spanGaps: true,                          // ← also span gaps here
            animation: { duration: 1000, easing: 'easeInOutQuart' },
            plugins: { legend: { position: 'top' }, title: { display: true, text: 'Sound Levels' } },
            scales: { y: { title: { display: true, text: 'Decibels (dB)' } } }
          }
        });
        document.getElementById("timeRangeSelect").addEventListener("change", function () {
          soundRange = this.value;
          soundChart.data.labels              = labelSets[soundRange];
          soundChart.data.datasets[0].data    = soundSets[soundRange].avg_decibel;
          soundChart.data.datasets[1].data    = soundSets[soundRange].peak_decibel;
          soundChart.update();
        });
        
        /* =========================
         * TEST BUTTONS / ECHO (unchanged)
         * ========================= */
        document.addEventListener("DOMContentLoaded", () => {
          attachEcho();
          function attachEcho() {
            if (!window.Echo) { console.warn('Echo not found'); return; }
            window.Echo.channel('readings').listen('.reading.received', (e) => console.log('✅ reading.received', e.reading ?? e));
            window.Echo.channel('sensor-malfunctioned').listen('.sensor.status', (e) => console.log('✅ .sensor.status', e.reading ?? e));
          }
        
          const RECEIVE_URL = @json(route('hardware.receive_data'));
          const btn = document.getElementById("send-reading-btn");
          if (btn) {
            btn.addEventListener("click", async () => {
              try {
                const res = await fetch(RECEIVE_URL, {
                  method: "POST",
                  headers: { "Content-Type": "application/json" },
                  body: JSON.stringify({
                    hardware_info: 1, pm2_5: 27.6, pm10: 45.2, co: 0.31, no2: 18.4, decibels: 62.5, peak_db: 75.0,
                    realtime_stamp: new Date().toISOString(),
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
</script>

</x-layout>