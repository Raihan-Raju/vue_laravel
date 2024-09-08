<script>
import axios from 'axios'
export default {
    data() {
        return {
            data: [],
            url: this.$store.state.base.url
        }
    },
    methods: {
        getData() {
            axios.get(this.url + 'admin/flight')
                .then((result) => {
                    this.data = result.data;
                    console.log(this.data);
                })
        }
    },
    mounted() {
        this.getData();
    }
}
</script>


<template>
    <div class="card">
        <h5 class="card-header">Bordered Table</h5>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Flight</th>
                            <th>Aircraft</th>
                            <th>Class</th>
                            <th>FARE</th>
                            <th>ROUTE</th>
                            <th>DEPARTURE</th>
                            <th>ARRIVAL</th>
                            <th>DURATION</th>
                            <th>PIRCE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(d, i) in data.flightOffer" :key="i">
                            <td>
                                <p v-for="(d, i) in d.itineraries[0].segments" :key="i">{{ d.carrierCode+''+d.flightNumber }}</p>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>