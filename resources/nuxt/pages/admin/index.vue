<template>
    <div class="p-2 border border-gray-500 mt-4">
        <label class="block mb-2 font-bold"> Coba Chart </label>

        <client-only>
            <line-chart :data="chartData" />
        </client-only>
    </div>
</template>
  
<script>
export default {
    data() {
        return {
            chartData: {
                datasets: [{
                    label: 'My First Dataset',
                    data: [65, 59, 80, 81, 56, 55, 40],
                    fill: false,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                },

                {
                    label: 'My First Dataset',
                    data: [77, 12, 33, 22, 123, 22, 1],
                    fill: false,
                    borderColor: 'rgb(75, 192, 122)',
                    tension: 0.1
                }
                ]
            }
        };
    }
}
</script>