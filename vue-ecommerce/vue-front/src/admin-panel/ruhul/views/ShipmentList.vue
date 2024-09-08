
<script>
import axios from 'axios'

export default {
    data() {
        return {
            list: []
        }
    },

    methods: {
        getUseCupons() {
            axios.get('http://127.0.0.1:8000/api/admin/shipments/')
                .then((result) => {
                    this.list = result.data.data;
                    console.log(result.data.data);
                })
        },
        deletecupons(id) {
            axios.delete("http://127.0.0.1:8000/api/admin/shipments/" + id).then(() => {
                this.getUseCupons()
                alert('This fields deleted successfully!');
            });
        },
        update(id){
            this.$router.push(`/admin/shipment/shipment-edit/${id}`)

        }
    },

    mounted(){
    this.getUseCupons()
  },
};
</script>

<template>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col">
                    <h5 class="mb-0">Shipment List</h5>
                </div>
                <div class="col-auto">
                    <router-link :to="{name: 'shipment-add'}" class="btn btn-primary btn-lg">Add More</router-link>
                </div>
            </div>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Delivery Date</th>
                        <th>Recipient</th>
                        <th>Recipient Phone</th>
                        <th>Address</th>
                        <th>Status</th>
                        <th>Order Id</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    <tr v-for="(c, i) in list" :key="i">
                        <td>{{ i + 1 }}</td>
                        <td>{{ c.delivery_date }}</td>
                        <td>{{ c.recipient }}</td>
                        <td>{{ c.recipient_phone }}</td>
                        <td>{{ c.address }}</td>
                        <td>{{ c.status }}</td>
                        <td>{{ c.order_id }}</td>
                        <td>
                          <button @click="update(c.id)" class="btn btn-info"><i class='bx bxs-edit'></i></button> 
                            &nbsp;
                          <button @click="deletecupons(c.id)" class="btn btn-danger"><i class='bx bxs-trash'></i></button>
                        </td>
                        <!-- <td>
                            <router-link :to="{ name: 'cartUpdate', params: { id: c.id } }" class="btn btn-info mr-2">Edit</router-link>
                            <button @click="deleteCupons(c.id)" class="btn btn-danger">Delete</button>
                        </td> -->
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</template>