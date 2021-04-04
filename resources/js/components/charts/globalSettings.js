Chart.defaults.global.datasets.bar.borderWidth = 2;
Chart.scaleService.updateScaleDefaults("linear", {
    ticks: {
        callback: function(value) {
            return "$ " + value.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,");
        }
    }
});
Chart.defaults.global.tooltips.callbacks.label = function(tooltipItem, data) {
    return (
        "$ " + tooltipItem.yLabel.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,")
    );
};

export default Chart;
