<script>
import { Bar } from "vue-chartjs";

export default {
    extends: Bar,
    props: ["bus", "mode", "chartData", "options"],
    methods: {
        update() {
            this.$data._chart.update();
        },
        reRender() {
            this.renderChart(this.chartData, this.options);
        }
    },
    mounted() {
        if (this.bus) {
            this.bus.$on("chartReRender", this.reRender);
            this.bus.$on("chartReload", this.update);
        }

        if (this.mode === "thumbnail") {
            this.options.legend.display = false;
            this.options.title.display = false;
            this.options.scales.yAxes[0].ticks.display = false;
            this.options.scales.xAxes[0].ticks.display = false;
        }

        this.renderChart(this.chartData, this.options);
    }
};
</script>
