<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ChartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('charts')->insert([
            'user_id' => 1,
            'type' => 'barChart',
            'title' => 'Bar Chart',
            'info' => 'Nunc nisi mauris, dictum quis sem eu, lacinia consectetur erat. Quisque accumsan sit amet ligula et aliquam. Suspendisse tempus, sem eu accumsan porttitor, dui ex dignissim tellus, nec tempor massa turpis sed leo. Nullam elit augue, hendrerit vitae nibh eu, pretium aliquam enim. Suspendisse nec risus a quam aliquam accumsan in vel nisi. Maecenas fermentum justo laoreet, hendrerit turpis sed, sollicitudin lacus. Sed maximus consectetur lacus et suscipit. In hac habitasse platea dictumst. Maecenas rhoncus id turpis sodales sodales. Curabitur in orci sapien. Quisque laoreet nunc augue, consequat dapibus libero cursus ac. Ut molestie id tortor eget efficitur.',
            'chartdata' => '{"labels":["A","B","C","D","E"],"datasets":[{"label":"Data","backgroundColor":"#1A1AFF99","data":[45,50,85,95,120]},{"label":"Data","backgroundColor":"#FF881A99","data":[38,55,65,85,131]}]}',
            'chartoptions' => '{"responsive":true,"maintainAspectRatio":true,"title":{"display":false,"text":"Bar Chart","fontSize":16},"legend":{"display":true,"position":"bottom"},"scales":{"xAxes":[{"stacked":false,"ticks":{"display":true}}],"yAxes":[{"stacked":false,"ticks":{"display":true,"suggestedMin":"0","suggestedMax":"125"}}]}}',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('charts')->insert([
            'user_id' => 1,
            'type' => 'lineChart',
            'title' => 'Line Chart',
            'info' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec quis massa id sem pretium consequat non sed mi. Donec non accumsan nisi. Etiam mi leo, ultrices eget convallis ut, commodo vitae massa. Mauris eget ultrices ligula. Donec mattis nunc eget lobortis viverra. Maecenas tempor sagittis augue, sed tincidunt felis interdum et. Duis tincidunt leo quis tellus consectetur, interdum hendrerit dui pellentesque. Aenean vehicula neque vel posuere commodo. Donec bibendum, lorem nec euismod elementum, orci purus tempor nisi, nec pulvinar quam justo sit amet massa. In quis tempus risus. Vivamus non sodales felis, in vestibulum mi. Vivamus sagittis quis neque eget commodo. Vestibulum vitae fringilla odio, in consequat elit.',
            'chartdata' => '{"labels":["A","B","C","D","E","F"],"datasets":[{"label":"Data 1","backgroundColor":"#1A1AFF40","borderColor":"#1A1AFF99","pointBackgroundColor":"#1A1AFF99","borderWidth":3,"fill":false,"tension":0,"spanGaps":true,"borderDash":[0,0],"showLine":true,"pointRadius":3,"data":[20,20,27,14,38,91]},{"label":"Data 2","backgroundColor":"#FF7A1A40","borderColor":"#FF7A1AB9","pointBackgroundColor":"#FF7A1AB9","borderWidth":4,"fill":false,"tension":0,"spanGaps":true,"borderDash":[7,10.300000000000000710542735760100185871124267578125],"showLine":true,"pointRadius":3,"data":[38,null,null,null,null,61]},{"label":"Data 3","backgroundColor":"#34FF1A40","borderColor":"#34FF1A99","pointBackgroundColor":"#34FF1A99","borderWidth":3,"fill":true,"tension":0.299999999999999988897769753748434595763683319091796875,"spanGaps":true,"borderDash":[0,0],"showLine":true,"pointRadius":3,"data":[56,34,60,39,75,49]}]}',
            'chartoptions' => '{"responsive":true,"maintainAspectRatio":true,"title":{"display":false,"text":"Line Chart","fontSize":16},"legend":{"display":true,"position":"bottom"},"scales":{"xAxes":[{"ticks":{"display":true}}],"yAxes":[{"stacked":false,"ticks":{"display":true,"suggestedMin":"0","suggestedMax":"100"}}]}}',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('charts')->insert([
            'user_id' => 1,
            'type' => 'pieChart',
            'title' => 'Pie Chart',
            'info' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris viverra, nunc ut facilisis interdum, eros justo molestie ligula, non tincidunt nisi ex eget lorem. In sit amet felis pretium, commodo nisi sed, tristique nisi. Suspendisse potenti. Curabitur auctor ipsum neque, sit amet finibus sem tempor ut. Pellentesque hendrerit ligula a odio tempus, vitae rutrum urna tempus. Duis et pellentesque arcu. Ut vehicula ipsum vel lorem ullamcorper, non tristique augue aliquet. Pellentesque viverra nisi ut vestibulum imperdiet. Nullam elementum lectus justo, eget facilisis diam auctor sed.',
            'chartdata' => '{"labels":["A","B","C"],"datasets":[{"label":"Data","backgroundColor":["#1A1AFF99","#FF881A99","#34FF1A99"],"borderWidth":3,"data":[59,57,76]}]}',
            'chartoptions' => '{"responsive":true,"maintainAspectRatio":true,"title":{"display":true,"text":"Pie Chart","fontSize":16},"legend":{"display":true,"position":"bottom"}}',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('charts')->insert([
            'user_id' => 1,
            'type' => 'lineChart',
            'title' => 'Scatter Chart',
            'info' => 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nam ut ante pretium, varius leo quis, finibus felis. Vivamus aliquet metus sed sapien commodo bibendum. Etiam ullamcorper justo vitae metus sollicitudin, et dictum nisl malesuada. Quisque volutpat turpis sed tellus fringilla, id porttitor tellus laoreet. Nam in mi in dui suscipit venenatis. Etiam aliquet augue sed nisi ullamcorper vehicula. Ut sollicitudin, urna convallis mollis viverra, sapien arcu bibendum odio, sit amet laoreet metus velit in enim. Aenean ut vehicula eros. Suspendisse a arcu sem. Pellentesque in imperdiet enim. Nulla vitae orci sed dui molestie viverra vitae suscipit massa. Donec fermentum quis purus nec interdum.',
            'chartdata' => '{"labels":["0","10","20","30","40","50","60","70","80","90","100"],"datasets":[{"label":"Data 1","backgroundColor":"#1A1AFF40","borderColor":"#1A1AFF99","pointBackgroundColor":"#1A1AFF99","borderWidth":1,"fill":false,"tension":0.299999999999999988897769753748434595763683319091796875,"spanGaps":true,"borderDash":[0,0],"showLine":false,"pointRadius":5,"data":[32,37,24,33,15,19,40,28,37,27,38]},{"label":"Data 2","backgroundColor":"#FF1AC740","borderColor":"#FF1AC799","pointBackgroundColor":"#FF1AC799","borderWidth":1,"fill":false,"tension":0.299999999999999988897769753748434595763683319091796875,"spanGaps":true,"borderDash":[0,0],"showLine":false,"pointRadius":6,"data":[62,87,75,88,75,61,92,88,83,62,72]},{"label":"Data 3","backgroundColor":"#23FF1A40","borderColor":"#23FF1A99","pointBackgroundColor":"#23FF1A99","borderWidth":1,"fill":false,"tension":0.460000000000000019984014443252817727625370025634765625,"spanGaps":true,"borderDash":[0,0],"showLine":false,"pointRadius":5,"data":[56,23,62,47,40,25,77,67,64,34,60]},{"label":"Data 4","backgroundColor":"#361AFF40","borderColor":"#361AFF99","pointBackgroundColor":"#361AFF99","borderWidth":3,"fill":true,"tension":0.299999999999999988897769753748434595763683319091796875,"spanGaps":true,"borderDash":[0,0],"showLine":true,"pointRadius":0,"data":[44,null,null,62,null,null,43,null,null,68,64]},{"label":"Data 5","backgroundColor":"#FA028D40","borderColor":"#FA028D99","pointBackgroundColor":"#FA028D99","borderWidth":3,"fill":false,"tension":0.270000000000000017763568394002504646778106689453125,"spanGaps":true,"borderDash":[6.70000000000000017763568394002504646778106689453125,5.70000000000000017763568394002504646778106689453125],"showLine":true,"pointRadius":0,"data":[95,null,null,null,null,75,null,null,null,null,49]}]}',
            'chartoptions' => '{"responsive":true,"maintainAspectRatio":true,"title":{"display":false,"text":"Scatter Chart","fontSize":16},"legend":{"display":true,"position":"bottom"},"scales":{"xAxes":[{"ticks":{"display":true}}],"yAxes":[{"stacked":false,"ticks":{"display":true,"suggestedMin":"0","suggestedMax":"100"}}]}}',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
