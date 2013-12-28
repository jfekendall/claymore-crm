<?php

/**
 * Common and handy elements to add to forms
 *
 * @author justin
 */
class formElements {

    private $MexicanStates = array("Aguascalientes" => "AG", "Baja California" => "BC", "Baja California Sur" => "BS", "Campeche" => "CM", "Chiapas" => "CS", "Chihuahua" => "CH", "Coahuila" => "CO", "Colima" => "CL", "Federal District" => "DF", "Durango" => "DG", "Guanajuato" => "GT", "Guerrero" => "GR", "Hidalgo" => "HG", "Jalisco" => "JA", "Mexico State" => "ME", "Michoacán" => "MI", "Morelos" => "MO", "Nayarit" => "NA", "Nuevo León" => "NL", "Oaxaca" => "OA", "Puebla" => "PU", "Querétaro" => "QE", "Quintana Roo" => "QR", "San Luis Potosí" => "SL", "Sinaloa" => "SI", "Sonora" => "SO", "Tabasco" => "TB", "Tamaulipas" => "TM", "Tlaxcala" => "TL", "Veracruz" => "VE", "Yucatán" => "YU", "Zacatecas" => "ZA");
    private $USStates = array("Alabama" => "AL", "Alaska" => "AK", "American Samoa" => "AS", "Arizona" => "AZ", "Arkansas" => "AR", "California" => "CA", "Colorado" => "CO", "Connecticut" => "CT", "Delaware" => "DE", "District of Columbia" => "DC", "Florida" => "FL", "Georgia" => "GA", "Guam" => "GU", "Hawaii" => "HI", "Idaho" => "ID", "Illinois" => "IL", "Indiana" => "IN", "Iowa" => "IA", "Kansas" => "KS", "Kentucky" => "KY", "Louisiana" => "LA", "Maine" => "ME", "Maryland" => "MD", "Massachusetts" => "MA", "Michigan" => "MI", "Minnesota" => "MN", "Mississippi" => "MS", "Missouri" => "MO", "Montana" => "MT", "Nebraska" => "NE", "Nevada" => "NV", "New Hampshire" => "NH", "New Jersey" => "NJ", "New Mexico" => "NM", "New York" => "NY", "North Carolina" => "NC", "North Dakota" => "ND", "Northern Mariana Islands" => "MP", "Ohio" => "OH", "Oklahoma" => "OK", "Oregon" => "OR", "Pennsylvania" => "PA", "Puerto Rico" => "PR", "Rhode Island" => "RI", "South Carolina" => "SC", "South Dakota" => "SD", "Tennessee" => "TN", "Texas" => "TX", "Utah" => "UT", "Vermont" => "VT", "Virgin Islands" => "VI", "Virginia" => "VA", "Washington" => "WA", "West Virginia" => "WV", "Wisconsin" => "WI", "Wyoming" => "WY");
    private $CanadianProvinces = array("Alberta" => "AB", "British Columbia" => "BC", "Manitoba" => "MB", "New Brunswick" => "NB", "Newfoundland and Labrador" => "NL", "Nova Scotia" => "NS", "Northwest Territories" => "NT", "Nunavut" => "NU", "Ontario" => "ON", "Prince Edward Island" => "PE", "Quebec" => "QC", "Saskatchewan" => "SK", "Yukon" => "YT");

    //A dropdown with all States or provinces from a selected country with values of their abbreviations
    public function states($country, $selected = '') {
        switch ($country) {
            case "us":
                $states = $this->USStates;
                break;
            case "canada":
                $states = $this->CanadianProvinces;
                break;
            case "mexico":
                $states = $this->MexicanStates;
                break;
            default:
                $states = $this->USStates;
        }
        $rs = "<select name='state' class='state'>
            <option></option>";
        foreach (array_keys($states) AS $state) {
            $rs .= "<option value='{$states[$state]}'>$state</option>";
        }
        $rs .= "</select>
            <script>
                $('.state option[value=$selected]').attr('selected', 'true');
            </script>";
        return $rs;
    }

}

?>
