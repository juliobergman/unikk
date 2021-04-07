<script>
import { Line, mixins } from "vue-chartjs";
const { reactiveProp } = mixins;
export default {
    extends: Line,
    mixins: [reactiveProp],
    props: ["bus", "chartData", "options"],
    methods: {
        update() {
            this.$data._chart.update();
        },
        reRender() {
            this.renderChart(this.chartData, this.options);
        }
    },
    mounted() {
        this.bus.$on("updateOptions", this.reRender);
        this.bus.$on("updateChart", this.update);
        this.renderChart(this.chartData, this.options);
    }
};
</script>
