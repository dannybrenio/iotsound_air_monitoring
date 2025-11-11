<x-layout>
    <div class="h-auto w-full flex flex-col justify-start items-center">
        <div class="w-full h-auto rounded-3xl flex flex-col gap-y-3 items-center">
            <div x-data="{ activeTab: 'aqi' }" class="w-full h-full">
                <!-- Tab header -->
                <div class="flex flex-row justify-between items-start h-auto w-full p-5">
                    <div class="flex flex-row justify-center items-center bg-white w-full h-10">
                        <button class="text-base w-30 cursor-pointer h-10" @click="activeTab = 'aqi'" :class="activeTab === 'aqi'
                                    ? 'text-[#06402b] font-semibold border-b-2 border-yellow-500'
                                    : 'text-[#06402b] hover:text-blue-500'">
                            Air Quality
                        </button>

                        <button class="text-base w-30 cursor-pointer h-10" @click="activeTab = 'sound'" :class="activeTab === 'sound'
                                    ? 'text-[#06402b] font-semibold border-b-2 border-yellow-500'
                                    : 'text-[#06402b] hover:text-blue-500'">
                            Sound Level
                        </button>
                    </div>
                </div>

                <!-- Tab content -->
                <div class="border border-white rounded-b-3xl h-auto bg-white flex justify-center -mt-5">
                    <div x-show="activeTab === 'aqi'" x-transition
                        class="flex flex-col w-[90%] h-auto items-center gap-y-5 px-3 lg:px-10 py-5">
                        <div class="flex flex-col w-[80%] items-center gap-y-3 mb-8">
                            <span class="text-xl font-semibold uppercase text-center text-[#06402b]">What is Air Quality
                                Index (AQI)?</span>
                            <p class="text-base text-center leading-relaxed">The Air Quality Index (AQI) is a numerical
                                and color-coded system used to report how polluted the air is and what associated health
                                effects may be a concern. It helps people, especially those with heart or lung
                                conditions, decide when to limit outdoor activity. The index measures pollutants like
                                ozone, particle pollution, carbon monoxide, sulfur dioxide, and nitrogen dioxide, and
                                ranges from 0 to 99+.</p>
                        </div>
                        <div class="flex flex-col lg:flex-row w-full justify-center gap-x-8 gap-y-3 items-start">
                            <!-- Box1 -->
                            <div 
                                class="bg-white w-full lg:w-[48%] min-h-50 py-3 px-5 flex flex-col shadow-lg rounded-lg items-start gap-y-1 border-t-3 border-[#06402b] hover:-translate-y-2 hover:scale-101 duration-300 transform">
                                <span class="text-center uppercase text-lg text-[#06402b] font-semibold">How is AQI measured
                                        (PM2.5, PM10, CO, NO₂)?</span>
                                <div class="">
                                    <p class="text-sm indent-8 text-justify leading-relaxed">AQI is measured by taking
                                        hourly readings of specific pollutants like PM2.5, PM10, CO, and NO₂, converting
                                        each concentration into a sub-index, and then using the highest sub-index value
                                        to determine the overall AQI. Each pollutant is measured in a specific unit
                                        (e.g., µg/m³) for particulate matter) and compared against breakpoints to
                                        convert it into a single AQI value, with the highest of these values being the
                                        final reported AQ.</p>
                                </div>
                            </div>
                            <!-- Box2 -->
                            <div 
                                class="bg-white w-full lg:w-[48%] min-h-50 py-3 px-5 flex flex-col shadow-lg rounded-lg items-start gap-y-1 border-t-3 border-[#06402b] hover:-translate-y-2 hover:scale-101 duration-300 transform">
                                <span class="text-center uppercase text-lg text-[#06402b] font-semibold">Common sources of Air
                                        Pollution</span>
                                <div  class="">
                                    <p class="text-sm indent-8 text-justify leading-relaxed">Common sources of air
                                        pollution include human activities like vehicle and industrial emissions (from
                                        factories and power plants burning fossil fuels) and area sources such as
                                        agricultural activities, construction, and waste burning. Natural sources also
                                        contribute, including dust storms, wildfires, and volcanic eruptions.</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col lg:flex-row w-full justify-center gap-x-8 gap-y-3 items-start">
                            <!-- Box3 -->
                            <div 
                                class="bg-white w-full lg:w-[48%] min-h-50 py-3 px-5 flex flex-col shadow-lg rounded-lg items-start gap-y-1 border-t-3 border-[#06402b] hover:-translate-y-2 hover:scale-101 duration-300 transform">
                                <span class="text-center uppercase text-lg text-[#06402b] font-semibold">Ideal Air Quality
                                        Ranges</span>
                                <div  class="">
                                    <p class="text-sm indent-8 text-justify leading-relaxed">Ideal air quality is
                                        considered "Good" (0-25 on the Air Quality Index or AQI), posing little to no
                                        risk to health. As the AQI increases, air quality becomes "Fair" (25.1-35),
                                        "Unhealthy for Sensitive Groups" (35.1-45), "Very Unhealthy" (45.1-55), "Acutely
                                        Unhealthy" (55.1-90), and finally "Hazardous" (90.1 and above), with each level
                                        posing progressively greater health risks, especially for sensitive
                                        groups.</p>
                                </div>
                            </div>
                            <!-- Box4 -->
                            <div 
                                class="bg-white w-full lg:w-[48%] min-h-50 py-3 px-5 flex flex-col shadow-lg rounded-lg items-start gap-y-1 border-t-3 border-[#06402b] hover:-translate-y-2 hover:scale-101 duration-300 transform">
                                <span class="text-center uppercase text-lg text-[#06402b] font-semibold">How air quality affects
                                        human health</span>
                                <div  class="">
                                    <p class="text-sm indent-8 text-justify leading-relaxed">Poor air quality affects
                                        human health by causing a range of issues, from respiratory illnesses like
                                        asthma and pneumonia to cardiovascular diseases, strokes, and lung cancer. Small
                                        particles can penetrate deep into the lungs and bloodstream, leading to
                                        irritation, inflammation, and systemic damage. Vulnerable populations such as
                                        children, the elderly, and those with pre-existing health conditions are
                                        disproportionately at risk.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div x-show="activeTab === 'sound'" x-transition
                        class="flex flex-col w-[90%] h-auto items-center gap-y-10 px-3 lg:px-10 py-5">
                        <div class="flex flex-col w-[80%] items-center gap-y-3 mb-3">
                            <span class="text-xl font-semibold uppercase text-center text-[#06402b]">What is Sound
                                Level?</span>
                            <p class="text-base text-center leading-relaxed">Sound level is a logarithmic measurement of
                                sound pressure, expressed in decibels (dB), that indicates how loud a sound is. It
                                reflects the wide range of sound intensities the human ear can perceive, from the
                                quietest audible sound ((0) dB) to the threshold of pain ((120)–(140) dB). For example,
                                normal speech is around (60) dB, while a rock concert is about (120) dB. </p>
                        </div>
                        <div class="flex flex-col lg:flex-row w-full justify-center gap-x-8 gap-y-3 items-start">
                            <!-- Box1 -->
                            <div 
                                class="bg-white w-full lg:w-[48%] min-h-65 py-3 px-5 flex flex-col shadow-lg rounded-lg items-start gap-y-1 border-t-3 border-[#06402b] hover:-translate-y-2 hover:scale-101 duration-300 transform">
                                <span class="text-center uppercase text-lg text-[#06402b] font-semibold">Common noise sources and
                                        their decibels values</span>
                                <div  class="">
                                    <p class="text-sm indent-8 text-justify leading-relaxed">Common noise sources range
                                        from a quiet room at 30 dB to loud concerts and sirens at 110–130 dB. Sounds
                                        like a normal conversation are around 60 dB, while a lawnmower or a power tool
                                        can be about 90–100 dB, and events like fireworks or jet engines can reach
                                        140–160 dB or higher. Prolonged exposure to noises above 85 dB can cause hearing
                                        damage</p>
                                </div>
                            </div>
                            <!-- Box2 -->
                            <div 
                                class="bg-white w-full lg:w-[48%] min-h-65 py-3 px-5 flex flex-col shadow-lg rounded-lg items-start gap-y-1 border-t-3 border-[#06402b] hover:-translate-y-2 hover:scale-101 duration-300 transform">
                                <span class="text-center uppercase text-lg text-[#06402b] font-semibold">Safe exposure
                                        limits</span>
                                <div  class="">
                                    <p class="text-sm indent-8 text-justify leading-relaxed">Safe exposure limits vary
                                        depending on the substance and the context (e.g., workplace, emergency) and are
                                        defined by different organizations like OSHA, NIOSH, and ACGIH. Key terms
                                        include Time-Weighted Average (TWA), which is the average exposure over an
                                        8-hour workday, and Short-Term Exposure Limit (STEL), a 15-minute limit that
                                        should not be exceeded more than four times a day. For emergencies, public
                                        guidelines like ERPGs (Emergency Response Planning Guidelines) are used, with
                                        different levels for no effects, no serious effects, and not life-threatening
                                        situations. </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Separator -->
            <div class="flex flex-col justify-center items-center gap-y-0.5 w-full">
                <div class="w-[50%] border rounded-full border-[#06402b]"></div>
                <div class="w-[40%] border rounded-full border-yellow-500"></div>
                <div class="w-[30%] border rounded-full border-[#06402b]"></div>
            </div>
            <!-- Combined Impact -->
            <div class="flex flex-col w-[90%] h-auto items-center gap-y-12 px-3 lg:px-10 py-5">
                <div class="flex flex-col w-[80%] items-center gap-y-3">
                    <span class="text-xl font-semibold uppercase text-center text-[#06402b]">How air and noise pollution
                        together affect wellbeing</span>
                    <p class="text-base text-center leading-relaxed">Air and noise pollution together can negatively
                        affect wellbeing by amplifying stress responses, increasing inflammation, and disrupting sleep,
                        which can lead to a greater risk of mental health issues like anxiety and depression, and
                        physical health problems like cardiovascular disease and metabolic syndrome. The combined
                        exposure creates a heightened "allostatic load," where the body's stress-coping systems are
                        overwhelmed.</p>
                </div>
                <div class="flex flex-col w-full h-auto items-center gap-y-5">
                    <span class="text-xl font-semibold uppercase text-center text-[#06402b]">How they interact</span>
                    <div class="flex flex-col lg:flex-row justify-between w-full items-start gap-y-5">
                        <div class="flex flex-col items-center group relative bg-white shadow-lg rounded-xl w-full lg:w-[32%] h-70 overflow-hidden p-5 gap-y-2 hover:scale-105 duration-300">
                            <div class="absolute top-0 left-0 w-full h-[4px] bg-[#06402b] origin-center scale-x-0 transition-transform duration-700 group-hover:scale-x-100">
                            </div>
                            <span class="text-center uppercase text-lg text-[#06402b] font-semibold">Amplified stress response</span>
                            <p class="text-sm indent-4 text-justify leading-relaxed">Both air and noise pollution are stressors that trigger the body's stress response system (e.g., the HPA axis and sympathetic nervous system). When combined, they can accelerate the progression to "allostatic overload," a state where the body's ability to cope is overwhelmed, increasing the risk of disease.</p>
                        </div>
                        <div class="flex flex-col items-center group relative bg-white shadow-lg rounded-xl w-full lg:w-[32%] h-70 overflow-hidden p-5 gap-y-2 hover:scale-105 duration-300">
                            <div class="absolute top-0 left-0 w-full h-[4px] bg-[#06402b] origin-center scale-x-0 transition-transform duration-700 group-hover:scale-x-100">
                            </div>
                            <span class="text-center uppercase text-lg text-[#06402b] font-semibold">Increased inflammation and oxidative stress</span>
                            <p class="text-sm indent-4 text-justify leading-relaxed">Air pollution induces a persistent, low-grade inflammatory state, while noise pollution can trigger similar inflammatory and oxidative stress responses. Their combined effects can worsen these processes, potentially exacerbating respiratory issues and systemic inflammation.</p>
                        </div>
                        <div class="flex flex-col items-center group relative bg-white shadow-lg rounded-xl w-full lg:w-[32%] h-70 overflow-hidden p-5 gap-y-2 hover:scale-105 duration-300">
                            <div class="absolute top-0 left-0 w-full h-[4px] bg-[#06402b] origin-center scale-x-0 transition-transform duration-700 group-hover:scale-x-100">
                            </div>
                            <span class="text-center uppercase text-lg text-[#06402b] font-semibold">Synergistic impact on health outcomes</span>
                            <p class="text-sm indent-4 text-justify leading-relaxed">Studies show that co-exposure to air and noise pollution has stronger associations with negative health outcomes than exposure to either one alone. For example, one study found a stronger association between the combination of high noise and high (NO₂) and an increased risk of ischemic stroke.</p>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col w-full h-auto items-center gap-y-5">
                    <span class="text-xl font-semibold uppercase text-center text-[#06402b]">Specific effects on wellbeing</span>   
                    <!-- Box1 -->
                    <div 
                        class="bg-white w-full py-3 px-5 flex flex-col shadow-lg rounded-lg items-start gap-y-1 border-l-5 border-[#06402b] hover:-translate-y-2 hover:scale-101 duration-300 transform">
                        <button 
                            class="flex w-full justify-between items-center h-auto px-2">
                            <span class="text-sm font-semibold uppercase text-start">Mental health</span>
                        </button>
                        <div  class="gap-y-2">
                            <p class="text-sm text-justify leading-relaxed"><span class="font-semibold">• Anxiety and depression: </span>Higher exposure to both air and noise pollution is linked to a greater risk of developing anxiety, depression, and other mental health issues. This is particularly concerning for young people during adolescence, a critical period for psychological development.</p>
                            <p class="text-sm text-justify leading-relaxed"><span class="font-semibold">• Cognitive impairment: </span>The combined effects can lead to cognitive impairment and distraction, impacting learning and overall cognitive function.</p>
                        </div>
                    </div>
                    <!-- Box2 -->
                    <div 
                        class="bg-white w-full py-3 px-5 flex flex-col shadow-lg rounded-lg items-start gap-y-1 border-l-5 border-[#06402b] hover:-translate-y-2 hover:scale-101 duration-300 transform">
                        <button 
                            class="flex w-full justify-between items-center h-auto px-2">
                            <span class="text-sm font-semibold uppercase text-start">Physical health</span>
                        </button>
                        <div  class="gap-y-2">
                            <p class="text-sm text-justify leading-relaxed"><span class="font-semibold">• Cardiovascular and metabolic issues: </span>Co-exposure increases the risk of developing metabolic syndrome (MetS) and its components, such as high blood pressure, high triglycerides, and low HDL cholesterol. Chronic exposure to noise pollution alone is also linked to cardiovascular diseases like ischemic heart disease.</p>
                            <p class="text-sm text-justify leading-relaxed"><span class="font-semibold">• Sleep disturbance: </span>Co-exposure increases the risk of developing metabolic syndrome (MetS) and its components, such as high blood pressure, high triglycerides, and low HDL cholesterol. Chronic exposure to noise pollution alone is also linked to cardiovascular diseases like ischemic heart disease.</p>
                        </div>
                    </div>
                    <!-- Box3 -->
                    <div 
                        class="bg-white w-full py-3 px-5 flex flex-col shadow-lg rounded-lg items-start gap-y-1 border-l-5 border-[#06402b] hover:-translate-y-2 hover:scale-101 duration-300 transform">
                        <button 
                            class="flex w-full justify-between items-center h-auto px-2">
                            <span class="text-sm font-semibold uppercase text-start">Vulnerable Populations</span>
                        </button>
                        <div  class="gap-y-2">
                            <p class="text-sm text-justify leading-relaxed">Children and adolescents are particularly vulnerable. For example, aircraft noise has been linked to reading impairment in school children, and both air and noise pollution can have a greater impact on their developing nervous systems and mental wellbeing.</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Separator -->
            <div class="flex flex-col justify-center items-center gap-y-0.5 w-full">
                <div class="w-[50%] border rounded-full border-[#06402b]"></div>
                <div class="w-[40%] border rounded-full border-yellow-500"></div>
                <div class="w-[30%] border rounded-full border-[#06402b]"></div>
            </div>
            <!-- Environmental -->
            <div class="flex flex-col w-[90%] h-auto items-center gap-y-12 px-3 lg:px-10 py-5">
                <div class="flex flex-col w-full items-center gap-y-5">
                    <div class="flex flex-col w-[80%] items-center gap-y-3">
                        <span class="text-xl font-semibold uppercase text-center text-[#06402b]">Environmental and urban impacts</span>
                        <p class="text-base text-center leading-relaxed">Environmental and urban impacts are the significant, often negative, environmental consequences of urbanization, including increased air and water pollution, habitat loss, and the urban heat island effect. These issues are driven by high population density, resource consumption, and waste generation, which are exacerbated by the concentration of people in cities and their contribution to climate change. Effective urban planning is crucial for mitigating these impacts by addressing issues like resource management, waste disposal, and the integration of green spaces.</p>
                    </div>
                    <div class="flex flex-col lg:flex-row justify-between w-full h-auto items-start gap-y-5">
                        <div class="flex flex-col items-center justify-start group relative bg-white shadow-lg rounded-xl w-full lg:w-[15%] h-full lg:min-h-70 overflow-hidden hover:scale-105 duration-300 py-10 px-5 gap-y-5">
                            <div class="absolute top-0 left-0 w-full h-[4px] bg-[#06402b] origin-center scale-x-0 transition-transform duration-700 group-hover:scale-x-100">
                            </div>
                            <span class="text-3xl rounded-full text-white bg-[#06402B] w-14 h-14 flex justify-center items-center group-hover:bg-yellow-500 font-black">1</span>
                            <span class="text-center uppercase text-lg text-[#06402b] font-semibold">Air and water pollution</span>
                        </div>
                        <div class="flex flex-col items-center justify-start group relative bg-white shadow-lg rounded-xl w-full lg:w-[15%] h-full lg:min-h-70 overflow-hidden hover:scale-105 duration-300 py-10 px-5 gap-y-5">
                            <div class="absolute top-0 left-0 w-full h-[4px] bg-[#06402b] origin-center scale-x-0 transition-transform duration-700 group-hover:scale-x-100">
                            </div>
                            <span class="text-3xl rounded-full text-white bg-[#06402B] w-14 h-14 flex justify-center items-center group-hover:bg-yellow-500 font-black">2</span>
                            <span class="text-center uppercase text-lg text-[#06402b] font-semibold">Habitat loss and biodiversity reduction</span>
                        </div>
                        <div class="flex flex-col items-center justify-start group relative bg-white shadow-lg rounded-xl w-full lg:w-[15%] h-full lg:min-h-70 overflow-hidden hover:scale-105 duration-300 py-10 px-5 gap-y-5">
                            <div class="absolute top-0 left-0 w-full h-[4px] bg-[#06402b] origin-center scale-x-0 transition-transform duration-700 group-hover:scale-x-100">
                            </div>
                            <span class="text-3xl rounded-full text-white bg-[#06402B] w-14 h-14 flex justify-center items-center group-hover:bg-yellow-500 font-black">3</span>
                            <span class="text-center uppercase text-lg text-[#06402b] font-semibold">Resource depletion</span>
                        </div>
                        <div class="flex flex-col items-center justify-start group relative bg-white shadow-lg rounded-xl w-full lg:w-[15%] h-full lg:min-h-70 overflow-hidden hover:scale-105 duration-300 py-10 px-5 gap-y-5">
                            <div class="absolute top-0 left-0 w-full h-[4px] bg-[#06402b] origin-center scale-x-0 transition-transform duration-700 group-hover:scale-x-100">
                            </div>
                            <span class="text-3xl rounded-full text-white bg-[#06402B] w-14 h-14 flex justify-center items-center group-hover:bg-yellow-500 font-black">4</span>
                            <span class="text-center uppercase text-lg text-[#06402b] font-semibold">Waste generation</span>
                        </div>
                        <div class="flex flex-col items-center justify-start group relative bg-white shadow-lg rounded-xl w-full lg:w-[15%] h-full lg:min-h-70 overflow-hidden hover:scale-105 duration-300 py-10 px-5 gap-y-5">
                            <div class="absolute top-0 left-0 w-full h-[4px] bg-[#06402b] origin-center scale-x-0 transition-transform duration-700 group-hover:scale-x-100">
                            </div>
                            <span class="text-3xl rounded-full text-white bg-[#06402B] w-14 h-14 flex justify-center items-center group-hover:bg-yellow-500 font-black">5</span>
                            <span class="text-center uppercase text-lg text-[#06402b] font-semibold">Urban heat island effect</span>
                        </div>
                        <div class="flex flex-col items-center justify-start group relative bg-white shadow-lg rounded-xl w-full lg:w-[15%] h-full lg:min-h-70 overflow-hidden hover:scale-105 duration-300 py-10 px-5 gap-y-5">
                            <div class="absolute top-0 left-0 w-full h-[4px] bg-[#06402b] origin-center scale-x-0 transition-transform duration-700 group-hover:scale-x-100">
                            </div>
                            <span class="text-3xl rounded-full text-white bg-[#06402B] w-14 h-14 flex justify-center items-center group-hover:bg-yellow-500 font-black">6</span>
                            <span class="text-center uppercase text-lg text-[#06402b] font-semibold">Climate change contribution</span>
                        </div>
                    </div> 
                </div>
                <div class="flex flex-col lg:flex-row w-full h-auto items-start justify-between gap-y-5">
                    <div class="group flex flex-col w-full lg:w-[33%] min-h-80 gap-y-5 p-5 bg-white rounded-lg shadow-lg relative overflow-hidden hover:scale-102 duration-300">
                        <div class="absolute top-0 left-0 w-full h-[4px] bg-[#06402b] origin-center scale-x-0 transition-transform duration-700 group-hover:scale-x-100"></div>
                        <span class="text-xl font-semibold uppercase text-center text-[#06402b]">Impacts on natural hazards</span>  
                        <div class="flex flex-col justify-between w-full items-start gap-x-5 gap-y-5">
                            <p class="text-sm text-justify leading-relaxed"><span class="font-semibold">• Increased vulnerability: </span>Urban expansion and the modification of landscapes make cities more vulnerable to natural hazards like floods and hurricanes.</p>
                            <p class="text-sm text-justify leading-relaxed"><span class="font-semibold">• Amplified consequences: </span>The high concentration of people in cities amplifies the potential for human and economic loss during natural disasters.</p>
                        </div>  
                    </div>
                    <div class="group flex flex-col w-full lg:w-[65%] min-h-80 gap-y-5 p-5 bg-white rounded-lg shadow-lg relative overflow-hidden hover:scale-102 duration-300">
                        <div class="absolute top-0 left-0 w-full h-[4px] bg-[#06402b] origin-center scale-x-0 transition-transform duration-700 group-hover:scale-x-100"></div>
                        <span class="text-xl font-semibold uppercase text-center text-[#06402b]">Addressing the impacts</span>  
                        <div class="flex flex-col justify-between w-full items-start gap-y-4">
                            <p class="text-sm text-justify leading-relaxed"><span class="font-semibold">• Sustainable urban planning: </span> Implementing thoughtful urban planning is essential for managing growth, preserving natural resources, and protecting residents.</p>
                            <p class="text-sm text-justify leading-relaxed"><span class="font-semibold">• Resource-efficient technologies: </span>Using technologies that reduce energy consumption, manage waste more effectively, and improve the efficiency of water use can help mitigate environmental strain.</p>
                            <p class="text-sm text-justify leading-relaxed"><span class="font-semibold">• Green infrastructure: </span>Incorporating more green spaces, such as parks and trees, can help reduce the urban heat island effect, improve air quality, and manage stormwater runoff.</p>
                            <p class="text-sm text-justify leading-relaxed"><span class="font-semibold">• Climate action: </span>Cities can reduce their contribution to climate change by adopting renewable energy sources and implementing cleaner production techniques.</p>
                        </div>  
                    </div>
                </div>
            </div>
            <!-- Separator -->
            <div class="flex flex-col justify-center items-center gap-y-0.5 w-full">
                <div class="w-[50%] border rounded-full border-[#06402b]"></div>
                <div class="w-[40%] border rounded-full border-yellow-500"></div>
                <div class="w-[30%] border rounded-full border-[#06402b]"></div>
            </div>
            <!-- Environmental -->
            <div class="flex flex-col w-[90%] h-auto items-center gap-y-12 px-3 lg:px-10 py-5">
                <div class="flex flex-col w-full items-center gap-y-5">
                    <div class="flex flex-col w-[80%] items-center gap-y-3">
                        <span class="text-xl font-semibold uppercase text-center text-[#06402b]">How to monitor air and sound using sensors or apps</span>
                        <p class="text-base text-center leading-relaxed">You can monitor air and sound using either smartphone apps or dedicated hardware sensors. For sound, use smartphone apps like Decibel X or NIOSH Sound Level Meter to measure noise levels, or for air, use dedicated air quality monitors like uHoo or Huma-i that measure pollutants like PM2.5, CO₂, and VOCs. You can also build a DIY system with sensors connected to a microcontroller like an Arduino or ESP8266 to create a custom monitoring setup that can send data to a smartphone app or web server.</p>
                    </div>
                </div>  
                <div class="flex flex-col w-full items-center gap-y-5">
                    <div class="flex flex-col w-[80%] items-center gap-y-3">
                        <span class="text-xl font-semibold uppercase text-center text-[#06402b]">Steps individuals and communities can take</span>
                        <p class="text-base text-center leading-relaxed">Individuals and communities can take steps like reducing, reusing, and recycling waste, conserving water and energy, using sustainable transportation, and making conscious purchasing decisions. Community-level actions also include organizing cleanups, planting trees, supporting local and sustainable businesses, and advocating for environmentally friendly policies.</p>
                    </div>
                </div>  
                <div class="flex flex-col w-full items-center gap-y-5">
                    <div class="flex flex-col w-[80%] items-center gap-y-3">
                        <span class="text-xl font-semibold uppercase text-center text-[#06402b]">Health & lifestyle recommendations</span>
                        <p class="text-base text-center leading-relaxed">To improve your health and lifestyle, focus on a balanced diet rich in fruits and vegetables, regular physical activity for at least 150 minutes a week, and adequate sleep of 7-9 hours per night. Other key recommendations include managing stress, maintaining social connections, limiting alcohol, and avoiding smoking.</p>
                    </div>
                    <div class="flex flex-col lg:flex-row justify-between w-[90%] h-auto items-start gap-y-5">
                        <div class="flex flex-col items-center justify-start group relative bg-white shadow-lg rounded-xl w-full lg:w-[23%] h-full lg:min-h-70 overflow-hidden hover:scale-105 duration-300 py-14 px-5 gap-y-5">
                            <div class="absolute top-0 left-0 w-full h-[4px] bg-[#06402b] origin-center scale-x-0 transition-transform duration-700 group-hover:scale-x-100">
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14 p-3 text-white bg-[#06402B] rounded-full group-hover:bg-yellow-500" viewBox="0 0 24 24"><path fill="currentColor" d="M22 18a4 4 0 0 1-4 4h-4a4 4 0 0 1-4-4v-2h12v2M4 3h10a2 2 0 0 1 2 2v9H8v5H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2m0 3v2h2V6H4m10 2V6H8v2h6M4 10v2h2v-2H4m4 0v2h6v-2H8m-4 4v2h2v-2H4Z"/></svg>
                            <span class="text-center uppercase text-lg text-[#06402b] font-semibold">Nutrition</span>
                        </div>
                        <div class="flex flex-col items-center justify-start group relative bg-white shadow-lg rounded-xl w-full lg:w-[23%] h-full lg:min-h-70 overflow-hidden hover:scale-105 duration-300 py-14 px-5 gap-y-5">
                            <div class="absolute top-0 left-0 w-full h-[4px] bg-[#06402b] origin-center scale-x-0 transition-transform duration-700 group-hover:scale-x-100">
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14 p-3 text-white bg-[#06402B] rounded-full group-hover:bg-yellow-500" viewBox="0 0 24 24"><path fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2 12h1m3-4H4a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h2m0-9v10a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 5h6m0-5v10a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1h-1a1 1 0 0 0-1 1zm3 1h2a1 1 0 0 1 1 1v6a1 1 0 0 1-1 1h-2m4-4h-1"/></svg>
                            <span class="text-center uppercase text-lg text-[#06402b] font-semibold">Physical Activity</span>
                        </div>
                        <div class="flex flex-col items-center justify-start group relative bg-white shadow-lg rounded-xl w-full lg:w-[23%] h-full lg:min-h-70 overflow-hidden hover:scale-105 duration-300 py-14 px-5 gap-y-5">
                            <div class="absolute top-0 left-0 w-full h-[4px] bg-[#06402b] origin-center scale-x-0 transition-transform duration-700 group-hover:scale-x-100">
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14 p-3 text-white bg-[#06402B] rounded-full group-hover:bg-yellow-500" viewBox="0 0 50 50"><path fill="currentColor" d="M49 17c0-.55-.45-1-1-1H35c-.55 0-1-.45-1-1V2c0-.55-.45-1-1-1H17c-.55 0-1 .45-1 1v13c0 .55-.45 1-1 1H2c-.55 0-1 .45-1 1v16c0 .55.45 1 1 1h13c.55 0 1 .45 1 1v13c0 .55.45 1 1 1h16c.55 0 1-.45 1-1V35c0-.55.45-1 1-1h13c.55 0 1-.45 1-1V17z"/></svg>
                            <span class="text-center uppercase text-lg text-[#06402b] font-semibold">Sleep and Mental Health</span>
                        </div>
                        <div class="flex flex-col items-center justify-start group relative bg-white shadow-lg rounded-xl w-full lg:w-[23%] h-full lg:min-h-70 overflow-hidden hover:scale-105 duration-300 py-14 px-5 gap-y-5">
                            <div class="absolute top-0 left-0 w-full h-[4px] bg-[#06402b] origin-center scale-x-0 transition-transform duration-700 group-hover:scale-x-100">
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14 p-3 text-white bg-[#06402B] rounded-full group-hover:bg-yellow-500" viewBox="0 0 16 16"><path fill="currentColor" fill-rule="evenodd" d="M14.98 2.5A6.37 6.37 0 0 0 15 2V1h-1.75a6.003 6.003 0 0 0-5.761 4.32A5.99 5.99 0 0 0 2.75 3H1v1a6 6 0 0 0 6 6h.25v4.25a.75.75 0 0 0 1.5 0V8H9a6 6 0 0 0 5.98-5.5Zm-6.203 4a4.5 4.5 0 0 1 4.473-4h.223A4.5 4.5 0 0 1 9 6.5h-.223Zm-6.027-2a4.5 4.5 0 0 1 4.473 4H7a4.5 4.5 0 0 1-4.473-4h.223Z" clip-rule="evenodd"/></svg>
                            <span class="text-center uppercase text-lg text-[#06402b] font-semibold">General Well-being</span>
                        </div>
                    </div>  
                </div>  
            </div>
        </div>
    </div>
</x-layout>