<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PeccSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('peccs')->insert([
            'logo' => 'factory/stock/company-logo.jpg',
            'fund' => 'Blackstone',
            'type' => 'Private equity',
            'region' => 'US fond in Europe',
            'based' => 'USA',
            'main_countries' => 'Germany',
            'main_cities' => 'Frankfurt',
            'sector' => 'Life Sciences, Infrastructure, Tactical Opportunities, Seeding',
            'geo_focus' => 'Global',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('peccs')->insert([
            'logo' => 'factory/stock/company-logo.jpg',
            'fund' => 'Advent International',
            'type' => 'Private equity',
            'region' => 'US fond in Europe',
            'based' => 'USA',
            'main_countries' => 'Germany, Italy',
            'main_cities' => 'Frankfurt , Milan',
            'sector' => 'Business & Financial Services, Healthcare, Industrial, Retail, consumer & Leisure, Technology',
            'geo_focus' => 'North America, Europe and selected Emergin markets Latin America',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('peccs')->insert([
            'logo' => 'factory/stock/company-logo.jpg',
            'fund' => 'Carlyle Group',
            'type' => 'Private equity',
            'region' => 'US fond in Europe',
            'based' => 'USA',
            'main_countries' => 'Germany,The netherlands,Italy, France, Spain',
            'main_cities' => 'Munich, Amsterdan, Milan, Paris, Barcelona',
            'sector' => 'Aerospace, defense, consumer, media retail, financial services, healthcare, industrial & Transportation, Tech Energy',
            'geo_focus' => 'Global',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('peccs')->insert([
            'logo' => 'factory/stock/company-logo.jpg',
            'fund' => 'KKR',
            'type' => 'Private equity',
            'region' => 'US fond in Europe',
            'based' => 'USA',
            'main_countries' => 'Germany, Luxembug, France',
            'main_cities' => 'Frankfurt, Luxemburg, Paris',
            'sector' => 'All',
            'geo_focus' => 'Global',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('peccs')->insert([
            'logo' => 'factory/stock/company-logo.jpg',
            'fund' => 'Bain Capital',
            'type' => 'Private equity , VC',
            'region' => 'US fond in Europe',
            'based' => 'USA',
            'main_countries' => 'Germany, Luxemburg',
            'main_cities' => 'Munich, Luxemburg',
            'sector' => 'Prop tech, Comerce technology, Saas Data service, Fintech, Infrestructure software, Healthcare, Consumer, Financial services',
            'geo_focus' => 'Americas, Asia-Pacific, Europe',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('peccs')->insert([
            'logo' => 'factory/stock/company-logo.jpg',
            'fund' => 'EQT Partners',
            'type' => 'Private equity , VC',
            'region' => 'Nordic ',
            'based' => 'Sweden',
            'main_countries' => 'Sweden,Germany, Swizterland, UK',
            'main_cities' => 'Stokcholm, Berlin, Munich, Zurich, London',
            'sector' => 'TMT, Healthcare, services, consumer, Industrial Technology',
            'geo_focus' => 'Europe, Asia- Americas',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('peccs')->insert([
            'logo' => 'factory/stock/company-logo.jpg',
            'fund' => 'Nordic Capital',
            'type' => 'Private Equity',
            'region' => 'Nordic ',
            'based' => 'Sweden',
            'main_countries' => 'Sweden,Germany,UK',
            'main_cities' => 'Stockholm, Frankfurt, London',
            'sector' => 'Health Care, tech and payments, Financial services, industrial and business services, Consumer',
            'geo_focus' => 'Europe & China',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('peccs')->insert([
            'logo' => 'factory/stock/company-logo.jpg',
            'fund' => 'IK Invesments partners',
            'type' => 'Private Equity',
            'region' => 'Nordic ',
            'based' => 'UK',
            'main_countries' => 'Uk, Germany, Netherlands',
            'main_cities' => 'London, Hamburg, Amsterdan',
            'sector' => 'Consumer goods, foods, healthcare ,Enginereed products, Services',
            'geo_focus' => 'Europe',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('peccs')->insert([
            'logo' => 'factory/stock/company-logo.jpg',
            'fund' => 'Altor equity Partners',
            'type' => 'Private Equity',
            'region' => 'Nordic ',
            'based' => 'Sweden',
            'main_countries' => 'Sweden, denmark, Finland',
            'main_cities' => 'Stockholm, Copenhague, Helsinski',
            'sector' => 'Business services wholesale, Consumer  retail, Energy, Tech, Financial Serivces, public sector, Industrial',
            'geo_focus' => 'Europe',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('peccs')->insert([
            'logo' => 'factory/stock/company-logo.jpg',
            'fund' => 'Hictectvision',
            'type' => 'Private Equity',
            'region' => 'Nordic ',
            'based' => 'Norway',
            'main_countries' => 'Norway',
            'main_cities' => 'Oslo',
            'sector' => 'Infrastructure, Exploration and production, Oil, Property, Drilling, Financial serivces , Subsea services, Energy',
            'geo_focus' => 'Europe & Asia',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        // 10
        DB::table('peccs')->insert([
            'logo' => 'factory/stock/company-logo.jpg',
            'fund' => 'Permira',
            'type' => 'Private Equity',
            'region' => 'UK',
            'based' => 'UK',
            'main_countries' => 'Uk, Germany, Guernsey',
            'main_cities' => 'London, Frankfurt, Guernsey',
            'sector' => 'Consumer, Healthcare, Services, Technology',
            'geo_focus' => 'Europe & APAC',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('peccs')->insert([
            'logo' => 'factory/stock/company-logo.jpg',
            'fund' => 'Cinven',
            'type' => 'Private equity',
            'region' => 'UK',
            'based' => 'UK',
            'main_countries' => 'UK, Germany, Italy',
            'main_cities' => 'London, Frankfurt, Milan',
            'sector' => 'Business services,  Consumer , Financial Services, TMT, Healthcare, Indutrial',
            'geo_focus' => 'Europe & Americas',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('peccs')->insert([
            'logo' => 'factory/stock/company-logo.jpg',
            'fund' => 'Apax Partners',
            'type' => 'Private equity, VC',
            'region' => 'UK',
            'based' => 'UK',
            'main_countries' => 'UK, Gernany, Israel',
            'main_cities' => 'London, Munich, Tel Aviv',
            'sector' => 'Tech, Serivices, Healthcare , Internet, Cosunmer',
            'geo_focus' => 'Europe, Asia, Americas',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('peccs')->insert([
            'logo' => 'factory/stock/company-logo.jpg',
            'fund' => 'BC Partners',
            'type' => 'Private equity, VC',
            'region' => 'UK',
            'based' => 'UK',
            'main_countries' => 'UK, Germany',
            'main_cities' => 'London,  Hamburg',
            'sector' => 'Business services,  Consumer , Financial Services, TMT, Healthcare, Indutrial, retail',
            'geo_focus' => 'Europe & Americas',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('peccs')->insert([
            'logo' => 'factory/stock/company-logo.jpg',
            'fund' => 'Bridgepoint',
            'type' => 'Private equity, VC',
            'region' => 'UK',
            'based' => 'UK',
            'main_countries' => 'UK, Germany, Netherlands',
            'main_cities' => 'London, Frankfurt, Amsterdam',
            'sector' => 'Business Services, Consumer, Financial Services, Healthcare, MedTech & Pharma, Manufacturing & Industrials and Digital, Technology & Media',
            'geo_focus' => 'Europe, USA & China',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('peccs')->insert([
            'logo' => 'factory/stock/company-logo.jpg',
            'fund' => 'CVC Capital',
            'type' => 'Private equity, VC',
            'region' => 'France+ Benelux',
            'based' => 'Luxemburg',
            'main_countries' => 'Luxemburg, Germany, UK',
            'main_cities' => 'Luxemburg, Frankfurt, London',
            'sector' => 'Chemicals, Business services, Building, Energy, Financial Services, Media, tech, telecoms, healthcare',
            'geo_focus' => 'Europe, Asia, Americas',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('peccs')->insert([
            'logo' => 'factory/stock/company-logo.jpg',
            'fund' => 'Ardian',
            'type' => 'Private equity, VC',
            'region' => 'France+ Benelux',
            'based' => 'France',
            'main_countries' => 'France, Uk, Germany , Spain',
            'main_cities' => 'Paris, London Frankfurt, Madrid',
            'sector' => 'Helthcare life science, E-Commerce, Internet Software service, Tech, media and telecom, Software business services',
            'geo_focus' => 'Europe',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('peccs')->insert([
            'logo' => 'factory/stock/company-logo.jpg',
            'fund' => 'PAI partners',
            'type' => 'Private equity, VC',
            'region' => 'France+ Benelux',
            'based' => 'France',
            'main_countries' => 'France , UK , Germany, Spain',
            'main_cities' => 'Paris, London Frankfurt, Madrid',
            'sector' => 'Business Serivices & Distribution, Food consumer, General industrials, Healthcare',
            'geo_focus' => 'Europe and USA',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('peccs')->insert([
            'logo' => 'factory/stock/company-logo.jpg',
            'fund' => 'Astorg',
            'type' => 'Private equity, VC',
            'region' => 'France+ Benelux',
            'based' => 'France',
            'main_countries' => 'France, Uk, Germany , Italy',
            'main_cities' => 'Paris, London Frankfurt, Milan',
            'sector' => 'Healthcare, B2B Services, Software, TMT, Aerospace, mediatelecom, Chemicals, Manufacturing',
            'geo_focus' => 'Europe & USA',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('peccs')->insert([
            'logo' => 'factory/stock/company-logo.jpg',
            'fund' => 'Equistone',
            'type' => 'Private Equity ',
            'region' => 'France+ Benelux',
            'based' => 'France',
            'main_countries' => 'France, UK, Germany, Switzerland',
            'main_cities' => 'Paris, London, Munich, Zurich',
            'sector' => 'ALL',
            'geo_focus' => 'Europe ',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        // 20
        DB::table('peccs')->insert([
            'logo' => 'factory/stock/company-logo.jpg',
            'fund' => 'Triton',
            'type' => 'Private equity',
            'region' => 'DACH',
            'based' => 'Germany',
            'main_countries' => 'Germany,Uk , Italy',
            'main_cities' => 'Frankfurt, London, Milan',
            'sector' => 'Businnes services, Industrial,  Consumer, Health',
            'geo_focus' => 'Europe & USA',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('peccs')->insert([
            'logo' => 'factory/stock/company-logo.jpg',
            'fund' => 'Partners Group',
            'type' => 'Private equtiy',
            'region' => 'DACH',
            'based' => 'Switzerland',
            'main_countries' => 'Switzerland,Germany, France, Luxemburg',
            'main_cities' => 'Zug, Munich, Paris, Luxemburg',
            'sector' => 'Healthcare, consumer, Media & telecom, Information technology, Industrials, infrastructure, energy, Financial services, Real state',
            'geo_focus' => 'Americas, Asia-Pacific, Europe',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('peccs')->insert([
            'logo' => 'factory/stock/company-logo.jpg',
            'fund' => 'Capvis',
            'type' => 'Private equity',
            'region' => 'DACH',
            'based' => 'Switzerland',
            'main_countries' => 'Switzerland ',
            'main_cities' => 'Baar',
            'sector' => 'Healthcare, Industrial technology, Advanced services & Softwares',
            'geo_focus' => 'Europe',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('peccs')->insert([
            'logo' => 'factory/stock/company-logo.jpg',
            'fund' => 'DBAG',
            'type' => 'Private equity, VC',
            'region' => 'DACH',
            'based' => 'Germany',
            'main_countries' => 'Germany',
            'main_cities' => 'Frankfurt',
            'sector' => 'Industrial Services, mechanical and engineering, industrial components, industrial components.',
            'geo_focus' => 'Europe Mostly Germany',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('peccs')->insert([
            'logo' => 'factory/stock/company-logo.jpg',
            'fund' => 'CASTIK Capital Partners',
            'type' => 'Private equity, VC',
            'region' => 'DACH',
            'based' => 'Germany',
            'main_countries' => 'Germany',
            'main_cities' => 'Munich',
            'sector' => 'Precision Manufacturing, IOT solutions, Healthcare, Software, business services',
            'geo_focus' => 'Europe',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('peccs')->insert([
            'logo' => 'factory/stock/company-logo.jpg',
            'fund' => 'Investindustrial',
            'type' => 'Private equity, VC',
            'region' => 'South Europeans Funds',
            'based' => 'Spain',
            'main_countries' => 'Spain, Switzerland',
            'main_cities' => 'Madrid, Lugano',
            'sector' => 'Healtchare consumer and leisure, industrial Manufacturing, Technology',
            'geo_focus' => 'Europe',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('peccs')->insert([
            'logo' => 'factory/stock/company-logo.jpg',
            'fund' => 'F2i',
            'type' => 'Private equity, VC',
            'region' => 'South Europeans Funds',
            'based' => 'Italy',
            'main_countries' => 'Italy',
            'main_cities' => 'Milan',
            'sector' => 'All',
            'geo_focus' => 'Europe Mostly Italy',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('peccs')->insert([
            'logo' => 'factory/stock/company-logo.jpg',
            'fund' => 'FSI',
            'type' => 'Private equity, VC',
            'region' => 'South Europeans Funds',
            'based' => 'Italy',
            'main_countries' => 'italy',
            'main_cities' => 'Milan',
            'sector' => 'Fintech, engineering, fashion, biopharmaceutical',
            'geo_focus' => 'Europe',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('peccs')->insert([
            'logo' => 'factory/stock/company-logo.jpg',
            'fund' => 'NB renaissance partners',
            'type' => 'Private equity, VC',
            'region' => 'South Europeans Funds',
            'based' => 'Italy',
            'main_countries' => 'Italy, Uk, Zurich',
            'main_cities' => 'Milan, london, Zurich',
            'sector' => 'All',
            'geo_focus' => 'Global',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('peccs')->insert([
            'logo' => 'factory/stock/company-logo.jpg',
            'fund' => 'Alpha Group',
            'type' => 'Private equity, VC',
            'region' => 'South Europeans Funds',
            'based' => 'Italy',
            'main_countries' => 'Italy, Germany, France',
            'main_cities' => 'Milan, Frankfurt, Paris',
            'sector' => 'industrial, consumer and leisure, fashion & design',
            'geo_focus' => 'Europe',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        // 30
        DB::table('peccs')->insert([
            'logo' => 'factory/stock/company-logo.jpg',
            'fund' => 'MBK Partners',
            'type' => 'Private Equity',
            'region' => 'Asia',
            'based' => 'South Korea',
            'main_countries' => 'South Korea',
            'main_cities' => 'Seoul',
            'sector' => 'All',
            'geo_focus' => 'North Asia',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('peccs')->insert([
            'logo' => 'factory/stock/company-logo.jpg',
            'fund' => 'Affinity equity Partners',
            'type' => 'Private Equity',
            'region' => 'Asia',
            'based' => 'Hong Kong',
            'main_countries' => 'Hong kong, Singapore, Korea, Australia',
            'main_cities' => 'Hong kong, Singapore, Seoul, Sidney',
            'sector' => 'consumer-related goods and services, food and beverage, healthcare and pharmaceutical, financial services, telecom and media, environmental businesses, agriculture and natural resources. We do not invest in companies whose principal business activities are real estate, biotechnology, tobacco, oil and gas exploration, and weaponry development and sales.',
            'geo_focus' => 'APAC',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('peccs')->insert([
            'logo' => 'factory/stock/company-logo.jpg',
            'fund' => 'RRj Capital',
            'type' => 'Private Equity',
            'region' => 'Asia',
            'based' => 'Hong Kong',
            'main_countries' => 'Hong kong, Singapore',
            'main_cities' => 'Hong kong, Singapore',
            'sector' => 'healthcare, financial institutions, technology, and logistics.',
            'geo_focus' => 'APAC, Europe, USA',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('peccs')->insert([
            'logo' => 'factory/stock/company-logo.jpg',
            'fund' => 'Baring Private equity Asia',
            'type' => 'Private Equity',
            'region' => 'Asia',
            'based' => 'Hong Kong',
            'main_countries' => 'Hong kong, China, India',
            'main_cities' => 'Hong Kong, Beijing, Mumbai',
            'sector' => 'All',
            'geo_focus' => 'APAC',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('peccs')->insert([
            'logo' => 'factory/stock/company-logo.jpg',
            'fund' => 'CITIC PE',
            'type' => 'Private Equity',
            'region' => 'Asia',
            'based' => 'China',
            'main_countries' => 'China, Hong kong',
            'main_cities' => 'Beijing,  Hong Kong',
            'sector' => 'healthcare, Consumer and internet, Technology and industrial , Software',
            'geo_focus' => 'APAC',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('peccs')->insert([
            'logo' => 'factory/stock/company-logo.jpg',
            'fund' => 'CDH Investments',
            'type' => 'Private Equity , VC',
            'region' => 'Asia',
            'based' => 'China',
            'main_countries' => 'China, Hong kong',
            'main_cities' => 'Beijing,  Hong Kong',
            'sector' => 'Retail, consumer goods, industrial Energy, Financial services, TMT, Automotiles, Logistic',
            'geo_focus' => 'Asia Mostly china',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('peccs')->insert([
            'logo' => 'factory/stock/company-logo.jpg',
            'fund' => 'CITIC Capital',
            'type' => 'Private Equity',
            'region' => 'Asia',
            'based' => 'China',
            'main_countries' => 'China , Japan',
            'main_cities' => 'Tokyo , Beijing',
            'sector' => 'All',
            'geo_focus' => 'APAC',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('peccs')->insert([
            'logo' => 'factory/stock/company-logo.jpg',
            'fund' => 'PAG',
            'type' => 'Private Equity',
            'region' => 'Asia',
            'based' => 'Japan',
            'main_countries' => 'Japan, Singapore, South korea, Australia, Switzerland',
            'main_cities' => 'Tokyo, Singapore, Seoul, Sidney, Geneva',
            'sector' => 'Business and product services, Consumers, tech, financials services, media & enterteiment',
            'geo_focus' => 'Americas, Asia-Pacific, Europe',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('peccs')->insert([
            'logo' => 'factory/stock/company-logo.jpg',
            'fund' => 'Hopu Investments Management',
            'type' => 'Private Equity, VC',
            'region' => 'Asia',
            'based' => 'China',
            'main_countries' => 'China',
            'main_cities' => 'Beijing ',
            'sector' => 'NI',
            'geo_focus' => 'Asia ',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('peccs')->insert([
            'logo' => 'factory/stock/company-logo.jpg',
            'fund' => 'Hony Capital',
            'type' => 'Private Equity',
            'region' => 'Asia',
            'based' => 'China',
            'main_countries' => 'China, Hong kong',
            'main_cities' => 'Beijing,  Hong Kong',
            'sector' => 'pharmaceutical and healthcare, consumer products, catering, media and entertainment, environmental protection and new energy',
            'geo_focus' => 'Global',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        //40
        DB::table('peccs')->insert([
            'logo' => 'factory/stock/company-logo.jpg',
            'fund' => 'Ince Capital Partners',
            'type' => 'Private Equity',
            'region' => 'Asia',
            'based' => 'China',
            'main_countries' => 'China, Hong kong',
            'main_cities' => 'Beijing,  Hong Kong',
            'sector' => 'Internet consumer and intelligent technologies',
            'geo_focus' => 'China',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('peccs')->insert([
            'logo' => 'factory/stock/company-logo.jpg',
            'fund' => 'Mercury Capital',
            'type' => 'Private Equity, Direct placement',
            'region' => 'Asia',
            'based' => 'Japan',
            'main_countries' => 'Japan, Singapore, India',
            'main_cities' => 'Tokyo, Singapore, New Dehli',
            'sector' => 'NI',
            'geo_focus' => 'Global',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('peccs')->insert([
            'logo' => 'factory/stock/company-logo.jpg',
            'fund' => 'Olympus Capital',
            'type' => 'Private Equity, VC',
            'region' => 'Asia',
            'based' => 'China',
            'main_countries' => 'China, India',
            'main_cities' => 'Shangai, Delhi',
            'sector' => 'including financial services, environmental services, business services, healthcare and renewable energy,',
            'geo_focus' => 'Asia',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('peccs')->insert([
            'logo' => 'factory/stock/company-logo.jpg',
            'fund' => 'Tiger Global Management',
            'type' => 'Private Equity, VC',
            'region' => 'Asia',
            'based' => 'China',
            'main_countries' => 'China/ Usa',
            'main_cities' => 'New york',
            'sector' => 'nternet, technology, telecom, media consumer, and industrial',
            'geo_focus' => 'Global',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

    }
}
