<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FinancialFieldsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Data
        $data = [
            ['code'=>'3400', 'name'=> 'Income from Services'],
            ['code'=>'3410', 'name'=> 'Revenue Dividends Income'],
            ['code'=>'3415', 'name'=> 'Revenue Unrealized gains in trading securities'],
            ['code'=>'3420', 'name'=> 'Earnings from short-term financial investments'],
            ['code'=>'3425', 'name'=> 'Realized gains in  Private equity Holdings'],
            ['code'=>'3430', 'name'=> 'Interest gains from AFS debt investments'],
            ['code'=>'3435', 'name'=> 'Realized gains on AFS debt invesments'],
            ['code'=>'3440', 'name'=> 'Return on bank deposits'],
            ['code'=>'3445', 'name'=> 'Exchange gains'],
            ['code'=>'3450', 'name'=> 'Other Interest gains'],
            ['code'=>'3455', 'name'=> 'Revenue from Royalties'],
            ['code'=>'3460', 'name'=> 'Revenue from IP sales'],
            ['code'=>'3465', 'name'=> 'Gains on Cryptocurrency holdings value'],
            ['code'=>'3490', 'name'=> 'Discount'],
            ['code'=>'3491', 'name'=> 'Rebates and price deductions'],
            ['code'=>'3495', 'name'=> 'Losses from receivables'],
            ['code'=>'4400', 'name'=> 'Costs of services'],
            ['code'=>'4410', 'name'=> 'Investments Comision'],
            ['code'=>'4415', 'name'=> 'Management fees'],
            ['code'=>'4420', 'name'=> 'Brokerage Comissions'],
            ['code'=>'4425', 'name'=> 'Management fees Private equity'],
            ['code'=>'4430', 'name'=> 'Interest from leveraged investments'],
            ['code'=>'4435', 'name'=> 'Bank investments comissions (Private Equity)'],
            ['code'=>'4440', 'name'=> 'Other Investments Comissions'],
            ['code'=>'3600', 'name'=> 'Labor fees'],
            ['code'=>'3610', 'name'=> 'Techological tools Cost'],
            ['code'=>'3615', 'name'=> 'Bank comissions'],
            ['code'=>'3620', 'name'=> 'Other incubation cost'],
            ['code'=>'5400', 'name'=> 'Salary cost Services'],
            ['code'=>'5401', 'name'=> 'Allowances Services'],
            ['code'=>'5402', 'name'=> 'Bonuses Services'],
            ['code'=>'5403', 'name'=> 'Commissions Services'],
            ['code'=>'5405', 'name'=> 'Social security benefits '],
            ['code'=>'5409', 'name'=> 'Director Fees'],
            ['code'=>'5700', 'name'=> 'AHV, IV, EO, ALV'],
            ['code'=>'5710', 'name'=> 'FAK'],
            ['code'=>'5720', 'name'=> 'Occupational pension'],
            ['code'=>'5730', 'name'=> 'Accident insurance'],
            ['code'=>'5740', 'name'=> 'Daily sickness insurance'],
            ['code'=>'5790', 'name'=> 'Tax at source'],
            ['code'=>'5800', 'name'=> 'Staff recruitment'],
            ['code'=>'5810', 'name'=> 'Vocational education and traiding'],
            ['code'=>'5880', 'name'=> 'Other employee expenses'],
            ['code'=>'6000', 'name'=> 'Rent'],
            ['code'=>'6101', 'name'=> 'Expenses Furnishings and equipment'],
            ['code'=>'6160', 'name'=> 'Leasing tangible fixed assets'],
            ['code'=>'6200', 'name'=> 'Vehicle repair, service'],
            ['code'=>'6210', 'name'=> 'Vehicle fuel'],
            ['code'=>'6220', 'name'=> 'Vehicle insurance / vehicle tax'],
            ['code'=>'6260', 'name'=> 'Vehicle leasing'],
            ['code'=>'6270', 'name'=> 'Private share Vehicle expenses'],
            ['code'=>'6300', 'name'=> 'Insurance premiums'],
            ['code'=>'6360', 'name'=> 'Duties and charges'],
            ['code'=>'6400', 'name'=> 'Electricity/water/gas'],
            ['code'=>'6500', 'name'=> 'Office material'],
            ['code'=>'6503', 'name'=> 'Magazines, books'],
            ['code'=>'6510', 'name'=> 'Telephone, internet'],
            ['code'=>'6513', 'name'=> 'Postage'],
            ['code'=>'6520', 'name'=> 'Contributions, donations'],
            ['code'=>'6530', 'name'=> 'Accounting expenses'],
            ['code'=>'6531', 'name'=> 'Legal consulting'],
            ['code'=>'6532', 'name'=> 'Tax consulting'],
            ['code'=>'6533', 'name'=> 'Other consulting expenses'],
            ['code'=>'6540', 'name'=> 'Gsuites expenses'],
            ['code'=>'6550', 'name'=> 'Cloud Storage expenses'],
            ['code'=>'6560', 'name'=> 'Leasing and rent HW + SW'],
            ['code'=>'6570', 'name'=> 'Licenses and maintenance'],
            ['code'=>'6600', 'name'=> 'Advertising'],
            ['code'=>'6610', 'name'=> 'Promotional print material'],
            ['code'=>'6620', 'name'=> 'Exhibitions / decoration'],
            ['code'=>'6630', 'name'=> 'Web Hostung services'],
            ['code'=>'6640', 'name'=> 'Travel expenses'],
            ['code'=>'6641', 'name'=> 'Representation expenses '],
            ['code'=>'6642', 'name'=> 'Customer gifts'],
            ['code'=>'6700', 'name'=> 'Other expenses'],
            ['code'=>'6800', 'name'=> 'Depreciation on financial assets'],
            ['code'=>'6820', 'name'=> 'Depreciation on machinery and appliances'],
            ['code'=>'6821', 'name'=> 'Depreciation on furniture and equipment'],
            ['code'=>'6822', 'name'=> 'Depreciation on office equipment and computers'],
            ['code'=>'6823', 'name'=> 'Depreciation on vehicles'],
            ['code'=>'6830', 'name'=> 'Depreciation on immovable fixes assets'],
            ['code'=>'6840', 'name'=> 'Depreciation on intangible assets'],
            ['code'=>'6850', 'name'=> 'Depreciation on capitalized expenditure'],
            ['code'=>'6901', 'name'=> 'Interest expenses on loans'],
            ['code'=>'6940', 'name'=> 'Other Bank Charges'],
            ['code'=>'6949', 'name'=> 'Exchange losses'],
            ['code'=>'7500', 'name'=> 'Rental income'],
            ['code'=>'7510', 'name'=> 'Property expenses'],
            ['code'=>'7910', 'name'=> 'Gains on tangible fixed assets'],
            ['code'=>'8000', 'name'=> 'Non-company related expenditures'],
            ['code'=>'8100', 'name'=> 'Non-company related income'],
            ['code'=>'8900', 'name'=> 'Cantonal and municipal taxes'],
            ['code'=>'8901', 'name'=> 'Direct federal taxes']
        ];

        // Insert
        DB::table('financial_fields')->insert($data);
    }
}
