<?php
/**
*System configuration
*
*@author : Tiamiyu waliu
*@website : http://www.iDocrea8.com
*/
return array(

    'installed' => true,
    /**
     * System name base on project
     */
    'name' => 'Intifadah',

    /**
     * System version
     */
    'version' => '1.0',

    /**
     * Which mode is the system on
     * can one of the following
     *
     * 1. live
     * 2. Developing
     */
    'mode' => 'developing',

    /**
     * Core addons
     */
    'coreAddons' => array(
        //'test' => ['enabled' => true],

    ),

    /**
     * Supported countries
     */

    'countries' => [
        'afghanistan' => "Afghanistan",
        'albania' => "Albania",
        'algeria' => "Algeria",
        'american samoa' => "American Samoa",
        'andorra' => "Andorra",
        'angola' => "Angola",
        'anguilla' => "Anguilla",
        'antarctica' => "Antarctica",
        'antigua and barbuda' => "Antigua and Barbuda",
        'antilles, netherlands' => "Antilles, Netherlands",
        'argentina' => "Argentina",
        'armenia' => "Armenia",
        'aruba' => "Aruba",
        'australia' => "Australia",
        'austria' => "Austria",
        'azerbaijan' => "Azerbaijan",
        'bahamas' => "Bahamas",
        'bahrain' => "Bahrain",
        'bangladesh' => "Bangladesh",
        'barbados' => "Barbados",
        'belarus' => "Belarus",
        'belgium' => "Belgium",
        'belize' => "Belize",
        'benin' => "Benin",
        'bermuda' => "Bermuda",
        'bhutan' => "Bhutan",
        'bolivia' => "Bolivia",
        'bosnia and herzegovina' => "Bosnia and Herzegovina",
        'botswana' => "Botswana",
        'brazil' => "Brazil",
        'british indian ocean territory' => "British Indian Ocean Territory",
        'british virgin islands' => "British Virgin Islands",
        'brunei darussalam' => "Brunei Darussalam",
        'bulgaria' => "Bulgaria",
        'burkina faso' => "Burkina Faso",
        'burundi' => "Burundi",
        'cambodia' => "Cambodia",
        'cameroon' => "Cameroon",
        'canada' => "Canada",
        'cape verde' => "Cape Verde",
        'cayman islands' => "Cayman Islands",
        'central african republic' => "Central African Republic",
        'chad' => "Chad",
        'chile' => "Chile",
        'china' => "China",
        'christmas island' => "Christmas Island",
        'cocos (keeling) islands' => "Cocos (Keeling) Islands",
        'colombia' => "Colombia",
        'comoros' => "Comoros",
        'congo' => "Congo",
        'cook islands' => "Cook Islands",
        'costa rica' => "Costa Rica",
        'croatia' => "Croatia",
        'cuba' => "Cuba",
        'cyprus' => "Cyprus",
        'czech republic' => "Czech Republic",
        'denmark' => "Denmark",
        'djibouti' => "Djibouti",
        'dominica' => "Dominica",
        'dominican republic' => "Dominican Republic",
        'east timor (timor-leste)' => "East Timor (Timor-Leste)",
        'ecuador' => "Ecuador",
        'egypt' => "Egypt",
        'el salvador' => "El Salvador",
        'equatorial guinea' => "Equatorial Guinea",
        'eritrea' => "Eritrea",
        'estonia' => "Estonia",
        'ethiopia' => "Ethiopia",
        'falkland islands (malvinas)' => "Falkland Islands (Malvinas)",
        'faroe islands' => "Faroe Islands",
        'fiji' => "Fiji",
        'finland' => "Finland",
        'france' => "France",
        'french guiana' => "French Guiana",
        'french polynesia' => "French Polynesia",
        'gabon' => "Gabon",
        'gambia, the' => "Gambia, the",
        'georgia' => "Georgia",
        'germany' => "Germany",
        'ghana' => "Ghana",
        'gibraltar' => "Gibraltar",
        'greece' => "Greece",
        'greenland' => "Greenland",
        'grenada' => "Grenada",
        'guadeloupe' => "Guadeloupe",
        'guam' => "Guam",
        'guatemala' => "Guatemala",
        'guernsey and alderney' => "Guernsey and Alderney",
        'guinea' => "Guinea",
        'guinea-bissau' => "Guinea-Bissau",
        'guinea, equatorial' => "Guinea, Equatorial",
        'guiana, french' => "Guiana, French",
        'guyana' => "Guyana",
        'haiti' => "Haiti",
        'holy see (vatican city state)' => "Holy See (Vatican City State)",
        'holland' => "Holland",
        'honduras' => "Honduras",
        'hong kong, (china)' => "Hong Kong, (China)",
        'hungary' => "Hungary",
        'iceland' => "Iceland",
        'india' => "India",
        'indonesia' => "Indonesia",
        'iran' => "Iran",
        'iraq' => "Iraq",
        'ireland' => "Ireland",
        'isle of man' => "Isle of Man",
        'israel' => "Israel",
        'italy' => "Italy",
        'jamaica' => "Jamaica",
        'japan' => "Japan",
        'jersey' => "Jersey",
        'jordan' => "Jordan",
        'kazakhstan' => "Kazakhstan",
        'kenya' => "Kenya",
        'kiribati' => "Kiribati",
        'korea(north)' => "Korea(North)",
        'korea(south)' => "Korea(South)",
        'kosovo' => "Kosovo",
        'kuwait' => "Kuwait",
        'kyrgyzstan' => "Kyrgyzstan",
        'latvia' => "Latvia",
        'lebanon' => "Lebanon",
        'lesotho' => "Lesotho",
        'liberia' => "Liberia",
        'libyan arab jamahiriya' => "Libyan Arab Jamahiriya",
        'liechtenstein' => "Liechtenstein",
        'lithuania' => "Lithuania",
        'luxembourg' => "Luxembourg",
        'macao, (china)' => "Macao, (China)",
        'macedonia, tfyr' => "Macedonia, TFYR",
        'madagascar' => "Madagascar",
        'malawi' => "Malawi",
        'malaysia' => "Malaysia",
        'maldives' => "Maldives",
        'mali' => "Mali",
        'malta' => "Malta",
        'marshall islands' => "Marshall Islands",
        'martinique' => "Martinique",
        'mauritania' => "Mauritania",
        'mauritius' => "Mauritius",
        'mayotte' => "Mayotte",
        'mexico' => "Mexico",
        'micronesia' => "Micronesia",
        'moldova' => "Moldova",
        'monaco' => "Monaco",
        'mongolia' => "Mongolia",
        'montenegro' => "Montenegro",
        'montserrat' => "Montserrat",
        'morocco' => "Morocco",
        'mozambique' => "Mozambique",
        'myanmar' => "Myanmar",
        'namibia' => "Namibia",
        'nauru' => "Nauru",
        'nepal' => "Nepal",
        'netherlands' => "Netherlands",
        'netherlands antilles' => "Netherlands Antilles",
        'new caledonia' => "New Caledonia",
        'new zealand' => "New Zealand",
        'nicaragua' => "Nicaragua",
        'niger' => "Niger",
        'nigeria' => "Nigeria",
        'niue' => "Niue",
        'norfolk island' => "Norfolk Island",
        'northern mariana islands' => "Northern Mariana Islands",
        'norway' => "Norway",
        'oman' => "Oman",
        'pakistan' => "Pakistan",
        'palau' => "Palau",
        'palestinian territory' => "Palestinian Territory",
        'panama' => "Panama",
        'papua new guinea' => "Papua New Guinea",
        'paraguay' => "Paraguay",
        'peru' => "Peru",
        'philippines' => "Philippines",
        'pitcairn island' => "Pitcairn Island",
        'poland' => "Poland",
        'portugal' => "Portugal",
        'puerto rico' => "Puerto Rico",
        'qatar' => "Qatar",
        'reunion' => "Reunion",
        'romania' => "Romania",
        'russia' => "Russia",
        'rwanda' => "Rwanda",
        'sahara' => "Sahara",
        'saint helena' => "Saint Helena",
        'saint kitts and nevis' => "Saint Kitts and Nevis",
        'saint lucia' => "Saint Lucia",
        'saint pierre and miquelon' => "Saint Pierre and Miquelon",
        'saint vincent and the grenadines' => "Saint Vincent and the Grenadines",
        'samoa' => "Samoa",
        'san marino' => "San Marino",
        'sao tome and principe' => "Sao Tome and Principe",
        'saudi arabia' => "Saudi Arabia",
        'senegal' => "Senegal",
        'serbia' => "Serbia",
        'seychelles' => "Seychelles",
        'sierra leone' => "Sierra Leone",
        'singapore' => "Singapore",
        'slovakia' => "Slovakia",
        'slovenia' => "Slovenia",
        'solomon islands' => "Solomon Islands",
        'somalia' => "Somalia",
        'south africa' => "South Africa",
        's. georgia and s. sandwich is.' => "S. Georgia and S. Sandwich Is.",
        'spain' => "Spain",
        'sri lanka (ex-ceilan)' => "Sri Lanka (ex-Ceilan)",
        'sudan' => "Sudan",
        'suriname' => "Suriname",
        'svalbard and jan mayen islands' => "Svalbard and Jan Mayen Islands",
        'swaziland' => "Swaziland",
        'sweden' => "Sweden",
        'switzerland' => "Switzerland",
        'syrian arab republic' => "Syrian Arab Republic",
        'taiwan' => "Taiwan",
        'tajikistan' => "Tajikistan",
        'tanzania' => "Tanzania",
        'thailand' => "Thailand",
        'timor-leste (east timor)' => "Timor-Leste (East Timor)",
        'togo' => "Togo",
        'tokelau' => "Tokelau",
        'tonga' => "Tonga",
        'trinidad and tobago' => "Trinidad and Tobago",
        'tunisia' => "Tunisia",
        'turkey' => "Turkey",
        'turkmenistan' => "Turkmenistan",
        'turks and caicos islands' => "Turks and Caicos Islands",
        'tuvalu' => "Tuvalu",
        'uganda' => "Uganda",
        'ukraine' => "Ukraine",
        'united arab emirates' => "United Arab Emirates",
        'united kingdom' => "United Kingdom",
        'united states' => "United States",
        'us minor outlying islands' => "US Minor Outlying Islands",
        'uruguay' => "Uruguay",
        'uzbekistan' => "Uzbekistan",
        'vanuatu' => "Vanuatu",
        'vatican city state (holy see)' => "Vatican City State (Holy See)",
        'venezuela' => "Venezuela",
        'viet nam' => "Viet Nam",
        'virgin islands, british' => "Virgin Islands, British",
        'virgin islands, u.s.' => "Virgin Islands, U.S.",
        'wallis and futuna' => "Wallis and Futuna",
        'western sahara' => "Western Sahara",
        'yemen' => "Yemen",
        'zambia' => "Zambia",
        'zimbabwe' => "Zimbabwe",
    ]
);
 