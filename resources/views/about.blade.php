<x-layout>
    <div class="flex flex-col w-screen h-auto justify-center items-center bg-[#a8a8a8]">
        <div class="flex flex-col h-auto w-screen bg-white shadow-xl">
            <div class="flex flex-col lg:flex-row w-full h-[800px] lg:h-[600px] gap-x-5">
                <div class="flex flex-col w-full lg:w-[50%] h-[50%] lg:h-full justify-center items-center gap-y-4 md:gap-y-6 lg:gap-y-10 p-10 lg:p-20">
                    <span class="text-[#06402b] font-extrabold text-2xl md:text-4xl lg:text-6xl uppercase">About 
                        <span class="text-[#d4af37] uppercase text-2xl md:text-4xl lg:text-6xl font-extrabold">Us</span></span>
                    <span class="text-black text-sm md:text-base lg:text-2xl whitespace-normal text-center">
                        At Real-time Air and Sound Environment Monitoring System (RASE), we are committed to creating healthier and safer living environments through innovation. Our Air and Sound Monitoring System is designed to provide real-time data on pollution and noise levels, empowering people with the knowledge they need to take action.
                    </span>
                </div>
                <div class="flex flex-col w-full lg:w-[50%] h-[50%] lg:h-full justify-center items-center">
                    <div 
                        x-data="{ activeSlide: 0, slides: ['no1.jpg', 'no2.jpg', 'no4.jpg', 'no3.jpg', 'no5.png', 'no6.jpg', 'no7.jpg', 'no8.jpg',] }" 
                        x-init="setInterval(() => { activeSlide = (activeSlide + 1) % slides.length }, 3000)" 
                        class="relative w-full h-screen overflow-hidden">
                        <!-- Slides -->
                        <template x-for="(slide, index) in slides" :key="index">
                            <div 
                                x-show="activeSlide === index" 
                                x-transition 
                                class="absolute inset-0 w-full h-full"
                            >
                                <img :src="slide" class="w-full h-full object-cover" alt="slide">
                            </div>
                        </template>

                        <!-- Dots Indicator -->
                        <div class="absolute bottom-5 left-1/2 transform -translate-x-1/2 flex space-x-2">
                            <template x-for="(slide, index) in slides" :key="index">
                                <button 
                                    @click="activeSlide = index"
                                    :class="activeSlide === index ? 'bg-white' : 'bg-gray-400'" 
                                    class="w-3 h-3 rounded-full"
                                ></button>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex flex-col h-[800px] lg:h-screen w-screen justify-center items-center p-5">
            <div class="flex flex-col lg:flex-row h-[90%] w-[95%] bg-white shadow-xl rounded-xl justify-center items-center">
                <div class="flex flex-col w-full lg:w-[50%] h-[45%] lg:h-[80%] justify-center items-center">
                    <div class="border-4 border-[#d4af37] w-[30%] lg:w-[50%]"></div>   
                    <div class="flex flex-col w-full h-full justify-center items-center gap-y-4 md:gap-y-6 lg:gap-y-10 p-10 lg:p-20">
                        <span class="text-[#06402b] font-extrabold text-2xl md:text-4xl lg:text-6xl uppercase">Mission</span>
                        <span class="text-black text-base md:text-xl lg:text-2xl whitespace-normal text-center">
                            Our mission is to improve community health and environmental awareness by delivering accurate, accessible, and reliable air and sound monitoring solutions.
                        </span>
                    </div>
                </div>
                <div class="flex flex-col w-full lg:w-[50%] h-[45%] lg:h-[80%] justify-between items-center">
                    <div class="flex flex-col w-full h-full justify-center items-center gap-y-4 md:gap-y-6 lg:gap-y-10 p-10 lg:p-20">
                        <span class="text-[#06402b] font-extrabold text-2xl md:text-4xl lg:text-6xl uppercase">Vision</span>
                        <span class="text-black text-base md:text-xl lg:text-2xl whitespace-normal text-center">
                            We envision cleaner, safer, and quieter cities where technology and community awareness work hand in hand to build sustainable and healthier futures.
                        </span>
                    </div>
                    <div class="border-4 border-[#d4af37] w-[30%] lg:w-[50%]"></div>   
                </div>
            </div>
        </div>
        <div class="flex flex-col lg:flex-row h-[1000px] lg:h-screen w-screen justify-evenly items-center bg-[#06402b]">
            <div class="flex flex-col bg-white/20 h-[45%] lg:h-[70%] w-[80%] lg:w-[45%] rounded-4xl justify-center items-center gap-y-8 px-10 ">
                <span class="text-white font-extrabold text-2xl md:text-4xl lg:text-6xl uppercase">THE 
                    <span class="text-[#d4af37] uppercase text-2xl md:text-4xl lg:text-6xl font-extrabold">PROBLEM</span>
                </span>
                <span class="text-black text-lg md:text-xl lg:text-2xl whitespace-normal text-center">
                    Air pollution and noise pollution are growing concerns that negatively impact health, productivity, and overall quality of life. Despite their seriousness, many communities lack the tools to measure and respond to these issues effectively.
                </span>           
            </div>
            <div class="flex flex-col bg-white/20 h-[45%] lg:h-[70%] w-[80%] lg:w-[45%] rounded-4xl justify-center items-center gap-y-8 px-10">
                <span class="text-white font-extrabold text-2xl md:text-4xl lg:text-6xl uppercase">OUR 
                    <span class="text-[#d4af37] uppercase text-2xl md:text-4xl lg:text-6xl font-extrabold">SOLUTION</span>
                </span>
                <span class="text-black text-lg md:text-xl lg:text-2xl whitespace-normal text-center">
                    Our system provides a smart monitoring platform that delivers real-time data to communities, researchers, businesses, and policymakers. With this information, individuals and organizations can make informed choices, reduce risks, and create proactive environmental strategies.
                </span>           
            </div>
        </div>
        <div class="flex flex-col h-[800px] md:h-[650px] lg:h-screen w-screen justify-center items-center p-5">
            <div class="flex flex-row h-[90%] w-[95%] bg-white shadow-xl rounded-xl justify-center items-center">
                <div class="flex flex-col w-[90%] h-[90%] lg:h-[80%] justify-center items-center">
                    <div class="flex flex-col w-full h-full justify-start items-center gap-y-4 md:gap-y-6 lg:gap-y-10 px-10">
                        <span class="text-[#06402b] font-extrabold text-2xl md:text-4xl lg:text-6xl uppercase">WHO 
                            <span class="text-[#d4af37] font-extrabold text-2xl md:text-4xl lg:text-6xl uppercase">WE</span>
                            <span class="text-[#06402b] font-extrabold text-2xl md:text-4xl lg:text-6xl uppercase">SERVE</span>
                        </span>
                        <span class="text-black text-lg md:text-xl lg:text-2xl whitespace-normal text-center">
                            We are here for communities, schools, businesses, and local governments who share our vision of sustainable and healthy living spaces. By providing accessible technology, we help people make informed decisions that contribute to cleaner air, reduced noise, and improved quality of life.
                        </span>
                        <span class="text-black text-lg md:text-xl lg:text-2xl whitespace-normal text-center">
                            At the core of what we do is a simple belief: everyone deserves a safe, healthy, and sustainable environment. Together, we can make it happen.
                        </span>
                    </div>
                    <div class="border-4 border-[#d4af37] w-[30%]"></div>  
                </div>
            </div>  
        </div>  
    </div>
</x-layout>