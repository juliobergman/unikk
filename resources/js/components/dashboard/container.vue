<template>
    <financial-statement :bus="bus"></financial-statement>
</template>

<script>
import FinancialStatement from "../financial/section/financialStatement";
export default {
    props: ["bus"],
    components: {
        FinancialStatement
    }
};
</script>
