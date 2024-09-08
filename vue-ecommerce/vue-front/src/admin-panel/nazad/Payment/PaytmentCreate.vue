<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms/</span> Vertical Layouts</h4>

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Payment Create Form</h5>
                        <small class="text-muted float-end">Default label</small>
                    </div>
                    <div class="card-body">
                        <form v-on:submit.prevent="save">
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-fullname">Date</label>
                                <input type="datetime-local" v-model="date" class="form-control" id="date"
                                    placeholder="John Doe" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-phone">Order Id</label>
                                <input type="text" v-on:keyup="order" v-model="order_id" id="order" class="form-control phone-mask"
                                    placeholder="123456" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-phone">Amount</label>
                                <input type="number" v-model="amount" id="amount" class="form-control"
                                     disabled />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-email">Method</label>
                                <div class="input-group input-group-merge">
                                    <select class="form-control" v-model="method" @onchange="this.value" >
                                        <option >Select one</option>
                                        <option value="bkash">Bikash</option>
                                        <option value="cash">Cash On</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios';

export default {
    data() {
        return {
            url: 'http://localhost:8000/api/admin/payments',
            urll: 'http://localhost:8000/api/admin/orders',
            list:[],
            list2:[],
            date: "",
            method: "",
            amount: "",
            status: "1",
            order_id: "",

        }
    },
    methods: {
        getOrderList(){
            axios.get(this.url,{

            }).then((result) => {
                this.list = result.data.data    
                console.log(result.data.data)
                }, (error) => {
                    console.log(error);
                });
        },
        save() {
            axios.post(this.url, {
                     date:this.date,
                     method:this.method,
                     amount:this.amount,
                     status:this.status,
                     order_id:this.order_id
            })
                .then((response) => {
                    this.$router.push('/admin/payment');
                }, (error) => {
                    console.log(error);
                });

        },
        order(){
            var value1 = parseFloat($('#order').val()) || 0;
            // console.log(value1)
            axios.get(`${this.urll}/${value1}/edit`)
                .then((result) => {
                    this.amount= result.data.data.total_price
                });
        },
    },
    mounted(){
        this.getOrderList()
    }
}
</script>