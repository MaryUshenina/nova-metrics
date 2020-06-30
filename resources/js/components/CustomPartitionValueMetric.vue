<template>
    <loading-card :loading="loading" class="px-6 py-4">
        <h3 class="flex mb-3 text-base text-80 font-bold">
            {{ card.name}}
        </h3>

        <div class="overflow-hidden overflow-y-auto max-h-90px">
            <ul class="list-reset">
                <li
                    v-for="item in formattedItems"
                    class="text-80 leading-normal"
                >
          <span
              class="inline-block rounded-full w-2 h-2 mr-2"
              :style="{
              backgroundColor: item.color,
            }"
          />{{ item.label }} - {{ item.value }}

                </li>
            </ul>
        </div>

    </loading-card>
</template>

<script>

    import {Minimum} from "laravel-nova";
    import CustomPartitionMetric from "./CustomPartitionMetric.vue";

    const colorForIndex = index =>
        [
            '#F5573B',
            '#F99037',
            '#F2CB22',
            '#8FC15D',
            '#098F56',
            '#47C1BF',
            '#1693EB',
            '#6474D7',
            '#9C6ADE',
            '#E471DE',
        ][index]

    export default {
        extends: CustomPartitionMetric,

        props: {
            card: {
                type: Object,
                required: true,
            },

            resourceName: {
                type: String,
                default: '',
            },

            resourceId: {
                type: [Number, String],
                default: '',
            },

            lens: {
                type: String,
                default: '',
            },

        },

        methods: {

            fetch() {
                this.loading = true;
                Minimum(Nova.request().get(this.metricEndpoint, this.metricPayload)).then(
                    ({
                         data: {
                             value: {value}
                         }
                     }) => {
                        this.chartData = value;
                        this.loading = false;
                    }
                );
            },

            getItemColor(item, index) {
                return typeof item.color === 'string' ? item.color : colorForIndex(index)
            },
        },

        computed: {

            formattedChartData() {
                return {labels: this.formattedLabels, series: this.formattedData}
            },

            formattedItems() {
                return _(this.chartData)
                    .map((item, index) => {
                        return {
                            label: item.label,
                            value: item.value,
                            color: this.getItemColor(item, index),
                        }
                    })
                    .value()
            },

            formattedLabels() {
                return _(this.chartData)
                    .map(item => item.label)
                    .value()
            },

            formattedData() {
                return _(this.chartData)
                    .map((item, index) => {
                        return {
                            value: item.value,
                            meta: {color: this.getItemColor(item, index)},
                        }
                    })
                    .value()
            },
        }


    }
</script>

