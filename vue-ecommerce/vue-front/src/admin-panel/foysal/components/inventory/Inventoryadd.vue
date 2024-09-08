<script>
import axios from 'axios';

export default {
    data() {
        return {
            products: [],
            product_id: '',
            quantity: '',
            errors: {}
        };
    },
    methods: {
        validateForm() {
            this.errors = {};
            if (!this.product_id) {
                this.errors.product_id = 'Product is required.';
            }
            if (!this.quantity) {
                this.errors.quantity = 'quantity  is required.';
            }
            return Object.keys(this.errors).length === 0;
        },
        storeProductPrice() {
            if (this.validateForm()) {
                const pData = {
                    product_id: this.product_id,
                    quantity: this.quantity,
                };
                axios.post("http://127.0.0.1:8000/api/admin/inventory/", pData)
                    .then((response) => {
                        console.log(response);
                        this.$router.push('/admin/inventory/inventorylist');
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }
        },
        getData() {
            axios.get('http://127.0.0.1:8000/api/admin/inventory/create')
                .then((result) => {
                    this.products = result.data.data.product_inventory;
                    console.log(result.data.data);
                });
        }
    },
    mounted() {
        this.getData();
    }
};
</script>

<template>
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Product inventory</h5>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <label class="form-label" for="usage-count-input">Quantity</label>
            <input v-model="quantity" type="number" class="form-control" id="usage-count-input"
                placeholder="quantity" />
            <small v-if="!quantity" class="">Please enter quantity.</small>
        </div>
        <div class="mb-3">
            <input type="text" class="form-control" list="tt1" id="tt" v-model="product_id"
                placeholder="select products">
            <datalist id="tt1">
                <option disabled value="">Select a product</option>
                <option v-for="(p, i) in products" :key="i" :value="p.id">{{ p.name }}</option>
            </datalist>
            <small v-if="!product_id" class="">Please select a product</small>
        </div>
        <button @click="storeProductPrice" type="submit" class="btn btn-primary">Submit</button>
    </div>
</template>
