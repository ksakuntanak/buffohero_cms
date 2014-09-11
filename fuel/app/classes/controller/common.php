<?php
class Controller_Common extends Controller_Template {

    public function before(){

        $uri_string = explode('/', Uri::string());

        if (count($uri_string) > 1 and $uri_string[0] == 'user' and $uri_string[1] == 'login'){

            return;

        } else {

            $user_id = Session::get('cms_user_id');

            /*($user_id);
            exit();*/

            if($user_id){

                $user = Model_User::find($user_id);

                if(!$user || $user->group != 100){
                    Response::redirect('/user/login');
                }

            } else {

                Response::redirect('/user/login');

            }

        }
    }
    
    public static function get_countries(){
        return array(
            "United States",
            "United Kingdom",
            "Afghanistan",
            "Albania",
            "Algeria",
            "American Samoa",
            "Andorra",
            "Angola",
            "Anguilla",
            "Antarctica",
            "Antigua and Barbuda",
            "Argentina",
            "Armenia",
            "Aruba",
            "Australia",
            "Austria",
            "Azerbaijan",
            "Bahamas",
            "Bahrain",
            "Bangladesh",
            "Barbados",
            "Belarus",
            "Belgium",
            "Belize",
            "Benin",
            "Bermuda",
            "Bhutan",
            "Bolivia",
            "Bosnia and Herzegovina",
            "Botswana",
            "Bouvet Island",
            "Brazil",
            "British Indian Ocean Territory",
            "Brunei Darussalam",
            "Bulgaria",
            "Burkina Faso",
            "Burundi",
            "Cambodia",
            "Cameroon",
            "Canada",
            "Cape Verde",
            "Cayman Islands",
            "Central African Republic",
            "Chad",
            "Chile",
            "China",
            "Christmas Island",
            "Cocos (Keeling) Islands",
            "Colombia",
            "Comoros",
            "Congo",
            "Congo, The Democratic Republic of The",
            "Cook Islands",
            "Costa Rica",
            "Cote D'ivoire",
            "Croatia",
            "Cuba",
            "Cyprus",
            "Czech Republic",
            "Denmark",
            "Djibouti",
            "Dominica",
            "Dominican Republic",
            "Ecuador",
            "Egypt",
            "El Salvador",
            "Equatorial Guinea",
            "Eritrea",
            "Estonia",
            "Ethiopia",
            "Falkland Islands (Malvinas)",
            "Faroe Islands",
            "Fiji",
            "Finland",
            "France",
            "French Guiana",
            "French Polynesia",
            "French Southern Territories",
            "Gabon",
            "Gambia",
            "Georgia",
            "Germany",
            "Ghana",
            "Gibraltar",
            "Greece",
            "Greenland",
            "Grenada",
            "Guadeloupe",
            "Guam",
            "Guatemala",
            "Guinea",
            "Guinea-bissau",
            "Guyana",
            "Haiti",
            "Heard Island and Mcdonald Islands",
            "Holy See (Vatican City State)",
            "Honduras",
            "Hong Kong",
            "Hungary",
            "Iceland",
            "India",
            "Indonesia",
            "Iran, Islamic Republic of",
            "Iraq",
            "Ireland",
            "Israel",
            "Italy",
            "Jamaica",
            "Japan",
            "Jordan",
            "Kazakhstan",
            "Kenya",
            "Kiribati",
            "Korea, Democratic People's Republic of",
            "Korea, Republic of",
            "Kuwait",
            "Kyrgyzstan",
            "Lao People's Democratic Republic",
            "Latvia",
            "Lebanon",
            "Lesotho",
            "Liberia",
            "Libyan Arab Jamahiriya",
            "Liechtenstein",
            "Lithuania",
            "Luxembourg",
            "Macao",
            "Macedonia, The Former Yugoslav Republic of",
            "Madagascar",
            "Malawi",
            "Malaysia",
            "Maldives",
            "Mali",
            "Malta",
            "Marshall Islands",
            "Martinique",
            "Mauritania",
            "Mauritius",
            "Mayotte",
            "Mexico",
            "Micronesia, Federated States of",
            "Moldova, Republic of",
            "Monaco",
            "Mongolia",
            "Montserrat",
            "Morocco",
            "Mozambique",
            "Myanmar",
            "Namibia",
            "Nauru",
            "Nepal",
            "Netherlands",
            "Netherlands Antilles",
            "New Caledonia",
            "New Zealand",
            "Nicaragua",
            "Niger",
            "Nigeria",
            "Niue",
            "Norfolk Island",
            "Northern Mariana Islands",
            "Norway",
            "Oman",
            "Pakistan",
            "Palau",
            "Palestinian Territory, Occupied",
            "Panama",
            "Papua New Guinea",
            "Paraguay",
            "Peru",
            "Philippines",
            "Pitcairn",
            "Poland",
            "Portugal",
            "Puerto Rico",
            "Qatar",
            "Reunion",
            "Romania",
            "Russian Federation",
            "Rwanda",
            "Saint Helena",
            "Saint Kitts and Nevis",
            "Saint Lucia",
            "Saint Pierre and Miquelon",
            "Saint Vincent and The Grenadines",
            "Samoa",
            "San Marino",
            "Sao Tome and Principe",
            "Saudi Arabia",
            "Senegal",
            "Serbia and Montenegro",
            "Seychelles",
            "Sierra Leone",
            "Singapore",
            "Slovakia",
            "Slovenia",
            "Solomon Islands",
            "Somalia",
            "South Africa",
            "South Georgia and The South Sandwich Islands",
            "Spain",
            "Sri Lanka",
            "Sudan",
            "Suriname",
            "Svalbard and Jan Mayen",
            "Swaziland",
            "Sweden",
            "Switzerland",
            "Syrian Arab Republic",
            "Taiwan, Province of China",
            "Tajikistan",
            "Tanzania, United Republic of",
            "Thailand",
            "Timor-leste",
            "Togo",
            "Tokelau",
            "Tonga",
            "Trinidad and Tobago",
            "Tunisia",
            "Turkey",
            "Turkmenistan",
            "Turks and Caicos Islands",
            "Tuvalu",
            "Uganda",
            "Ukraine",
            "United Arab Emirates",
            "United Kingdom",
            "United States",
            "United States Minor Outlying Islands",
            "Uruguay",
            "Uzbekistan",
            "Vanuatu",
            "Venezuela",
            "Viet Nam",
            "Virgin Islands, British",
            "Virgin Islands, U.S.",
            "Wallis and Futuna",
            "Western Sahara",
            "Yemen",
            "Zambia",
            "Zimbabwe",
        );
    }

