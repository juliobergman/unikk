export function processLabels(labels) {
    if (typeof labels === "string") {
        // Check if is String
        labels = labels.split(","); // Split to Array
    }
    labels = labels.map(e => e.trim());
    labels = labels.filter(el => el != null && el != "");
    return labels;
}

export function say(data) {
    console.log("say", data);
}
