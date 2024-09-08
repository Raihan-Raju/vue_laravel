<script>
import axios from 'axios'

export default {
    data() {
        return {
            orders: [],
            delivery_date: "",
            recipient: "",
            recipient_phone: "",
            address: "",
            status: "a",
            order_id: "",
        }
    },

    methods: {
        getInfo() {
            axios.get('http://127.0.0.1:8000/api/admin/orders')
                .then((result) => {
                    this.orders = result.data.data;
                    console.log(this.orders);
                })
        },
        storeData() {
            const shipData = {
                delivery_date: this.delivery_date,
                recipient: this.recipient,
                recipient_phone: this.recipient_phone,
                address: this.address,
                status: this.status,
                order_id: this.order_id,
            }

            console.log('true');

            axios.post("http://127.0.0.1:8000/api/admin/shipments", shipData)
                .then((response) => {
                    console.log(response);
                    this.$router.push({ name: 'shipment-list' });
                });
        }

    },

    mounted() {
        this.getInfo();
    }
}

</script>

<template>
    <div>
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Shipment Add</h5>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label" for="basic-default-fullname">Delivery Date</label>
                <input v-model="delivery_date" type="date" class="form-control" id="basic-default-fullname"
                    placeholder="John Doe" />
            </div>
            <div class="mb-3">
                <label class="form-label" for="basic-default-fullname">Recipient</label>
                <input v-model="recipient" type="text" class="form-control" id="basic-default-fullname"
                    placeholder="recipient" />
            </div>
            <div class="mb-3">
                <label class="form-label" for="basic-default-fullname">Recipient Phone</label>
                <input v-model="recipient_phone" type="text" class="form-control" id="basic-default-fullname"
                    placeholder="mobile number" />
            </div>
            <div class="mb-3">
                <label class="form-label" for="basic-default-fullname">Address</label>
                <input v-model="address" type="text" class="form-control" id="basic-default-fullname"
                    placeholder="address" />
            </div>
            <div class="mb-3">
                <label class="form-label" for="basic-default-fullname">Status</label>
                <select v-model="status" class="form-control">
                    <option value="a">select status</option>
                    <option value="pending">Pending</option>
                    <option value="processing">Processing</option>
                    <option value="shipped">Shipped</option>
                    <option value="route">On Route</option>
                    <option value="delivered">Delivered</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
            



        <div class="mb-3">
            <label class="form-label" for="basic-default-company">Order Id</label>
            <input type="text" class="form-control" list="tt1" id="tt" v-model="order_id"
                placeholder="select order id">
            <datalist id="tt1">
                <option disabled value="">Select a order</option>
                <option v-for="(p, i) in orders" :key="i" :value="p.id">{{ p.id }}</option>
            </datalist>
            <small v-if="!order_id" class="">Please select a order</small>
        </div>

        
        <button @click="storeData" type="submit" class="btn btn-primary">Submit</button>
    </div>
    </div>
</template>