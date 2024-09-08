<script>
import axios from 'axios';

export default {
    data() {
        return {
            products: [],
            product_id: '',
            buying_price: '',
            selling_price: '',
            errors: {}
        };
    },
    methods: {
        validateForm() {
            this.errors = {};
            if (!this.product_id) {
                this.errors.product_id = 'Product is required.';
            }
            if (!this.buying_price) {
                this.errors.buying_price = 'buying price is required.';
            }
            if (!this.selling_price) {
                this.errors.selling_price = 'selling price is required.';
            }
            return Object.keys(this.errors).length === 0;
        },
        storeProductPrice() {
            if (this.validateForm()) {
                const pData = {
                    product_id: this.product_id,
                    buying_price: this.buying_price,
                    selling_price: this.selling_price,
                };
                axios.post("http://127.0.0.1:8000/api/admin/productprice/", pData)
                    .then((response) => {
                        console.log(response);
                        this.$router.push('/admin/product-price/product-price-list');
                    })
                    .catch(error => {
                        console.error(error);
                        // Handle error
                    });
            }
        },
        getData() {
            axios.get('http://127.0.0.1:8000/api/admin/productprice/create')
                .then((result) => {
                    this.products = result.data.data.product_price;
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
        <h5 class="mb-0">Product price</h5>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <label class="form-label" for="usage-count-input">Buying Price</label>
            <input v-model="buying_price" type="number" class="form-control" id="usage-count-input"
                placeholder="buying price" />
            <small v-if="!buying_price" class="">Please enter buying Price.</small>
        </div>
        <div class="mb-3">
            <label class="form-label" for="usage-count-input">Selling Price</label>
            <input v-model="selling_price" type="number" class="form-control" id="usage-count-input"
                placeholder="selling price" />
            <small v-if="!selling_price" class="">Please enter selling Price.</small>
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
