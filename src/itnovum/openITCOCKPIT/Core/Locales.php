<?php


namespace itnovum\openITCOCKPIT\Core;


use Cake\Utility\Hash;

class Locales {

    /**
     * @return array countries as CountryCode => CountryName Array
     */
    public static function getCountries() {
        return [
            'au' => __('Australia'),
            'at' => __('Austria'),
            'be' => __('Belgium'),
            'ba' => __('Bosnia and Herzegovina'),
            'cz' => __('Czech Republic'),
            'dk' => __('Denmark'),
            'ee' => __('Estonia'),
            'fi' => __('Finland'),
            'fr' => __('France'),
            'de' => __('Germany'),
            'gr' => __('Greece'),
            'hu' => __('Hungary'),
            'ie' => __('Ireland'),
            'it' => __('Italy'),
            'jp' => __('Japan'),
            'lv' => __('Latvia'),
            'lt' => __('Lithuania'),
            'nl' => __('Netherlands'),
            'nz' => __('New Zealand'),
            'no' => __('Norway'),
            'pl' => __('Poland'),
            'pt' => __('Portugal'),
            'ro' => __('Romania'),
            'ru' => __('Russian Federation'),
            'sk' => __('Slovakia'),
            'za' => __('South Africa'),
            'es' => __('Spain'),
            'se' => __('Sweden'),
            'ch' => __('Switzerland'),
            'ua' => __('Ukraine'),
            'gb' => __('United Kingdom'),
            'us' => __('United States')
        ];
    }

    /**
     * @param string $countryCode
     * @return string
     */
    public static function getLocalCodeByCountryCode(string $countryCode) {
        $locals = [
            'AU' => 'en_AU',
            'AT' => 'de_AT',
            'BE' => 'de_BE',
            'BA' => 'hr_BA',
            'BR' => 'pt_BR',
            'HR' => 'hr_HR',
            'CZ' => 'cs_CZ',
            'DK' => 'da_DK',
            'EE' => 'et_EE',
            'FI' => 'fi_FI',
            'FR' => 'fr_FR',
            'DE' => 'de_DE',
            'GR' => 'el_GR',
            'HU' => 'hu_HU',
            'IE' => 'ga_IE',
            'IT' => 'it_IT',
            'JP' => 'ja_JP',
            'LV' => 'lv_LV',
            'LT' => 'lt_LT',
            'NL' => 'nl_NL',
            'NZ' => 'en_NZ',
            'NO' => 'no_NO',
            'PL' => 'pl_PL',
            'PT' => 'pt_PT',
            'RO' => 'ro_RO',
            'RU' => 'ru_RU',
            'SK' => 'sk_SK',
            'ZA' => 'zu_ZA',
            'ES' => 'es_ES',
            'SE' => 'sv_SE',
            'CH' => 'de_CH',
            'UA' => 'uk_UA',
            'GB' => 'en_GB',
            'US' => 'en_US'
        ];

        if (!isset($locals[$countryCode])) {
            return 'en_US';
        }
        return $locals[$countryCode];
    }

    /**
     * @return array[]
     */
    private static function getAllDefinedLanguages() {
        return [
            'German' => [
                'label'   => 'Deutsch / ' . __('German'),
                'flag'    => 'flag-icon flag-icon-de',
                'i18n'    => 'de_DE',
                'locales' => [
                    'de_AT', 'de_BE', 'de_DE', 'de_CH'
                ]
            ],

            'English' => [
                'label'   => 'English / ' . __('English'),
                'flag'    => 'flag-icon flag-icon-us',
                'i18n'    => 'en_US',
                'locales' => [
                    'en_AU', 'en_NZ', 'en_GB', 'en_US'
                ]
            ],


            'French' => [
                'label'   => 'Français / ' . __('French'),
                'flag'    => 'flag-icon flag-icon-fr',
                'i18n'    => 'fr_FR',
                'locales' => [
                    'fr_FR'
                ]
            ],

            'Russian' => [
                'label'   => 'Русский / ' . __('Russian'),
                'flag'    => 'flag-icon flag-icon-ru',
                'i18n'    => 'ru_RU',
                'locales' => [
                    'ru_RU'
                ]
            ],

            'Ukraine' => [
                'label'   => 'Українська / ' . __('Ukrainian'),
                'flag'    => 'flag-icon flag-icon-ua',
                'i18n'    => 'uk_UA',
                'locales' => [
                    'uk_UA'
                ]
            ]
        ];
    }

    /**
     * @return array|array[]|\ArrayAccess|\ArrayAccess[]
     */
    public static function getLocalCodesFromDefinedLanguages(){
        return Hash::extract(self::getAllDefinedLanguages(), '{s}.i18n');
    }

    /**
     * @param string $localCode
     * @return array
     */
    public static function getLanguageByLocalCode(string $localCode): array {
        $languages = self::getAllDefinedLanguages();

        foreach ($languages as $language) {
            if (in_array($localCode, $language['locales'], true)) {
                return $language;
            }
        }

        return [
            'label'   => 'Unknown / ' . __('Unknown'),
            'locales' => [
                'en_US'
            ]
        ];
    }

}
