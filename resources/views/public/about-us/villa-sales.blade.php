@extends('public.layouts.app')

@section('title', 'Villa Sales | PROSPEDITY')

@section('content')
<!-- Hero Section -->
@php
    $heroBackground = ($homeSetting && $homeSetting->hero_background) 
        ? asset('storage/' . $homeSetting->hero_background) 
        : null;
@endphp
<section class="relative h-96 bg-cover bg-center" @if($heroBackground) style="background-image: url('{{ $heroBackground }}');" @else style="background-color: #96A480;" @endif>
    <div class="absolute inset-0 bg-black bg-opacity-50"></div>
    <div class="relative h-full flex items-center justify-center">
        <h1 class="text-5xl md:text-6xl font-bold text-white uppercase tracking-wide">VILLA SALES</h1>
    </div>
</section>

<!-- Main Content -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Why Bali Section -->
        <div class="mb-16 text-center">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-8">Why Bali?</h2>
            
            <div class="prose prose-lg max-w-none text-center">
                <p class="text-gray-700 leading-relaxed mb-6">
                    When we think of Bali, we often dream of beautiful panoramas, exceptional nightlife, a blend of green jungles, impressive temples, and wonderful friendly people; that is exactly what awaits you in paradise! Perhaps this is why Bali, also referred to as 'The Island of the Gods' is continually ranked as one of the best destinations in the world to live, work and play. Bali is currently one of the most sought after locations for expatriates in Indonesia. It is currently estimated that around 30,000 expatriates are based in this region.
                </p>
                
                <p class="text-gray-700 leading-relaxed mb-6">
                    Bali is a place where buyers are spoiled for choice. This makes knowing where to start a challenge for our clients! The Sales Team at PROSPEDITY loves a good challenge and that is why we are here to listen to you. We have a varied client base including foreign business investors, expatriates, and retirees from all over the world. We work together to answer all the questions you may have when it comes to owning your dream property right here in Indonesia. Let our team help you to find the perfect PROSPEDITY for sale that is waiting for you. We can assist you with each step of your investment project or residential retirement plans on the island.
                </p>
                
                <p class="text-gray-700 leading-relaxed mb-6">
                    Located in the Java Sea, between the islands of Java and Lombok, The Province of Bali is famous for its unique historical architecture, vast green landscapes and balmy ocean views. According to the Bali Province Tourism Development Statistics from Budan Pusat Provinsi Bali, the number of international tourists in Bali grew by 3.6% in 2019 to 6.3 million, up from 6 million in 2018. Foreign tourists often come to Bali and find they never want to leave. Short-term visitors commonly turn into long-term expatriates with more travellers drawn to this spiritual destination every year.
                </p>
                
                <p class="text-gray-700 leading-relaxed mb-6">
                    Since 2016, the luxury property market has seen a 20% increase in demand on the island and was recently ranked the 4th best place to live and invest by Forbes. Relocating and investing in Bali offers you a luxurious experience without compromising on culture or quality and with more than 6 million travellers landing in Bali in 2019; opportunity continues to grow. The seamless blend of a modern lifestyle rich with Balinese heritage makes real estate and business in Bali highly desirable to foreign investors.
                </p>
                
                <p class="text-gray-700 leading-relaxed mb-6">
                    Bali offers Luxury Villa living at its best with open plan designs, high-end finishing, the perfect poolside lounge, creative use of natural light with clean designs. Balinese design often incorporates hardwood floorings with elements of bamboo and concrete that create a cool and welcoming space for the year-round warm weather.
                </p>
                
                <p class="text-gray-700 leading-relaxed mb-6">
                    The tropical gems available to buyers are nothing short of amazing and many properties in the Bali real estate market offer incredible value for money and reliable ROI. We believe there is something to suit every style and budget here on this island with no shortage of picture-perfect locations to select from. The architecture of Balinese homes is certainly beautiful. We have a large selection of luxury Bali villas for sale and rent in our portfolio ready for you today!
                </p>
                
                <p class="text-gray-700 leading-relaxed mb-6">
                    Our real estate profile spans across Canggu, Berawa, Pererenan, Seminyak, Batu Belig, Petitenget, Umalas, Kerobokan, lahan Lot and other surrounding areas. Our profile also extends beyond Bali and reaches out to additional surrounding islands such as Gili Trawangan, Nusa Penida, Nusa Lembongan, Sumbawa, and Sumba.
                </p>
                
                <p class="text-gray-700 leading-relaxed mb-6">
                    PROSPEDITY can provide you with a wide variety of properties including Villas for sale and Villas for rent, Apartments for sale and apartments for rent, Penthouses, Houses for sale and Penthouses for rent, several Housing and Apartment Complexes as well as our many Off-Plan Projects.
                </p>
                
                <p class="text-gray-700 leading-relaxed mb-6">
                    With each unique client, we start by finding the best location on the island. If you are searching for an investment property for the future, or a residential home for the here and now, or a retirement home in paradise, PROSPEDITY will match our sales listings to meet your purchasing goals. You will have our team's friendly and professional support from start to finish.
                </p>
                
                <p class="text-gray-700 leading-relaxed mb-12">
                    We strive for perfection when it comes to our real estate listings. Part of our core values is to deliver an honest representation of each property. Every home for sale is carefully inspected to ensure a correct and transparent sale at the right price. We work with the property owner to maintain a high standard that is fair and welcoming for our customers.
                </p>
            </div>
        </div>

        <!-- Services for The Buyer -->
        <div class="mb-16 text-center">
            <h2 class="text-3xl font-bold text-gray-800 mb-8">Services for The Buyer</h2>
            
            <div class="prose prose-lg max-w-none text-center">
                <p class="text-gray-700 leading-relaxed mb-6">
                    PROSPEDITY are ready to exceed your expectations with our property sale services. Our team will prepare a suitable selection of premium properties based on your requirements such as your desired location, style of living and purchasing price.
                </p>
                
                <p class="text-gray-700 leading-relaxed mb-6">
                    Our Bali real estate property selection increases by an average of seven new listings per day and our Sales Team are actively checking listing availability and pricing on a range of sales across the island. Our Sales Team offers a complete package to make sure you are taken care of whilst searching for your dream home.
                </p>
                
                <p class="text-gray-700 leading-relaxed mb-6">
                    We provide everything from property viewings, legal notary support, price negotiation and provide you with the latest information on available investment properties in Bali.
                </p>
                
                <p class="text-gray-700 leading-relaxed mb-12">
                    Here at PROSPEDITY, we can organise a private driver to bring you around the island with ease. Our drivers are familiar with each unique area making this the ideal way to see your chosen portfolio firsthand and to discuss any highlights or concerns with our team.
                </p>
            </div>
        </div>

        <!-- Professional Legal Advice -->
        <div class="mb-16 text-center">
            <h2 class="text-3xl font-bold text-gray-800 mb-8">Professional Legal Advice</h2>
            
            <div class="prose prose-lg max-w-none text-center">
                <p class="text-gray-700 leading-relaxed mb-6">
                    Legal Services are available to our clients. We work in collaboration with our partner's notary service for all due diligence for both villa or land sales, however, buyers can also choose the notary of their choice. Our team can arrange legal and fiscal advice for our buyers. Our full list of services is as listed below:
                </p>
                
                <ul class="list-none text-gray-700 space-y-2 mb-6 inline-block text-left">
                    <li>Making notarial agreements, such as lease agreements, lease extension agreements, lease transfer agreements, sale and purchase agreements.</li>
                    <li>Providing land-related deeds, such as: Akta Jual Beli (deed of Sale and Purchase), Akta Pemberian Hak Guna Bangunan Atas lahan Hak Milik (deed of HGB or Freehold).</li>
                    <li>Legalization of agreements made privately/underhand.</li>
                    <li>Waarmerking (certification) agreements made privately/underhand.</li>
                    <li>Power of attorney</li>
                </ul>
            </div>
        </div>

        <!-- Investment Property -->
        <div class="mb-16 text-center">
            <h2 class="text-3xl font-bold text-gray-800 mb-8">Investment Property</h2>
            
            <div class="prose prose-lg max-w-none text-center">
                <p class="text-gray-700 leading-relaxed mb-12">
                    Assisting you with every step of your investment project or residential retirement project is our goal. Let our trusted team handle the complexities of property investing so you can enjoy finding your dream home with our experienced real estate agents. Our experienced staff can assist buyers with price negotiation, property inventory and the final stage of the key handover.
                </p>
            </div>
        </div>

        <!-- Services for the Seller -->
        <div class="mb-16 text-center">
            <h2 class="text-3xl font-bold text-gray-800 mb-8">Services for the Seller</h2>
            
            <div class="prose prose-lg max-w-none text-center">
                <p class="text-gray-700 leading-relaxed mb-6">
                    PROSPEDITY provides professional property valuation with our honest and experienced approach to selling your property. Our sales consultants have a wide variety of field experience within this region and understand the current market. Our sales consultants will schedule coordinated monthly viewings of the property by appointment only and provide the seller with a comprehensive monthly report, detailing the number of property visits and all client feedback.
                </p>
                
                <p class="text-gray-700 leading-relaxed mb-6">
                    At PROSPEDITY, we pride ourselves on our efficient marketing strategy that is personally adapted to your property. This is an area of expertise that has been developed over many years of selling property in Bali.
                </p>
                
                <p class="text-gray-700 leading-relaxed mb-6">
                    This strategy package includes, but is not limited to Social Media Marketing on platforms with a high level of engagement and interaction, Marketing on real estate websites including Rumah123, Luxury Estate and many more, plus an individual marketing campaign to guarantee online exposure of your property to potential buyers.
                </p>
                
                <p class="text-gray-700 leading-relaxed mb-6">
                    Our service includes free semi-professional edited pictures for every property, free indoor and outdoor drone video content and virtual visit content to put your property at the forefront of the online competition.
                </p>
                
                <p class="text-gray-700 leading-relaxed mb-12">
                    As part of our exclusive villa sales marketing package, we offer an indoor and outdoor drone video, virtual visit, and marketing book for a reduced fee. In the instance that your property is successfully sold, all costs incurred will be refunded back to the seller.
                </p>
            </div>
        </div>

        <!-- Villas for Sale in PROSPEDITY -->
        <div class="mt-16 text-center">
            <h2 class="text-3xl font-bold text-gray-800 mb-8">Villas for Sale in PROSPEDITY</h2>
            
            <div class="space-y-8">
                <!-- Freehold -->
                <div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">FREEHOLD</h3>
                    <div class="space-y-4 text-gray-700">
                        <p>Canggu | Berawa | Canggu Residential Side | Pererenan</p>
                        <p>Seminyak | Batu Belig | Petitenget</p>
                        <p>Umalas | Kerobokan</p>
                        <p>Tanah Lot | Other Bali Area | Other Indo Island</p>
                    </div>
                </div>

                <!-- Leasehold -->
                <div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">LEASEHOLD</h3>
                    <div class="space-y-4 text-gray-700">
                        <p>Canggu | Berawa | Canggu Residential Side | Pererenan</p>
                        <p>Seminyak | Batu Belig | Petitenget</p>
                        <p>Umalas | Kerobokan</p>
                        <p>Tanah Lot | Other Bali Area | Other Indo Island</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

