<x-layout>
    <div class="h-auto w-full flex flex-col justify-start items-center gap-y-2 pb-5">
        <img src="{{ asset('landscape.jpg') }}" alt="landscape" class="w-full h-60 shadow-md">
        <div class="w-full h-auto rounded-3xl flex flex-col gap-y-3 items-center">
            <div x-data="{ activeTab: 'aqi' }" class="w-full h-full">
                <!-- Tab header -->
                <div class="flex flex-row justify-between h-[70px] w-full">
                    <div class="flex flex-row bg-white w-full border-b border-[#a8a8a8]">
                        <button
                            class="text-2xl w-[50%] cursor-pointer"
                            @click="activeTab = 'aqi'"
                            :class="activeTab === 'aqi'
                                    ? 'text-[#06402b] font-semibold bg-white border-[#06402b] border-b-2'
                                    : 'text-black border-b border-transparent hover:text-blue-500'">
                            Air Quality
                        </button>
    
                        <button
                            class="text-2xl w-[50%] cursor-pointer"
                            @click="activeTab = 'sound'"
                            :class="activeTab === 'sound'
                                    ? 'text-[#06402b] font-semibold bg-white border-[#06402b] border-b-2'
                                    : 'text-[#06402b] border-b border-transparent hover:text-blue-500'">
                            Sound Level
                        </button>
                    </div>
                </div>

                <!-- Tab content -->
                <div class="border border-white rounded-b-3xl h-auto bg-white">
                    <div x-show="activeTab === 'aqi'" x-transition
                        class="flex flex-col w-full h-auto items-center gap-y-10 px-3 lg:px-10 py-5"> 
                        <div class="flex flex-col lg:flex-row w-full items-center justify-center gap-y-5">
                            <div class="flex flex-col w-full lg:w-[60%] items-start gap-y-3 lg:pr-8">    
                                <span class="text-2xl font-semibold uppercase text-center lg:text-start">What is Air Quality Index (AQI)?</span>
                                <span class="text-xl indent-8">The Air Quality Index (AQI) is a numerical and color-coded system used to report how polluted the air is and what associated health effects may be a concern. It helps people, especially those with heart or lung conditions, decide when to limit outdoor activity. The index measures pollutants like ozone, particle pollution, carbon monoxide, sulfur dioxide, and nitrogen dioxide, and ranges from 0 to 99+.</span>
                            </div>
                            <img src="{{ asset('kid.jpg') }}" alt="" class="w-full lg:w-[40%] h-60 lg:h-48 rounded-xl shadow-md">
                        </div>
                        <div class="w-[95%] rounded border border-[#06402b]"></div>
                        <div class="flex flex-col lg:flex-row w-full items-center justify-center gap-y-5">
                            <img src="{{ asset('six.jpg') }}" alt="" class="w-full lg:w-[40%] h-60 lg:h-52 rounded-xl lg:px-16">
                            <div class="flex flex-col w-full lg:w-[60%] items-center lg:items-start gap-y-3 lg:pl-8">    
                                <span class="text-2xl font-semibold uppercase text-center lg:text-start">How is AQI measured (PM2.5, PM10, CO, NO₂)?</span>
                                <span class="text-xl indent-8">AQI is measured by taking hourly readings of specific pollutants like PM2.5, PM10, CO, and NO₂, converting each concentration into a sub-index, and then using the highest sub-index value to determine the overall AQI. Each pollutant is measured in a specific unit (e.g., µg/m³) for particulate matter) and compared against breakpoints to convert it into a single AQI value, with the highest of these values being the final reported AQ.</span>
                            </div>
                        </div>
                        <div class="w-[95%] rounded border border-[#06402b]"></div>
                        <div class="flex flex-col lg:flex-row w-full items-center justify-center gap-y-5">
                            <div class="flex flex-col w-full lg:w-[60%] items-start gap-y-3 lg:pr-8">    
                                <span class="text-2xl font-semibold uppercase text-center lg:text-start">Common sources of Air Pollution</span>
                                <span class="text-xl indent-8">Common sources of air pollution include human activities like vehicle and industrial emissions (from factories and power plants burning fossil fuels) and area sources such as agricultural activities, construction, and waste burning. Natural sources also contribute, including dust storms, wildfires, and volcanic eruptions.</span>
                            </div>
                            <img src="{{ asset('airpoll.webp') }}" alt="" class="w-full lg:w-[40%] h-60 lg:h-52 rounded-xl lg:px-16">
                        </div>
                        <div class="w-[95%] rounded border border-[#06402b]"></div>
                        <div class="flex flex-col lg:flex-row w-full items-center justify-center gap-y-5">
                            <img src="{{ asset('line.png') }}" alt="" class="w-full lg:w-[40%] h-60 lg:h-52 rounded-xl shadow-md">
                            <div class="flex flex-col w-full lg:w-[60%] items-center lg:items-start gap-y-3 lg:pl-8">    
                                <span class="text-2xl font-semibold uppercase text-center">Ideal Air Quality Ranges</span>
                                <span class="text-xl indent-8">Ideal air quality is considered "Good" (0-25 on the Air Quality Index or AQI), posing little to no risk to health. As the AQI increases, air quality becomes "Fair" (25.1-35), "Unhealthy for Sensitive Groups" (35.1-45), "Very Unhealthy" (45.1-55), "Acutely Unhealthy" (55.1-90), and finally "Hazardous" (90.1 and above), with each level posing progressively greater health risks, especially for sensitive groups.</span>
                            </div>
                        </div> 
                        <div class="w-[95%] rounded border border-[#06402b]"></div>
                        <div class="flex flex-col w-full gap-y-5 items-center">
                            <div class="flex flex-row w-full items-center justify-center">
                                <div class="flex flex-col w-full items-start gap-y-3">    
                                    <span class="text-2xl font-semibold uppercase text-center lg:text-start">How air quality affects human health</span>
                                    <span class="text-xl indent-8">Poor air quality affects human health by causing a range of issues, from respiratory illnesses like asthma and pneumonia to cardiovascular diseases, strokes, and lung cancer. Small particles can penetrate deep into the lungs and bloodstream, leading to irritation, inflammation, and systemic damage. Vulnerable populations such as children, the elderly, and those with pre-existing health conditions are disproportionately at risk.</span>
                                </div>
                            </div> 
                            <div class="flex flex-col lg:flex-row w-full lg:w-[95%] items-center justify-center gap-y-5">
                                <img src="{{ asset('term.jpg') }}" alt="" class="w-full lg:w-[30%] h-60 lg:h-76 rounded-xl shadow-md">
                                <div class="flex flex-col w-full lg:w-[70%] items-start gap-y-3 lg:pl-8">    
                                    <span class="text-2xl font-semibold uppercase">Short-term and long-term effects</span>
                                    <span class="text-xl">• <span class="font-semibold"> Respiratory issues: </span> Air pollution can trigger asthma attacks, cause wheezing, coughing, and lead to bronchitis, respiratory infections, and reduced lung function.</span>
                                    <span class="text-xl">• <span class="font-semibold"> Cardiovascular problems: </span>Fine particulate matter can enter the bloodstream, significantly increasing the risk of heart attacks, strokes, and ischemic heart disease.</span>
                                    <span class="text-xl">• <span class="font-semibold"> Other diseases: </span> Exposure is linked to lung cancer, other cancers, and new health concerns like diabetes, cataracts, and cognitive impairment. </span>
                                    <span class="text-xl">• <span class="font-semibold"> Reproductive health: </span> There is evidence that poor air quality is associated with adverse pregnancy outcomes, such as stillbirth and miscarriage.  </span>
                                </div>
                            </div> 
                            <div class="flex flex-col lg:flex-row w-full lg:w-[95%] items-center justify-center gap-y-5">
                                <img src="{{ asset('harm.jpg') }}" alt="" class="w-full lg:w-[30%] h-60 lg:h-52 rounded-xl shadow-md">
                                <div class="flex flex-col w-full lg:w-[70%] items-start gap-y-3 lg:pl-8">    
                                    <span class="text-2xl font-semibold uppercase">How pollution causes harm</span>
                                    <span class="text-xl">• <span class="font-semibold"> Particle size: </span> Smaller particles (PM2.5) are especially dangerous because they can bypass the body's defenses and enter the bloodstream, affecting multiple organs. </span>
                                    <span class="text-xl">• <span class="font-semibold"> Increased vulnerability: </span> Pollutants can cause inflammation and irritation in the respiratory tract and other parts of the body. </span>
                                    <span class="text-xl">• <span class="font-semibold"> Other diseases: </span> Air pollution can severely worsen the health of those who are already ill. </span>
                                </div>
                            </div> 
                            <div class="flex flex-col lg:flex-row w-full lg:w-[95%] items-center justify-center gap-y-5">
                                <img src="{{ asset('risk.jpg') }}" alt="" class="w-full lg:w-[30%] h-60 lg:h-82 rounded-xl shadow-md">
                                <div class="flex flex-col w-full lg:w-[70%] items-start gap-y-3 lg:pl-8">    
                                    <span class="text-2xl font-semibold uppercase">Who is most at risk</span>
                                    <span class="text-xl">• <span class="font-semibold"> Children: </span> Their lungs are still developing, and they breathe at a higher rate than adults, making them more susceptible to long-term damage. </span>
                                    <span class="text-xl">• <span class="font-semibold"> The Elderly: </span> Older adults often have pre-existing conditions that make them more vulnerable. </span>
                                    <span class="text-xl">• <span class="font-semibold"> People with existing illnesses: </span> Individuals with asthma or heart disease are more likely to experience severe health effects. </span>
                                    <span class="text-xl">• <span class="font-semibold"> Low-income communities and certain minority groups: </span> These populations are often disproportionately exposed to higher levels of air pollution and have less access to quality healthcare, increasing their risk.  </span>
                                </div>
                            </div> 
                        </div>
                    </div>
                    <div x-show="activeTab === 'sound'" x-transition
                        class="flex flex-col w-full h-auto items-center gap-y-10 px-3 lg:px-10 py-5"> 
                        <div class="flex flex-col lg:flex-row w-full items-center justify-center gap-y-5">
                            <div class="flex flex-col w-full lg:w-[60%] items-start gap-y-3 lg:pr-8">    
                                <span class="text-2xl font-semibold uppercase text-center lg:text-start">What is Sound Level?</span>
                                <span class="text-xl indent-8">Sound level is a logarithmic measurement of sound pressure, expressed in decibels (dB), that indicates how loud a sound is. It reflects the wide range of sound intensities the human ear can perceive, from the quietest audible sound ((0) dB) to the threshold of pain ((120)–(140) dB). For example, normal speech is around (60) dB, while a rock concert is about (120) dB. </span>
                            </div>
                            <img src="{{ asset('level.jpg') }}" alt="" class="w-full lg:w-[40%] h-60 lg:h-48 rounded-xl lg:px-20">
                        </div>
                        <div class="w-[95%] rounded border border-[#06402b]"></div>
                        <div class="flex flex-col lg:flex-row w-full items-center justify-center gap-y-5">
                            <img src="{{ asset('common.jpg') }}" alt="" class="w-full lg:w-[40%] h-60 lg:h-52 rounded-xl lg:px-16">
                            <div class="flex flex-col w-full lg:w-[60%] items-start gap-y-3 lg:pl-8">    
                                <span class="text-2xl font-semibold uppercase text-center lg:text-start">Common noise sources and their decibels values</span>
                                <span class="text-xl indent-8">Common noise sources range from a quiet room at 30 dB to loud concerts and sirens at 110–130 dB. Sounds like a normal conversation are around 60 dB, while a lawnmower or a power tool can be about 90–100 dB, and events like fireworks or jet engines can reach 140–160 dB or higher. Prolonged exposure to noises above 85 dB can cause hearing damage</span>
                            </div>
                        </div>
                        <div class="w-[95%] rounded border border-[#06402b]"></div>
                        <div class="flex flex-col lg:flex-row w-full items-center justify-center gap-y-5">
                            <div class="flex flex-col w-full lg:w-[60%] items-center lg:items-start gap-y-3 lg:pr-8">    
                                <span class="text-2xl font-semibold uppercase text-center lg:text-start">Safe exposure limits</span>
                                <span class="text-xl indent-8">Safe exposure limits vary depending on the substance and the context (e.g., workplace, emergency) and are defined by different organizations like OSHA, NIOSH, and ACGIH. Key terms include Time-Weighted Average (TWA), which is the average exposure over an 8-hour workday, and Short-Term Exposure Limit (STEL), a 15-minute limit that should not be exceeded more than four times a day. For emergencies, public guidelines like ERPGs (Emergency Response Planning Guidelines) are used, with different levels for no effects, no serious effects, and not life-threatening situations. </span>
                            </div>
                            <img src="{{ asset('self.png') }}" alt="" class="w-full lg:w-[40%] h-64 rounded-xl lg:px-16">
                        </div>
                        <div class="flex flex-col w-full lg:w-[95%] items-center lg:items-start gap-y-3">  
                            <span class="text-2xl font-semibold uppercase">Key types of exposure limits</span>
                            <div class="flex flex-col w-full lg:w-[95%] items-start pl-4 gap-y-3">
                                <span class="text-xl flex flex-row gap-x-2">• <span> <span class="font-semibold">Time-Weighted Average (TWA): </span> An average concentration over an 8-hour workday. For example, OSHA's permissible exposure limit for a specific chemical might be 100 ppm (465 mg/m³) as an 8-hour TWA. </span></span>
                                <span class="text-xl flex flex-row gap-x-2">• <span> <span class="font-semibold">Short-Term Exposure Limit (STEL): </span> A 15-minute TWA exposure that should not be exceeded at any time during a workday. Exposures at the STEL must not be repeated more than four times per day, with at least 60 minutes between each exposure. Transient increases can be up to three times the TLV-TWA, but should not exceed five times the TLV-TWA. </span></span>
                                <span class="text-xl flex flex-row gap-x-2">• <span> <span class="font-semibold">Immediately Dangerous to Life or Health (IDLH): </span> A concentration from which a person could escape within 30 minutes without suffering irreversible health effects. </span></span>
                                <span class="text-xl flex flex-row gap-x-2">• <span> <span class="font-semibold">Emergency Response Planning Guidelines (ERPG): </span> Public exposure guidelines used for modeling emergency releases. </span></span>
                                <div class="flex flex-col w-full items-center pl-6 gap-y-3">
                                    <span class="text-xl flex flex-row gap-x-2 w-full">• <span> <span class="font-semibold">ERPG(1): </span> The maximum concentration that most people can be exposed to for one hour with no more than mild, transient effects. </span></span>
                                    <span class="text-xl flex flex-row gap-x-2 w-full">• <span> <span class="font-semibold">ERPG(2): </span> The maximum concentration that most people can be exposed to for one hour without experiencing serious or irreversible adverse health effects. </span></span>
                                    <span class="text-xl flex flex-row gap-x-2 w-full">• <span> <span class="font-semibold">ERPG(3): </span> The maximum concentration that most people can be exposed to for one hour without being life-threatening. </span></span>
                                </div>
                                <span class="text-xl flex flex-row gap-x-2">• <span> <span class="font-semibold">Ceiling Limit: </span> An exposure that should not be exceeded at any time, even for a short period. </span></span>
                            </div>  
                        </div>
                        <div class="flex flex-col w-full lg:w-[95%] items-center lg:items-start gap-y-3">  
                            <span class="text-2xl font-semibold uppercase text-center lg:text-start">How to find and use safe exposure limits</span>
                            <div class="flex flex-col w-full lg:w-[95%] items-start pl-4 gap-y-3">
                                <span class="text-base flex flex-row gap-x-2">1. <span class="text-xl"> <span class="font-semibold">Identify the substance: </span> Determine the specific chemical or hazard you are exposed to. </span></span>
                                <span class="text-base flex flex-row gap-x-2">2. <span class="text-xl"> <span class="font-semibold">Consult Safety Data Sheets (SDS): </span> SDS are a primary source for exposure limit information. </span></span>
                                <span class="text-base flex flex-row gap-x-2">3. <span class="text-xl"> <span class="font-semibold">Check regulatory and professional guidelines: </span> Refer to limits set by organizations like OSHA, NIOSH, or ACGIH, which can be found on their websites or in scientific databases. </span></span>
                                <span class="text-base flex flex-row gap-x-2">4. <span class="text-xl"> <span class="font-semibold">Consider the context: </span> Workplace limits are designed for healthy adult workers and may not be sufficient for public exposure or for vulnerable individuals. </span></span>
                                <span class="text-base flex flex-row gap-x-2">5. <span class="text-xl"> <span class="font-semibold">Implement control measures: </span> Use engineering controls (e.g., ventilation), administrative controls (e.g., job rotation), and Personal Protective Equipment (PPE) to stay within the limits. </span></span>
                            </div>  
                        </div>
                        <div class="w-[95%] rounded border border-[#06402b]"></div>
                        <div class="flex flex-col w-full gap-y-5 items-start">
                            <div class="flex flex-row w-full items-center justify-center">
                                <div class="flex flex-col w-full items-start gap-y-3">    
                                    <span class="text-2xl font-semibold uppercase text-center lg:text-start">How prolonged noise exposure affects health</span>
                                    <span class="text-xl indent-8">Prolonged noise exposure can lead to hearing loss, stress, and sleep issues, as well as cardiovascular problems, cognitive deficits, and other negative health effects. The auditory system is damaged by loud noise, causing permanent hearing loss and tinnitus. The body's stress response is also triggered, which can lead to high blood pressure and an increased risk of heart attack and other cardiovascular diseases. Noise can also disrupt sleep, leading to daytime fatigue, poor concentration, and other health problems.</span>
                                </div>
                            </div> 
                            <div class="flex flex-row w-full lg:w-[95%] items-start justify-center">
                                <div class="flex flex-col w-full lg:w-[95%] items-start gap-y-3">    
                                    <span class="text-2xl font-semibold">Auditory Effects</span>
                                    <div class="flex flex-col w-full lg:w-[95%] items-start pl-4 gap-y-3">
                                        <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Hearing loss: </span> Excessive exposure to noise can damage the sensitive hair cells in the inner ear, leading to permanent hearing loss that often starts with a loss of high-frequency sounds. </span></span>
                                        <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Tinnitus: </span> This is a constant ringing or buzzing in the ears, which can be a symptom of noise-induced hearing loss. </span></span>
                                        <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Hyperacusis: </span> This is an increased sensitivity to everyday sounds. </span></span>
                                    </div>
                                </div>
                            </div> 
                            <div class="flex flex-row w-full lg:w-[95%] items-center justify-center">
                                <div class="flex flex-col w-full lg:w-[95%] items-start gap-y-3">    
                                    <span class="text-2xl font-semibold">Non-Auditory Effects</span>
                                    <div class="flex flex-col w-full lg:w-[95%] items-start pl-4 gap-y-3">
                                        <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Stress and cardiovascular issues: </span> Noise triggers a stress response, releasing hormones like cortisol and adrenaline. Chronic exposure can lead to a constant stress response, raising blood pressure and increasing the risk of hypertension, heart attack, and other cardiovascular diseases. </span></span>
                                        <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Sleep disruption: </span> Noise can prevent a person from falling asleep and cause them to wake up during the night, leading to fragmented sleep. This can cause daytime sleepiness, fatigue, and reduced cognitive performance. </span></span>
                                        <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Cognitive and mental health effects: </span> Noise can impair concentration, memory, and other cognitive functions. It has also been linked to mental health problems, such as anxiety and depression. </span></span>
                                        <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Other effects: </span> Noise can also affect the immune system and is linked to other health issues, such as type 2 diabetes and changes in blood pressure and muscle cramps. </span></span>
                                    </div>
                                </div>
                            </div> 
                            <div class="flex flex-row w-full lg:w-[95%] items-center justify-center">
                                <div class="flex flex-col w-full lg:w-[95%] items-start gap-y-3">    
                                    <span class="text-2xl font-semibold">Risk Factor</span>
                                    <div class="flex flex-col w-full lg:w-[95%] items-start pl-4 gap-y-3">
                                        <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Loudness: </span> The louder the noise, the faster damage can occur. </span></span>
                                        <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Duration: </span> The longer the exposure, the greater the risk for hearing loss. </span></span>
                                        <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Frequency: </span> The more often you are exposed to noise, the greater the risk. </span></span>
                                    </div>
                                </div>
                            </div> 
                            <div class="flex flex-row w-full lg:w-[95%] items-center justify-center">
                                <div class="flex flex-col w-full lg:w-[95%] items-start gap-y-3">    
                                    <span class="text-2xl font-semibold">Prevention</span>
                                    <div class="flex flex-col w-full lg:w-[95%] items-start pl-4 gap-y-3">
                                        <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Reduce exposure: </span> Lower the volume when listening to music, use earplugs in loud environments, and avoid prolonged exposure to loud noise. </span></span>
                                        <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Seek help: </span> If you experience ringing in your ears, muffled hearing, or difficulty understanding conversations, see a doctor or audiologist. </span></span>
                                        <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Use hearing protection: </span> Wear earplugs or earmuffs in noisy environments, such as concerts, construction sites, or when using loud machinery. </span></span>
                                    </div>
                                </div>
                            </div> 
                        </div>
                        <div class="w-[95%] rounded border border-[#06402b]"></div>
                        <div class="flex flex-col w-full gap-y-5 items-start">
                            <div class="flex flex-row w-full items-center justify-center">
                                <div class="flex flex-col w-full items-center lg:items-start gap-y-3">    
                                    <span class="text-2xl font-semibold uppercase text-center lg:text-start">Sound pollution control tips</span>
                                    <span class="text-xl indent-8"> To control noise pollution, reduce noise at its source by using quieter equipment, lowering appliance and media volumes, and performing regular maintenance. You can also control noise by soundproofing your home, using noise barriers like trees, and wearing personal hearing protection like earplugs. It's also helpful to avoid noisy areas, and to advocate for community-level solutions such as better urban planning and regulations. </span>
                                </div>
                            </div> 
                            <div class="flex flex-row w-full lg:w-[95%] items-center justify-center">
                                <div class="flex flex-col w-full lg:w-[95%] items-start gap-y-3">    
                                    <span class="text-2xl font-semibold">At home</span>
                                    <div class="flex flex-col w-full lg:w-[95%] items-start pl-4 gap-y-3">
                                        <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Lower the volume: </span> Keep the volume of your TV, music systems, and other electronics at a reasonable level. Use headphones when listening to music on your phone. </span></span>
                                        <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Use appliances wisely: </span> Run loud appliances like dishwashers or washing machines when they won't disturb others and close doors to contain the sound. </span></span>
                                        <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Improve sound insulation: </span> Soundproof your home by using sound-absorbing materials like carpets, rugs, and soft furnishings, and consider adding partitions. </span></span>
                                        <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Maintain appliances: </span> Replace old or noisy appliances with newer, quieter models, and check for and fix any rattling or buzzing sounds from existing ones. </span></span>
                                        <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Check a barrier: </span> Plant trees or install fencing to help block out noise from outside sources. </span></span>
                                    </div>
                                </div>
                            </div> 
                            <div class="flex flex-row w-full lg:w-[95%] items-center justify-center">
                                <div class="flex flex-col w-full lg:w-[95%] items-start gap-y-3">    
                                    <span class="text-2xl font-semibold">In the community</span>
                                    <div class="flex flex-col w-full lg:w-[95%] items-start pl-4 gap-y-3">
                                        <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Be mindful of others: </span> Avoid unnecessary honking and avoid loud activities in public areas. </span></span>
                                        <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Report issues: </span> Contact your local government if you are concerned about persistent noise pollution from sources like construction or traffic. </span></span>
                                        <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Advocate for silent zones: </span>  Support the establishment of "silent zones" near schools, hospitals, and residential areas. </span></span>
                                    </div>
                                </div>
                            </div> 
                            <div class="flex flex-row w-full lg:w-[95%] items-center justify-center">
                                <div class="flex flex-col w-full lg:w-[95%] items-start gap-y-3">    
                                    <span class="text-2xl font-semibold">Personal protection</span>
                                    <div class="flex flex-col w-full lg:w-[95%] items-start pl-4 gap-y-3">
                                        <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Use hearing protection: </span> Wear earplugs or ear muffs in loud environments, such as concerts or when using loud machinery. </span></span>
                                        <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Avoid noisy places: </span> If possible, stay away from very noisy areas. </span></span>
                                        <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Take breaks: </span> If you are in a consistently noisy environment, take frequent breaks in a quieter space. </span></span>
                                    </div>
                                </div>
                            </div> 
                        </div>      
                    </div>
                </div>  
            </div>
            <div class="flex flex-col gap-y-5 px-3 lg:px-10 py-8 border-3 border-[#06402b] w-[98%] h-auto rounded-xl">
                <div class="flex flex-col w-full gap-y-5 items-center">
                    <span class="text-2xl font-semibold uppercase text-[#06402b] underline text-start">Combined Impact</span>
                    <div class="flex flex-row w-full items-center justify-center">
                        <div class="flex flex-col w-full items-start gap-y-3">    
                            <span class="text-2xl font-semibold uppercase text-center lg:text-start">How air and noise pollution together affect wellbeing</span>
                            <span class="text-xl indent-8"> Air and noise pollution together can negatively affect wellbeing by amplifying stress responses, increasing inflammation, and disrupting sleep, which can lead to a greater risk of mental health issues like anxiety and depression, and physical health problems like cardiovascular disease and metabolic syndrome. The combined exposure creates a heightened "allostatic load," where the body's stress-coping systems are overwhelmed. </span>
                        </div>
                    </div> 
                    <div class="flex flex-row w-full items-center justify-center">
                        <div class="flex flex-col w-full items-start gap-y-3">    
                            <span class="text-2xl font-semibold">How they interact</span>
                            <div class="flex flex-col w-full items-start pl-4 gap-y-3">
                                <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Amplified stress response: </span> Both air and noise pollution are stressors that trigger the body's stress response system (e.g., the HPA axis and sympathetic nervous system). When combined, they can accelerate the progression to "allostatic overload," a state where the body's ability to cope is overwhelmed, increasing the risk of disease. </span></span>
                                <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Increased inflammation and oxidative stress: </span> Air pollution induces a persistent, low-grade inflammatory state, while noise pollution can trigger similar inflammatory and oxidative stress responses. Their combined effects can worsen these processes, potentially exacerbating respiratory issues and systemic inflammation. </span></span>
                                <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Synergistic impact on health outcomes: </span> Studies show that co-exposure to air and noise pollution has stronger associations with negative health outcomes than exposure to either one alone. For example, one study found a stronger association between the combination of high noise and high (NO₂) and an increased risk of ischemic stroke. </span></span>
                            </div>
                        </div>
                    </div> 
                    <div class="flex flex-row w-full items-center justify-center">
                        <div class="flex flex-col w-full items-start gap-y-3">    
                            <span class="text-2xl font-semibold">Specific effects on wellbeing</span>
                            <div class="flex flex-col w-full items-start pl-4 gap-y-3">
                                <span class="flex flex-row gap-x-2 font-semibold text-xl">• Mental health:</span>
                                <span class="flex flex-row gap-x-2 pl-4">◦ <span class="text-xl"> <span class="font-semibold">Anxiety and depression: </span> Higher exposure to both air and noise pollution is linked to a greater risk of developing anxiety, depression, and other mental health issues. This is particularly concerning for young people during adolescence, a critical period for psychological development. </span></span>
                                <span class="flex flex-row gap-x-2 pl-4">◦ <span class="text-xl"> <span class="font-semibold">Cognitive impairment: </span> The combined effects can lead to cognitive impairment and distraction, impacting learning and overall cognitive function. </span></span>
                            </div>
                            <div class="flex flex-col w-full items-start pl-4 gap-y-3">
                                <span class="flex flex-row gap-x-2 font-semibold text-xl">• Physical health:</span>
                                <span class="flex flex-row gap-x-2 pl-4">◦ <span class="text-xl"> <span class="font-semibold">Cardiovascular and metabolic issues: </span>  Co-exposure increases the risk of developing metabolic syndrome (MetS) and its components, such as high blood pressure, high triglycerides, and low HDL cholesterol. Chronic exposure to noise pollution alone is also linked to cardiovascular diseases like ischemic heart disease. </span></span>
                                <span class="flex flex-row gap-x-2 pl-4">◦ <span class="text-xl"> <span class="font-semibold">Sleep disturbance: </span>  Co-exposure increases the risk of developing metabolic syndrome (MetS) and its components, such as high blood pressure, high triglycerides, and low HDL cholesterol. Chronic exposure to noise pollution alone is also linked to cardiovascular diseases like ischemic heart disease. </span></span>
                            </div>
                            <div class="flex flex-col w-full items-start pl-4 gap-y-3">
                                <span class="flex flex-row gap-x-2 text-xl">• <span class="text-xl"> <span class="font-semibold">Vulnerable populations: </span>  Children and adolescents are particularly vulnerable. For example, aircraft noise has been linked to reading impairment in school children, and both air and noise pollution can have a greater impact on their developing nervous systems and mental wellbeing. </span></span>
                            </div>      
                        </div>
                    </div> 
                    <div class="rounded border border-[#06402b] w-[95%]"></div>
                    <div class="flex flex-row w-full items-center justify-center">
                        <div class="flex flex-col w-full items-start gap-y-3">    
                            <span class="text-2xl font-semibold uppercase text-center lg:text-start">Environmental and urban impacts</span>
                            <span class="text-xl indent-8"> Environmental and urban impacts are the significant, often negative, environmental consequences of urbanization, including increased air and water pollution, habitat loss, and the urban heat island effect. These issues are driven by high population density, resource consumption, and waste generation, which are exacerbated by the concentration of people in cities and their contribution to climate change. Effective urban planning is crucial for mitigating these impacts by addressing issues like resource management, waste disposal, and the integration of green spaces. </span>
                        </div>
                    </div> 
                    <div class="flex flex-row w-full items-center justify-center">
                        <div class="flex flex-col w-full items-start gap-y-3">    
                            <span class="text-2xl font-semibold">Environmental impacts of urbanization</span>
                            <div class="flex flex-col w-full items-start pl-4 gap-y-3">
                                <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Air and water pollution: </span> Dense urban areas often have poor air and water quality due to vehicular emissions, industrial activity, and waste disposal issues, which can lead to serious health problems. </span></span>
                                <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Habitat loss and biodiversity reduction: </span> Urban expansion, or sprawl, replaces natural landscapes like forests and wetlands with concrete and asphalt, leading to habitat destruction and a decline in biodiversity. </span></span>
                                <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Resource depletion: </span> Cities require vast amounts of resources like food, water, and building materials, which can lead to rapid depletion and a strain on natural systems. </span></span>
                                <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Waste generation: </span> Urban populations generate large quantities of solid waste and wastewater, posing a significant challenge for disposal and management. </span></span>
                                <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Urban heat island effect: </span> Cities are often warmer than surrounding rural areas because of the heat absorbed by buildings and paved surfaces, increasing energy consumption for cooling and contributing to air pollution. </span></span>
                                <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Climate change contribution: </span> Urban areas are major sources of greenhouse gas emissions, with transport and buildings being significant contributors. They are also vulnerable to climate change effects like rising sea levels and extreme weather events. </span></span>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-row w-full items-center justify-center">
                        <div class="flex flex-col w-full items-start gap-y-3">    
                            <span class="text-2xl font-semibold">Impacts on natural hazards</span>
                            <div class="flex flex-col w-full items-start pl-4 gap-y-3">
                                <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Increased vulnerability: </span> Urban expansion and the modification of landscapes make cities more vulnerable to natural hazards like floods and hurricanes. </span></span>
                                <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Amplified consequences: </span> The high concentration of people in cities amplifies the potential for human and economic loss during natural disasters. </span></span>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-row w-full items-center justify-center">
                        <div class="flex flex-col w-full items-start gap-y-3">    
                            <span class="text-2xl font-semibold">Addressing the impacts</span>
                            <div class="flex flex-col w-full items-start pl-4 gap-y-3">
                                <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Sustainable urban planning: </span> Implementing thoughtful urban planning is essential for managing growth, preserving natural resources, and protecting residents. </span></span>
                                <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Resource-efficient technologies: </span> Using technologies that reduce energy consumption, manage waste more effectively, and improve the efficiency of water use can help mitigate environmental strain. </span></span>
                                <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Green infrastructure: </span> Incorporating more green spaces, such as parks and trees, can help reduce the urban heat island effect, improve air quality, and manage stormwater runoff. </span></span>
                                <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Climate action: </span> Cities can reduce their contribution to climate change by adopting renewable energy sources and implementing cleaner production techniques. </span></span>
                            </div>
                        </div>
                    </div>
                    <div class="rounded border border-[#06402b] w-[95%]"></div>
                    <div class="flex flex-row w-full items-center justify-center">
                        <div class="flex flex-col w-full items-start gap-y-3">    
                            <span class="text-2xl font-semibold uppercase text-center lg:text-start">Sensitive groups: children, elderly, people with respiratory or heart conditions</span>
                            <span class="text-xl indent-8"> Children, the elderly, and individuals with respiratory or heart conditions are considered "sensitive groups" because they are more vulnerable to health problems caused by poor air quality. Their increased susceptibility is due to factors like developing lungs in children, the natural decline of physiological defenses in the elderly, and pre-existing conditions in those with lung or heart disease. For these groups, it is recommended to limit outdoor activity, especially when the Air Quality Index (AQI) is high. </span>
                        </div>
                    </div> 
                    <div class="flex flex-row w-full items-center justify-center">
                        <div class="flex flex-col w-full items-start gap-y-3">    
                            <span class="text-2xl font-semibold">Why these groups are more sensitive</span>
                            <div class="flex flex-col w-full items-start pl-4 gap-y-3">
                                <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Children: </span> Their lungs are still developing, they breathe more air relative to their body size than adults, and they are more prone to respiratory infections. </span></span>
                                <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">The Elderly: </span> The aging process can reduce lung function, and their immune systems may not be as effective at protecting them from pollutants. They also have a higher prevalence of pre-existing heart and lung conditions. </span></span>
                                <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">People with Respiratory or Heart Conditions: </span> Individuals with pre-existing diseases like asthma, chronic bronchitis, emphysema, or cardiovascular disease are more likely to experience a worsening of their symptoms at lower levels of air pollution. </span></span>
                            </div>
                        </div>
                    </div><div class="flex flex-row w-full items-center justify-center">
                        <div class="flex flex-col w-full items-start gap-y-3">    
                            <span class="text-2xl font-semibold">What to do when air quality is unhealthy</span>
                            <div class="flex flex-col w-full items-start pl-4 gap-y-3">
                                <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Stay Indoors: </span> Limit time spent outdoors. </span></span>
                                <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Use Air Conditioning: </span> If possible, use air conditioning to keep indoor air clean. </span></span>
                                <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Reduce Exposures: </span> If you must go outside, wear a well-fitting mask (like an N95 or KN95) and take frequent breaks. </span></span>
                                <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Adjust Activities: </span> Schedule strenuous outdoor activities for times when air quality is better or reduce the intensity and duration of your workout. </span></span>
                                <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Check Air Quality: </span> Monitor your local air quality forecasts through official websites or apps. </span></span>
                                <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Consult a Doctor: </span> People with health symptoms should contact their healthcare provider. </span></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-col gap-y-5 px-3 lg:px-10 py-5 w-[98%] h-auto rounded-xl">
                <div class="flex flex-col w-full gap-y-5 items-center">
                    <span class="text-2xl font-semibold uppercase text-[#06402b] underline text-start">Preventive & Safety Measures</span>
                    <div class="flex flex-row w-full items-center justify-center">
                        <div class="flex flex-col w-full items-start gap-y-3">    
                            <span class="text-2xl font-semibold uppercase text-center lg:text-start">How to monitor air and sound using sensors or apps</span>
                            <span class="text-xl indent-8"> You can monitor air and sound using either smartphone apps or dedicated hardware sensors. For sound, use smartphone apps like Decibel X or NIOSH Sound Level Meter to measure noise levels, or for air, use dedicated air quality monitors like uHoo or Huma-i that measure pollutants like PM2.5, CO₂, and VOCs. You can also build a DIY system with sensors connected to a microcontroller like an Arduino or ESP8266 to create a custom monitoring setup that can send data to a smartphone app or web server. </span>
                        </div>
                    </div>
                    <div class="flex flex-col w-full items-center justify-center gap-y-5">
                        <div class="flex flex-col w-full items-start gap-y-3">    
                            <span class="text-2xl font-semibold">Using smartphone apps</span>
                            <div class="flex flex-col w-full items-start pl-4 gap-y-3">
                                <span class="flex flex-row gap-x-2 font-semibold text-xl">• For sound (Decibel measurement):</span>
                                <span class="flex flex-row gap-x-2 pl-4">◦ <span class="text-xl"> Download a sound level meter app to turn your smartphone into a decibel meter. </span></span>
                                <span class="flex flex-row gap-x-2 pl-4">◦ <span class="text-xl"> Examples include the free apps Decibel X (iOS/Android) and NIOSH Sound Level Meter (iOS). </span></span>
                                <span class="flex flex-row gap-x-2 pl-4">◦ <span class="text-xl"> Be aware that Android microphone limitations might affect accuracy at very high decibel levels. </span></span>
                            </div>  
                            <div class="flex flex-col w-full items-start pl-4 gap-y-3">
                                <span class="flex flex-row gap-x-2 font-semibold text-xl">• For air:</span>
                                <span class="flex flex-row gap-x-2 pl-4">◦ <span class="text-xl"> Some newer smartphones have built-in sensors, or you can use specialized apps that work with external sensors. </span></span>
                                <span class="flex flex-row gap-x-2 pl-4">◦ <span class="text-xl"> Many air quality apps require a separate hardware sensor to provide data. </span></span>
                            </div>  
                        </div>
                        <div class="flex flex-col w-full items-start gap-y-3">    
                            <span class="text-2xl font-semibold">Using dedicated hardware sensors</span>
                            <div class="flex flex-col w-full items-start pl-4 gap-y-3">
                                <span class="flex flex-row gap-x-2 font-semibold text-xl">• Air quality monitors:</span>
                                <span class="flex flex-row gap-x-2 pl-4">◦ <span class="text-xl"> Purchase a dedicated indoor air quality monitor. </span></span>
                                <span class="flex flex-row gap-x-2 pl-4">◦ <span class="text-xl"> Devices like the uHoo Indoor Air Quality Sensor or Huma-i Smart monitor various parameters like PM2.5, CO₂, VOCs, temperature, and humidity. </span></span>
                                <span class="flex flex-row gap-x-2 pl-4">◦ <span class="text-xl"> These often connect to a smartphone app for a detailed display and history. </span></span>
                            </div>  
                            <div class="flex flex-col w-full items-start pl-4 gap-y-3">
                                <span class="flex flex-row gap-x-2 font-semibold text-xl">• Sound sensors:</span>
                                <span class="flex flex-row gap-x-2 pl-4">◦ <span class="text-xl"> You can use dedicated sound sensors, often available for DIY projects. </span></span>
                                <span class="flex flex-row gap-x-2 pl-4">◦ <span class="text-xl"> These can be integrated into a larger system to trigger alerts when noise levels exceed a certain threshold. </span></span>
                            </div>  
                        </div>
                        <div class="flex flex-col w-full items-start gap-y-3">    
                            <span class="text-2xl font-semibold">Building a DIY system</span>
                            <div class="flex flex-col w-full items-start pl-4 gap-y-3">
                                <span class="flex flex-row gap-x-2 font-semibold text-xl">• For a custom solution, you'll need:</span>
                                <span class="flex flex-row gap-x-2 pl-4">◦ <span class="text-xl"> A microcontroller (like an Arduino or ESP8266). </span></span>
                                <span class="flex flex-row gap-x-2 pl-4">◦ <span class="text-xl"> A way to communicate the data, such as a Wi-Fi module to send it to a cloud platform or a simple buzzer and LCD screen for local alerts. </span></span>
                                <span class="flex flex-row gap-x-2 pl-4">◦ <span class="text-xl"> You can then use an IoT platform like Blynk or create a custom application to view the data on your phone. </span></span>
                                <span class="flex flex-row gap-x-2 pl-4">◦ <span class="text-xl"> This allows for automated actions, such as turning on a fan or receiving an alert when a gas leak is detected. </span></span>
                            </div>  
                        </div>  
                    </div> 
                    <div class="rounded border border-[#06402b] w-[95%]"></div>
                    <div class="flex flex-col w-full items-center justify-center gap-y-5">
                        <div class="flex flex-col w-full items-start gap-y-3">    
                            <span class="text-2xl font-semibold uppercase text-center lg:text-start">Steps individuals and communities can take</span>
                            <span class="text-xl indent-8"> Individuals and communities can take steps like reducing, reusing, and recycling waste, conserving water and energy, using sustainable transportation, and making conscious purchasing decisions. Community-level actions also include organizing cleanups, planting trees, supporting local and sustainable businesses, and advocating for environmentally friendly policies. </span>
                        </div>
                        <div class="flex flex-col w-full items-center justify-center gap-y-5">
                            <div class="flex flex-col w-full items-start gap-y-3">    
                                <span class="text-2xl font-semibold">Actions for individuals</span>
                                <div class="flex flex-col w-full items-start pl-4 gap-y-3">
                                    <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Reduce waste: </span> Implement the "3Rs"—reduce, reuse, and recycle. </span></span>
                                    <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Conserve Energy: </span> Save electricity at home, use energy-efficient appliances, and switch to renewable energy sources if possible. </span></span>
                                    <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Conserve Water: </span> Minimize water usage in daily activities. </span></span>
                                    <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Modify Transportation: </span> Walk, bike, use public transport, or carpool to reduce emissions from individual vehicles. </span></span>
                                    <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Change consumption habits: </span> Buy local food, consider a plant-based diet, choose sustainable products, and avoid single-use plastics. </span></span>
                                    <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Properly dispose of waste: </span> Ensure you know how to properly dispose of all waste, including hazardous and medical waste. </span></span>
                                </div>
                            </div>
                            <div class="flex flex-col w-full items-start gap-y-3">    
                                <span class="text-2xl font-semibold">Actions for communities</span>
                                <div class="flex flex-col w-full items-start pl-4 gap-y-3">
                                    <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Organize and participate: </span> Volunteer for local cleanups, planting trees, and other conservation efforts. </span></span>
                                    <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Improved waste management: </span> Work with local authorities to establish and improve waste segregation and recycling programs. </span></span>
                                    <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Promote sustainable practices: </span> Encourage the use of biodegradable packaging and the proper disposal of wastewater. </span></span>
                                    <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Support local and sustainable initiatives: </span> Patronize local farmers' markets and businesses that use sustainable practices. </span></span>
                                    <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Advocate for change: </span> Support political parties or movements that are environmentally conscious and push for policies that protect natural resources. </span></span>
                                    <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Educate and raise awareness: </span> Organize educational sessions to raise awareness about environmental issues and sustainable practices for all age groups. </span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="rounded border border-[#06402b] w-[95%]"></div>
                    <div class="flex flex-col w-full items-center justify-center gap-y-5">
                        <div class="flex flex-col w-full items-start gap-y-3">    
                            <span class="text-2xl font-semibold uppercase text-center lg:text-start">Health & lifestyle recommendations</span>
                            <span class="text-xl indent-8"> To improve your health and lifestyle, focus on a balanced diet rich in fruits and vegetables, regular physical activity for at least 150 minutes a week, and adequate sleep of 7-9 hours per night. Other key recommendations include managing stress, maintaining social connections, limiting alcohol, and avoiding smoking. </span>
                        </div>
                        <div class="flex flex-col w-full items-center justify-center gap-y-5">
                            <div class="flex flex-col w-full items-start gap-y-3">    
                                <span class="text-2xl font-semibold">Nutrition</span>
                                <div class="flex flex-col w-full items-start pl-4 gap-y-3">
                                    <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Eat a balanced diet: </span> Include a variety of foods, especially fruits, vegetables, whole grains, and lean protein. </span></span>
                                    <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Limit unhealthy foods: </span> Reduce your intake of salt, sugar, and saturated fats. </span></span>
                                    <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Hydrate: </span> Drink plenty of water throughout the day. </span></span>
                                    <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Reduce processed foods: </span> Minimize consumption of processed foods, which are often high in sugar, salt, and unhealthy fats. </span></span>
                                </div>
                            </div>
                            <div class="flex flex-col w-full items-start gap-y-3">    
                                <span class="text-2xl font-semibold">Physical Activity</span>
                                <div class="flex flex-col w-full items-start pl-4 gap-y-3">
                                    <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Be active: </span> Aim for at least 150 minutes of moderate-intensity physical activity per week, such as brisk walking or cycling. </span></span>
                                    <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Incorporate muscle-strengthening: </span> Include muscle-strengthening activities like weightlifting or yoga at least two days a week. </span></span>
                                    <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Reduce sitting time: </span> Try to sit less and move more throughout the day. </span></span>
                                </div>
                            </div>
                            <div class="flex flex-col w-full items-start gap-y-3">    
                                <span class="text-2xl font-semibold">Sleep and Mental Health</span>
                                <div class="flex flex-col w-full items-start pl-4 gap-y-3">
                                    <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Prioritize Sleep: </span> Aim for 7 or more hours of quality sleep per night. </span></span>
                                    <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Manage stress: </span> Use exercise, meditation, deep breathing, or talking to loved ones to help manage stress. </span></span>
                                    <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Stay social: </span> Maintain strong connections with friends and family, as this supports your mental health. </span></span>
                                </div>
                            </div>
                            <div class="flex flex-col w-full items-start gap-y-3">    
                                <span class="text-2xl font-semibold">General Well-being</span>
                                <div class="flex flex-col w-full items-start pl-4 gap-y-3">
                                    <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Avoid smoking and excessive alcohol: </span> Do not smoke, and drink alcohol only in moderation. </span></span>
                                    <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">Take care of hygiene: </span> Maintain good personal hygiene, including regular hand washing, brushing teeth, and showering. </span></span>
                                    <span class="flex flex-row gap-x-2">• <span class="text-xl"> <span class="font-semibold">RGet regular checkups: </span> Attend regular health checkups, screenings, and get vaccinated as recommended. </span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>