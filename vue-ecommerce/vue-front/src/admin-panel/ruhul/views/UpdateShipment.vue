<script>
import axios from 'axios'

export default {
    data() {
        return {
            orders: [],
            delivery_date: 0,
            recipient: 0,
            recipient_phone: 0,
            address: 0,
            status: 0,
            order_id: 0,
            id: this.$route.params.id
        }
    },

    methods: {

        getInfo() {
            axios.get('http://127.0.0.1:8000/api/admin/orders')
                .then((result) => {
                    this.orders = result.data.data;
                })
        },

        getShipments() {
            axios.get("http://127.0.0.1:8000/api/admin/shipments/" + this.id + '/edit')
                .then((response) => {
                    const ship = response.data.data;
                    this.delivery_date = ship.delivery_date;
                    this.recipient = ship.recipient;
                    this.recipient_phone = ship.recipient_phone;
                    this.address = ship.address;
                    this.status = ship.status;
                    this.order_id = ship.order_id;
                });
        },

        updateship() {
            const shipData = {
              delivery_date: this.delivery_date,
              recipient: this.recipient,
              recipient_phone: this.recipient_phone,
              address: this.address,
              status: this.status,
              order_id: this.order_id,

            }

            axios.put("http://127.0.0.1:8000/api/admin/shipments/"+this.id, shipData)
                .then((response) => {
                 console.log(response);
                 this.$router.push({ name: "shipment-list" })
                });
        }

    },

    mounted() {
        this.getInfo();
        this.getShipments();
    }
}

</script>


<template>
    <div>
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Shipment Update</h5>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <label class="form-label" for="basic-default-fullname">Delivery Date</label>
            <input v-model="delivery_date" type="datetime" class="form-control" id="basic-default-fullname"
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
            <select class="form-select" v-model="order_id">
                <option value="0">Open this select menu</option>
                <option v-for="(p, i) in orders" :key="i" :value="p.id">{{ p.id }}</option>
            </select>
        </div>
        <button @click="updateship" type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>
</template>