<script>
import { Pie } from "vue-chartjs";

export default {
    extends: Pie,
    props: ["mode", "chartData", "options"],
    mounted() {
        if (this.mode === "thumbnail") {
            this.options.legend.display = false;
            this.options.title.display = false;
            // this.options.scales.yAxes[0].ticks.display = false;
            // this.options.scales.xAxes[0].ticks.display = false;
        }

        this.renderChart(this.chartData, this.options);
    }
};
</script>