    public static function create_cropped_thumbnail($image_path, $thumb_width, $thumb_height, $suffix = "") {

        if (!(is_integer($thumb_width) && $thumb_width > 0) && !($thumb_width === "*")) {
            echo "The width is invalid";
            exit(1);
        }

        if (!(is_integer($thumb_height) && $thumb_height > 0) && !($thumb_height === "*")) {
            echo "The height is invalid";
            exit(1);
        }

        $path = pathinfo($image_path, PATHINFO_DIRNAME);

        $filename = pathinfo($image_path, PATHINFO_FILENAME);
        if(preg_match('/-o/',$filename))
            $filename = substr($filename,0,strlen($filename)-2);

        $ext = pathinfo($image_path, PATHINFO_EXTENSION);

        /*print_r($path);
        print_r($filename);
        print_r($ext);

        exit();*/

        switch ($ext) {
            case "jpg":
            case "jpeg":
                $source_image = imagecreatefromjpeg($image_path);
                break;
            case "gif":
                $source_image = imagecreatefromgif($image_path);
                break;
            case "png":
                $source_image = imagecreatefrompng($image_path);
                break;
            default:
                exit(1);
                break;
        }

        $source_width = imageSX($source_image);
        $source_height = imageSY($source_image);

        if (($source_width / $source_height) == ($thumb_width / $thumb_height)) {
            $source_x = 0;
            $source_y = 0;
        }

        if (($source_width / $source_height) > ($thumb_width / $thumb_height)) {
            $source_y = 0;
            $temp_width = $source_height * $thumb_width / $thumb_height;
            $source_x = ($source_width - $temp_width) / 2;
            $source_width = $temp_width;
        }

        if (($source_width / $source_height) < ($thumb_width / $thumb_height)) {
            $source_x = 0;
            $temp_height = $source_width * $thumb_height / $thumb_width;
            $source_y = ($source_height - $temp_height) / 2;
            $source_height = $temp_height;
        }

        $target_image = ImageCreateTrueColor($thumb_width, $thumb_height);

        imagecopyresampled($target_image, $source_image, 0, 0, $source_x, $source_y, $thumb_width, $thumb_height, $source_width, $source_height);

        switch($ext) {
            case "jpg":
            case "jpeg":
                if(strlen($suffix)) imagejpeg($target_image, $path.DS.$filename.$suffix.".".$ext);
                else imagejpeg($target_image, $path.DS.$filename.".".$ext);
                break;
            case "png":
                if(strlen($suffix)) imagepng($target_image, $path.DS.$filename.$suffix.".".$ext);
                else imagepng($target_image, $path.DS.$filename.".".$ext);
                break;
        }

        imagedestroy($target_image);
        imagedestroy($source_image);
    }

}