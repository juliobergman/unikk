<script>
import { Bar } from "vue-chartjs";

export default {
    extends: Bar,
    props: ["mode", "chartData", "options"],
    mounted() {
        if (this.mode === "thumbnail") {
            this.options.legend.display = false;
            this.options.title.display = false;
            this.options.scales.yAxes[0].ticks.display = false;
        }

        this.renderChart(this.chartData, this.options);
    }
};
</script>
