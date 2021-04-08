<script>
import { Pie, mixins } from "vue-chartjs";
const { reactiveProp } = mixins;
export default {
    extends: Pie,
    mixins: [reactiveProp],
    props: ["bus", "chartData", "options"],
    methods: {
        update() {
            this.$data._chart.update();
            this.chartData.datasets[0].borderColor = this.$vuetify.theme.currentTheme.borderPie;
        },
        reRender() {
            this.chartData.datasets[0].borderColor = this.$vuetify.theme.currentTheme.borderPie;
            this.renderChart(this.chartData, this.options);
        }
    },
    mounted() {
        //
        this.chartData.datasets[0].borderColor = this.$vuetify.theme.currentTheme.borderPie;
        this.bus.$on("updateOptions", this.reRender);
        this.bus.$on("updateChart", this.update);
        this.renderChart(this.chartData, this.options);
    }
};
</script>
