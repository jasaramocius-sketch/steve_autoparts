/* Address helper data: countries, states (provinces) and major cities.
   Used by partials/address-fields.blade.php to power the country dropdown
   and the state/city suggestion datalists. */
window.ADDRESS_DATA = {
    "countries": [
        "Afghanistan", "Albania", "Algeria", "Andorra", "Angola", "Antigua and Barbuda", "Argentina",
        "Armenia", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh",
        "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bhutan", "Bolivia",
        "Bosnia and Herzegovina", "Botswana", "Brazil", "Brunei", "Bulgaria", "Burkina Faso",
        "Burundi", "Cabo Verde", "Cambodia", "Cameroon", "Canada", "Central African Republic",
        "Chad", "Chile", "China", "Colombia", "Comoros", "Congo", "Costa Rica", "Croatia",
        "Cuba", "Cyprus", "Czech Republic", "Democratic Republic of the Congo", "Denmark",
        "Djibouti", "Dominica", "Dominican Republic", "Ecuador", "Egypt", "El Salvador",
        "Equatorial Guinea", "Eritrea", "Estonia", "Eswatini", "Ethiopia", "Fiji", "Finland",
        "France", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Greece", "Grenada",
        "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Honduras", "Hungary",
        "Iceland", "India", "Indonesia", "Iran", "Iraq", "Ireland", "Israel", "Italy",
        "Ivory Coast", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati",
        "Kuwait", "Kyrgyzstan", "Laos", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libya",
        "Liechtenstein", "Lithuania", "Luxembourg", "Madagascar", "Malawi", "Malaysia",
        "Maldives", "Mali", "Malta", "Marshall Islands", "Mauritania", "Mauritius", "Mexico",
        "Micronesia", "Moldova", "Monaco", "Mongolia", "Montenegro", "Morocco", "Mozambique",
        "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "New Zealand", "Nicaragua",
        "Niger", "Nigeria", "North Korea", "North Macedonia", "Norway", "Oman", "Pakistan",
        "Palau", "Palestine", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines",
        "Poland", "Portugal", "Qatar", "Romania", "Russia", "Rwanda", "Saint Kitts and Nevis",
        "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino",
        "Saudi Arabia", "Senegal", "Serbia", "Seychelles", "Sierra Leone", "Singapore",
        "Slovakia", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Korea",
        "South Sudan", "Spain", "Sri Lanka", "Sudan", "Suriname", "Sweden", "Switzerland",
        "Syria", "Taiwan", "Tajikistan", "Tanzania", "Thailand", "Timor-Leste", "Togo",
        "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Tuvalu",
        "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States",
        "Uruguay", "Uzbekistan", "Vanuatu", "Vatican City", "Venezuela", "Vietnam", "Yemen",
        "Zambia", "Zimbabwe"
    ].sort(),

    "states": {
        "United States": [
            "Alabama", "Alaska", "Arizona", "Arkansas", "California", "Colorado", "Connecticut",
            "Delaware", "District of Columbia", "Florida", "Georgia", "Hawaii", "Idaho", "Illinois",
            "Indiana", "Iowa", "Kansas", "Kentucky", "Louisiana", "Maine", "Maryland",
            "Massachusetts", "Michigan", "Minnesota", "Mississippi", "Missouri", "Montana",
            "Nebraska", "Nevada", "New Hampshire", "New Jersey", "New Mexico", "New York",
            "North Carolina", "North Dakota", "Ohio", "Oklahoma", "Oregon", "Pennsylvania",
            "Rhode Island", "South Carolina", "South Dakota", "Tennessee", "Texas", "Utah",
            "Vermont", "Virginia", "Washington", "West Virginia", "Wisconsin", "Wyoming"
        ].sort(),
        "Canada": [
            "Alberta", "British Columbia", "Manitoba", "New Brunswick", "Newfoundland and Labrador",
            "Northwest Territories", "Nova Scotia", "Nunavut", "Ontario", "Prince Edward Island",
            "Quebec", "Saskatchewan", "Yukon"
        ].sort(),
        "United Kingdom": ["England", "Northern Ireland", "Scotland", "Wales"].sort(),
        "Australia": [
            "Australian Capital Territory", "New South Wales", "Northern Territory",
            "Queensland", "South Australia", "Tasmania", "Victoria", "Western Australia"
        ].sort(),
        "India": [
            "Andhra Pradesh", "Arunachal Pradesh", "Assam", "Bihar", "Chhattisgarh", "Goa",
            "Gujarat", "Haryana", "Himachal Pradesh", "Jharkhand", "Karnataka", "Kerala",
            "Madhya Pradesh", "Maharashtra", "Manipur", "Meghalaya", "Mizoram", "Nagaland",
            "Odisha", "Punjab", "Rajasthan", "Sikkim", "Tamil Nadu", "Telangana", "Tripura",
            "Uttar Pradesh", "Uttarakhand", "West Bengal", "Andaman and Nicobar Islands",
            "Chandigarh", "Dadra and Nagar Haveli and Daman and Diu", "Delhi", "Jammu and Kashmir",
            "Ladakh", "Lakshadweep", "Puducherry"
        ].sort(),
        "Germany": [
            "Baden-Wurttemberg", "Bavaria", "Berlin", "Brandenburg", "Bremen", "Hamburg",
            "Hesse", "Lower Saxony", "Mecklenburg-Vorpommern", "North Rhine-Westphalia",
            "Rhineland-Palatinate", "Saarland", "Saxony", "Saxony-Anhalt",
            "Schleswig-Holstein", "Thuringia"
        ].sort(),
        "France": [
            "Auvergne-Rhone-Alpes", "Bourgogne-Franche-Comte", "Bretagne",
            "Centre-Val de Loire", "Corse", "Grand Est", "Hauts-de-France", "Ile-de-France",
            "Normandie", "Nouvelle-Aquitaine", "Occitanie", "Pays de la Loire",
            "Provence-Alpes-Cote d'Azur"
        ].sort(),
        "Italy": [
            "Abruzzo", "Aosta Valley", "Apulia", "Basilicata", "Calabria", "Campania",
            "Emilia-Romagna", "Friuli-Venezia Giulia", "Lazio", "Liguria", "Lombardy",
            "Marche", "Molise", "Piedmont", "Sardinia", "Sicily", "Trentino-South Tyrol",
            "Tuscany", "Umbria", "Veneto"
        ].sort(),
        "Spain": [
            "Andalusia", "Aragon", "Asturias", "Balearic Islands", "Basque Country",
            "Canary Islands", "Cantabria", "Castile and Leon", "Castile-La Mancha",
            "Catalonia", "Extremadura", "Galicia", "La Rioja", "Community of Madrid",
            "Region of Murcia", "Navarre", "Valencian Community"
        ].sort(),
        "Mexico": [
            "Aguascalientes", "Baja California", "Baja California Sur", "Campeche", "Chiapas",
            "Chihuahua", "Coahuila", "Colima", "Mexico City", "Durango", "Guanajuato",
            "Guerrero", "Hidalgo", "Jalisco", "Mexico State", "Michoacan", "Morelos", "Nayarit",
            "Nuevo Leon", "Oaxaca", "Puebla", "Queretaro", "Quintana Roo", "San Luis Potosi",
            "Sinaloa", "Sonora", "Tabasco", "Tamaulipas", "Tlaxcala", "Veracruz", "Yucatan",
            "Zacatecas"
        ].sort(),
        "Brazil": [
            "Acre", "Alagoas", "Amapa", "Amazonas", "Bahia", "Ceara", "Distrito Federal",
            "Espirito Santo", "Goias", "Maranhao", "Mato Grosso", "Mato Grosso do Sul",
            "Minas Gerais", "Para", "Paraiba", "Parana", "Pernambuco", "Piaui", "Rio de Janeiro",
            "Rio Grande do Norte", "Rio Grande do Sul", "Rondonia", "Roraima",
            "Santa Catarina", "Sao Paulo", "Sergipe", "Tocantins"
        ].sort(),
        "Japan": [
            "Aichi", "Akita", "Aomori", "Chiba", "Ehime", "Fukui", "Fukuoka", "Fukushima",
            "Gifu", "Gunma", "Hiroshima", "Hokkaido", "Hyogo", "Ibaraki", "Ishikawa", "Iwate",
            "Kagawa", "Kagoshima", "Kanagawa", "Kochi", "Kumamoto", "Kyoto", "Mie", "Miyagi",
            "Miyazaki", "Nagano", "Nagasaki", "Nara", "Niigata", "Oita", "Okayama", "Okinawa",
            "Osaka", "Saga", "Saitama", "Shiga", "Shimane", "Shizuoka", "Tochigi", "Tokushima",
            "Tokyo", "Tottori", "Toyama", "Wakayama", "Yamagata", "Yamaguchi", "Yamanashi"
        ].sort(),
        "New Zealand": [
            "Auckland", "Bay of Plenty", "Canterbury", "Chatham Islands", "Gisborne",
            "Hawke's Bay", "Manawatu-Wanganui", "Marlborough", "Nelson", "Northland",
            "Otago", "Southland", "Taranaki", "Tasman", "Waikato", "Wellington", "West Coast"
        ].sort(),
        "South Africa": [
            "Eastern Cape", "Free State", "Gauteng", "KwaZulu-Natal", "Limpopo",
            "Mpumalanga", "North West", "Northern Cape", "Western Cape"
        ].sort(),
        "United Arab Emirates": [
            "Abu Dhabi", "Ajman", "Dubai", "Fujairah", "Ras Al Khaimah", "Sharjah",
            "Umm Al Quwain"
        ].sort(),
        "Netherlands": [
            "Drenthe", "Flevoland", "Friesland", "Gelderland", "Groningen", "Limburg",
            "North Brabant", "North Holland", "Overijssel", "South Holland", "Utrecht", "Zeeland"
        ].sort(),
        "Switzerland": [
            "Aargau", "Appenzell Ausserrhoden", "Appenzell Innerrhoden", "Basel-Landschaft",
            "Basel-Stadt", "Bern", "Fribourg", "Geneva", "Glarus", "Graubunden", "Jura",
            "Lucerne", "Neuchatel", "Nidwalden", "Obwalden", "Schaffhausen", "Schwyz",
            "Solothurn", "St. Gallen", "Thurgau", "Ticino", "Uri", "Valais", "Vaud", "Zug", "Zurich"
        ].sort(),
        "China": [
            "Anhui", "Beijing", "Chongqing", "Fujian", "Gansu", "Guangdong", "Guangxi",
            "Guizhou", "Hainan", "Hebei", "Heilongjiang", "Henan", "Hubei", "Hunan",
            "Inner Mongolia", "Jiangsu", "Jiangxi", "Jilin", "Liaoning", "Ningxia", "Qinghai",
            "Shaanxi", "Shandong", "Shanghai", "Shanxi", "Sichuan", "Tianjin", "Tibet",
            "Xinjiang", "Yunnan", "Zhejiang"
        ].sort(),
        "Nigeria": [
            "Abia", "Adamawa", "Akwa Ibom", "Anambra", "Bauchi", "Bayelsa", "Benue", "Borno",
            "Cross River", "Delta", "Ebonyi", "Edo", "Ekiti", "Enugu", "FCT", "Gombe", "Imo",
            "Jigawa", "Kaduna", "Kano", "Katsina", "Kebbi", "Kogi", "Kwara", "Lagos", "Nasarawa",
            "Niger", "Ogun", "Ondo", "Osun", "Oyo", "Plateau", "Rivers", "Sokoto", "Taraba",
            "Yobe", "Zamfara"
        ].sort(),
        "Pakistan": [
            "Azad Kashmir", "Balochistan", "Gilgit-Baltistan", "Islamabad Capital Territory",
            "Khyber Pakhtunkhwa", "Punjab", "Sindh"
        ].sort(),
        "Bangladesh": [
            "Barisal", "Chattogram", "Dhaka", "Khulna", "Mymensingh", "Rajshahi", "Rangpur",
            "Sylhet"
        ].sort(),
        "Philippines": [
            "Autonomous Region in Muslim Mindanao", "Bicol Region", "Cagayan Valley",
            "Calabarzon", "Caraga", "Central Luzon", "Central Visayas", "Cordillera",
            "Davao Region", "Eastern Visayas", "Ilocos Region", "Metro Manila",
            "Mimaropa", "Northern Mindanao", "Soccsksargen", "Western Visayas", "Zamboanga Peninsula"
        ].sort(),
        "Russia": [
            "Central Federal District", "Far Eastern Federal District",
            "North Caucasian Federal District", "Northwestern Federal District",
            "Siberian Federal District", "Southern Federal District",
            "Ural Federal District", "Volga Federal District"
        ].sort(),
        "Turkey": [
            "Aegean Region", "Black Sea Region", "Central Anatolia Region",
            "Eastern Anatolia Region", "Marmara Region", "Mediterranean Region",
            "Southeastern Anatolia Region"
        ].sort(),
        "Ukraine": [
            "Cherkasy", "Chernihiv", "Chernivtsi", "Crimea", "Dnipropetrovsk", "Donetsk",
            "Ivano-Frankivsk", "Kharkiv", "Kherson", "Khmelnytskyi", "Kyiv", "Kyiv City",
            "Kirovohrad", "Luhansk", "Lviv", "Mykolaiv", "Odesa", "Poltava", "Rivne", "Sumy",
            "Ternopil", "Vinnytsia", "Volyn", "Zakarpattia", "Zaporizhzhia", "Zhytomyr"
        ].sort(),
        "Poland": [
            "Greater Poland", "Kuyavian-Pomeranian", "Lesser Poland", "Lodz", "Lower Silesian",
            "Lublin", "Lubusz", "Masovian", "Opole", "Podlaskie", "Pomeranian", "Silesian",
            "Subcarpathian", "Swietokrzyskie", "Warmian-Masurian", "West Pomeranian"
        ].sort(),
        "Argentina": [
            "Buenos Aires", "Buenos Aires Province", "Catamarca", "Chaco", "Chubut",
            "Cordoba", "Corrientes", "Entre Rios", "Formosa", "Jujuy", "La Pampa", "La Rioja",
            "Mendoza", "Misiones", "Neuquen", "Rio Negro", "Salta", "San Juan", "San Luis",
            "Santa Cruz", "Santa Fe", "Santiago del Estero", "Tierra del Fuego", "Tucuman"
        ].sort(),
        "Indonesia": [
            "Aceh", "Bali", "Bangka Belitung", "Banten", "Bengkulu", "Central Java",
            "Central Kalimantan", "Central Sulawesi", "East Java", "East Kalimantan",
            "East Nusa Tenggara", "Gorontalo", "Jakarta", "Jambi", "Lampung", "Maluku",
            "North Kalimantan", "North Maluku", "North Sulawesi", "North Sumatra",
            "Papua", "Riau", "Riau Islands", "South Kalimantan", "South Sulawesi",
            "South Sumatra", "Southeast Sulawesi", "West Java", "West Kalimantan",
            "West Nusa Tenggara", "West Papua", "West Sulawesi", "West Sumatra", "Yogyakarta"
        ].sort(),
        "Malaysia": [
            "Johor", "Kedah", "Kelantan", "Kuala Lumpur", "Labuan", "Melaka", "Negeri Sembilan",
            "Pahang", "Penang", "Perak", "Perlis", "Putrajaya", "Sabah", "Sarawak", "Selangor",
            "Terengganu"
        ].sort(),
        "Thailand": [
            "Bangkok", "Central Thailand", "Eastern Thailand", "Isan (Northeastern Thailand)",
            "Northern Thailand", "Southern Thailand"
        ].sort(),
        "Vietnam": [
            "Central Highlands", "Mekong River Delta", "North Central Coast",
            "Northeast", "Northwest", "Red River Delta", "South Central Coast", "Southeast"
        ].sort(),
        "Kenya": [
            "Baringo", "Bomet", "Bungoma", "Busia", "Elgeyo-Marakwet", "Embu", "Garissa",
            "Homa Bay", "Isiolo", "Kajiado", "Kakamega", "Kericho", "Kiambu", "Kilifi",
            "Kirinyaga", "Kisii", "Kisumu", "Kitui", "Kwale", "Laikipia", "Lamu", "Machakos",
            "Makueni", "Mandera", "Marsabit", "Meru", "Migori", "Mombasa", "Murang'a", "Nairobi",
            "Nakuru", "Nandi", "Narok", "Nyamira", "Nyandarua", "Nyeri", "Samburu", "Siaya",
            "Taita-Taveta", "Tana River", "Tharaka-Nithi", "Trans-Nzoia", "Turkana", "Uasin Gishu",
            "Vihiga", "Wajir", "West Pokot"
        ].sort()
    },

    "cities": {
        "United States": [
            "New York", "Los Angeles", "Chicago", "Houston", "Phoenix", "Philadelphia",
            "San Antonio", "San Diego", "Dallas", "San Jose", "Austin", "Jacksonville",
            "Fort Worth", "Columbus", "Charlotte", "San Francisco", "Indianapolis",
            "Seattle", "Denver", "Washington", "Boston", "Nashville", "El Paso",
            "Detroit", "Portland", "Las Vegas", "Memphis", "Louisville", "Baltimore",
            "Milwaukee", "Albuquerque", "Tucson", "Fresno", "Sacramento", "Kansas City",
            "Atlanta", "Miami", "New Orleans", "Cleveland", "Tampa", "Orlando",
            "Minneapolis", "Pittsburgh", "St. Louis", "Cincinnati", "Buffalo", "Rochester",
            "Salt Lake City", "Oklahoma City", "Omaha", "Raleigh", "Richmond", "Hartford",
            "Providence", "Burlington", "Anchorage", "Honolulu", "Boise", "Billings",
            "Fargo", "Sioux Falls", "Des Moines", "Wichita", "Springfield", "Little Rock",
            "Newark", "Jersey City", "Wilmington", "Charleston", "Savannah", "Birmingham",
            "Montgomery", "Mobile", "Jackson", "Shreveport", "Lubbock", "Amarillo",
            "Albuquerque", "Bakersfield", "Modesto", "Stockton", "Oxnard", "Reno",
            "Santa Fe", "Scottsdale", "Mesa", "Colorado Springs", "Fort Collins", "Boulder",
            "Grand Rapids", "Ann Arbor", "Madison", "Green Bay", "Columbus", "Dayton",
            "Toledo", "Akron", "Virginia Beach", "Norfolk", "Newport News", "Alexandria",
            "Huntsville", "Chattanooga", "Knoxville", "Lexington", "Little Rock",
            "Manchester", "Concord", "Augusta", "Bismarck", "Pierre", "Cheyenne", "Casper"
        ].sort(),
        "Canada": [
            "Toronto", "Montreal", "Vancouver", "Calgary", "Edmonton", "Ottawa", "Winnipeg",
            "Quebec City", "Hamilton", "Kitchener", "London", "Victoria", "Halifax",
            "Oshawa", "Windsor", "Saskatoon", "Regina", "St. John's", "Barrie", "Kelowna",
            "Abbotsford", "Sherbrooke", "Guelph", "Kingston", "Moncton", "Thunder Bay",
            "Saint John", "Fredericton", "Charlottetown", "Whitehorse", "Yellowknife", "Iqaluit"
        ].sort(),
        "United Kingdom": [
            "London", "Birmingham", "Manchester", "Liverpool", "Leeds", "Sheffield",
            "Bristol", "Nottingham", "Leicester", "Coventry", "Newcastle upon Tyne",
            "Glasgow", "Edinburgh", "Cardiff", "Belfast", "Aberdeen", "Dundee", "Brighton",
            "Southampton", "Portsmouth", "Reading", "Oxford", "Cambridge", "York", "Exeter",
            "Plymouth", "Bath", "Norwich", "Hull", "Derby", "Stoke-on-Trent", "Sunderland"
        ].sort(),
        "Australia": [
            "Sydney", "Melbourne", "Brisbane", "Perth", "Adelaide", "Gold Coast", "Canberra",
            "Newcastle", "Wollongong", "Hobart", "Darwin", "Geelong", "Townsville", "Cairns",
            "Sunshine Coast", "Ballarat", "Bendigo", "Launceston", "Mackay", "Rockhampton",
            "Toowoomba", "Alice Springs", "Bunbury", "Geraldton"
        ].sort(),
        "India": [
            "Mumbai", "Delhi", "Bengaluru", "Hyderabad", "Ahmedabad", "Chennai", "Kolkata",
            "Surat", "Pune", "Jaipur", "Lucknow", "Kanpur", "Nagpur", "Indore", "Thane",
            "Bhopal", "Visakhapatnam", "Patna", "Vadodara", "Ghaziabad", "Ludhiana",
            "Agra", "Nashik", "Faridabad", "Meerut", "Rajkot", "Varanasi", "Srinagar",
            "Aurangabad", "Dhanbad", "Amritsar", "Navi Mumbai", "Allahabad", "Ranchi",
            "Howrah", "Coimbatore", "Jabalpur", "Gwalior", "Vijayawada", "Jodhpur",
            "Madurai", "Raipur", "Kota", "Guwahati", "Chandigarh", "Solapur", "Hubli",
            "Mysore", "Tiruchirappalli", "Dehradun"
        ].sort(),
        "United Arab Emirates": ["Dubai", "Abu Dhabi", "Sharjah", "Ajman", "Al Ain", "Ras Al Khaimah", "Fujairah", "Umm Al Quwain"].sort(),
        "New Zealand": ["Auckland", "Wellington", "Christchurch", "Hamilton", "Tauranga", "Dunedin", "Palmerston North", "Napier", "Hastings", "Rotorua", "New Plymouth", "Whangarei", "Invercargill", "Nelson", "Gisborne", "Timaru"].sort(),
        "South Africa": ["Johannesburg", "Cape Town", "Durban", "Pretoria", "Port Elizabeth", "Bloemfontein", "East London", "Polokwane", "Nelspruit", "Kimberley"].sort(),
        "Germany": ["Berlin", "Hamburg", "Munich", "Cologne", "Frankfurt", "Stuttgart", "Dusseldorf", "Leipzig", "Dortmund", "Essen", "Bremen", "Dresden", "Hanover", "Nuremberg", "Duisburg", "Bochum", "Wuppertal", "Bielefeld", "Bonn", "Munster"].sort(),
        "France": ["Paris", "Marseille", "Lyon", "Toulouse", "Nice", "Nantes", "Montpellier", "Strasbourg", "Bordeaux", "Lille", "Rennes", "Reims", "Toulon", "Saint-Etienne", "Le Havre", "Grenoble", "Dijon", "Angers", "Nimes", "Clermont-Ferrand"].sort(),
        "Italy": ["Rome", "Milan", "Naples", "Turin", "Palermo", "Genoa", "Bologna", "Florence", "Bari", "Catania", "Venice", "Verona", "Messina", "Padua", "Trieste", "Brescia", "Parma", "Prato", "Modena", "Cagliari"].sort(),
        "Spain": ["Madrid", "Barcelona", "Valencia", "Seville", "Zaragoza", "Malaga", "Murcia", "Palma", "Las Palmas", "Bilbao", "Alicante", "Cordoba", "Valladolid", "Vigo", "Gijon", "Granada", "A Coruna", "Santander", "Pamplona", "Toledo"].sort(),
        "Mexico": ["Mexico City", "Guadalajara", "Monterrey", "Puebla", "Tijuana", "Leon", "Juarez", "Zapopan", "Merida", "Queretaro", "Cancun", "San Luis Potosi", "Hermosillo", "Mexicali", "Aguascalientes", "Morelia", "Chihuahua", "Saltillo", "Culiacan", "Acapulco"].sort(),
        "Brazil": ["Sao Paulo", "Rio de Janeiro", "Brasilia", "Salvador", "Fortaleza", "Belo Horizonte", "Manaus", "Curitiba", "Recife", "Porto Alegre", "Belem", "Goiania", "Campinas", "Sao Luis", "Maceio", "Natal", "Teresina", "Joao Pessoa", "Florianopolis", "Cuiaba"].sort(),
        "Japan": ["Tokyo", "Yokohama", "Osaka", "Nagoya", "Sapporo", "Fukuoka", "Kobe", "Kyoto", "Kawasaki", "Saitama", "Hiroshima", "Sendai", "Chiba", "Kitakyushu", "Sakai", "Niigata", "Hamamatsu", "Kumamoto", "Sagamihara", "Okayama"].sort(),
        "Netherlands": ["Amsterdam", "Rotterdam", "The Hague", "Utrecht", "Eindhoven", "Groningen", "Tilburg", "Almere", "Breda", "Nijmegen", "Haarlem", "Arnhem", "Enschede", "Amersfoort", "Apeldoorn", "s-Hertogenbosch"].sort(),
        "Switzerland": ["Zurich", "Geneva", "Basel", "Lausanne", "Bern", "Winterthur", "Lucerne", "St. Gallen", "Lugano", "Biel", "Thun", "Fribourg"].sort(),
        "China": ["Beijing", "Shanghai", "Guangzhou", "Shenzhen", "Chengdu", "Chongqing", "Tianjin", "Wuhan", "Hangzhou", "Xi'an", "Nanjing", "Suzhou", "Qingdao", "Dalian", "Ningbo", "Shenyang", "Hefei", "Xiamen", "Jinan", "Harbin"].sort(),
        "Nigeria": ["Lagos", "Abuja", "Kano", "Ibadan", "Port Harcourt", "Benin City", "Kaduna", "Enugu", "Jos", "Aba", "Owerri", "Maiduguri", "Sokoto", "Uyo", "Calabar", "Ilorin", "Ogbomoso", "Warri", "Onitsha", "Abeokuta"].sort(),
        "Pakistan": ["Karachi", "Lahore", "Faisalabad", "Rawalpindi", "Islamabad", "Multan", "Gujranwala", "Hyderabad", "Peshawar", "Quetta", "Sialkot", "Bahawalpur", "Sargodha", "Jhelum", "Sukkur", "Larkana", "Sheikhupura", "Rahim Yar Khan", "Mardan", "Gujrat"].sort(),
        "Bangladesh": ["Dhaka", "Chattogram", "Khulna", "Rajshahi", "Sylhet", "Barisal", "Rangpur", "Mymensingh", "Comilla", "Narayanganj", "Gazipur", "Bogra", "Jessore", "Cox's Bazar", "Saidpur"].sort(),
        "Philippines": ["Manila", "Quezon City", "Cebu City", "Davao City", "Zamboanga City", "Iloilo City", "Cagayan de Oro", "Bacolod", "Angeles City", "Taguig", "Makati", "Pasig", "Antipolo", "General Santos", "Tarlac City"].sort(),
        "Russia": ["Moscow", "Saint Petersburg", "Novosibirsk", "Yekaterinburg", "Kazan", "Nizhny Novgorod", "Chelyabinsk", "Krasnoyarsk", "Samara", "Ufa", "Rostov-on-Don", "Omsk", "Krasnodar", "Voronezh", "Perm", "Volgograd"].sort(),
        "Turkey": ["Istanbul", "Ankara", "Izmir", "Bursa", "Antalya", "Adana", "Gaziantep", "Konya", "Mersin", "Kayseri", "Eskisehir", "Diyarbakir", "Samsun", "Denizli", "Trabzon"].sort(),
        "Poland": ["Warsaw", "Krakow", "Lodz", "Wroclaw", "Poznan", "Gdansk", "Szczecin", "Bydgoszcz", "Lublin", "Bialystok", "Katowice", "Gdynia", "Czestochowa", "Radom", "Torun"].sort(),
        "Argentina": ["Buenos Aires", "Cordoba", "Rosario", "Mendoza", "La Plata", "Mar del Plata", "San Miguel de Tucuman", "Salta", "Santa Fe", "San Juan", "Resistencia", "Neuquen", "Corrientes", "Bahia Blanca", "Posadas"].sort(),
        "Indonesia": ["Jakarta", "Surabaya", "Bandung", "Medan", "Semarang", "Makassar", "Palembang", "Tangerang", "Depok", "Bekasi", "Yogyakarta", "Malang", "Samarinda", "Denpasar", "Pontianak"].sort(),
        "Malaysia": ["Kuala Lumpur", "George Town", "Johor Bahru", "Ipoh", "Shah Alam", "Petaling Jaya", "Kuching", "Kota Kinabalu", "Malacca City", "Kota Bharu", "Kuala Terengganu", "Seremban", "Alor Setar", "Kuantan", "Subang Jaya"].sort(),
        "Thailand": ["Bangkok", "Chiang Mai", "Phuket", "Pattaya", "Hat Yai", "Nakhon Ratchasima", "Chiang Rai", "Udon Thani", "Khon Kaen", "Nakhon Si Thammarat", "Surat Thani", "Rayong", "Trang", "Krabi", "Nong Khai"].sort(),
        "Vietnam": ["Ho Chi Minh City", "Hanoi", "Da Nang", "Hai Phong", "Can Tho", "Bien Hoa", "Hue", "Nha Trang", "Vung Tau", "Buon Ma Thuot", "Nam Dinh", "Quy Nhon", "Rach Gia", "Da Lat", "Long Xuyen"].sort(),
        "Kenya": ["Nairobi", "Mombasa", "Kisumu", "Nakuru", "Eldoret", "Thika", "Malindi", "Kitale", "Garissa", "Kakamega", "Naivasha", "Kericho", "Embu", "Nyeri", "Meru"].sort()
    }
};
