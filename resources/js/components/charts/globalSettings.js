Chart.defaults.global.datasets.bar.borderWidth = 2;
Chart.defaults.global.defaultFontFamily = "'Roboto', sans-serif";

let fontColor = "#666";
let fontWeight = "normal";

const theme = localStorage.getItem("dark_theme");
if (theme) {
    if (theme === "true") {
        fontColor = "#c1c2c4";
        fontWeight = "500";
    } else {
        fontColor = "#767676";
        fontWeight = "400";
    }
}

Chart.defaults.global.defaultFontColor = fontColor;
Chart.defaults.global.defaultFontStyle = fontWeight;
Chart.scaleService.updateScaleDefaults("linear", {
    ticks: {
        callback: function(value) {
            return value.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,");
        }
    }
});
Chart.defaults.global.tooltips.callbacks.label = function(tooltipItem, data) {
    return tooltipItem.yLabel.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,");
};
export default Chart;
