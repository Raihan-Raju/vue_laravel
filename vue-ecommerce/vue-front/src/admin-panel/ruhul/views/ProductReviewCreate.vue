<script>
import axios from 'axios';

export default {
    data() {
        return {
            products: [],
            users: [],
            content_text: '',
            rating: '',
            product_id: '',
            user_id: '',
            errors: {}
        };
    },
    methods: {
        validateForm() {
            this.errors = {};
            if (!this.user_id) {
                this.errors.user_id = 'User is required.';
            }
            if (!this.product_id) {
                this.errors.product_id = 'Product is required.';
            }
            if (!this.content_text) {
                this.errors.content_text = 'Content is required.';
            }
            if (!this.rating) {
                this.errors.rating = 'Rating is required.';
            }
            return Object.keys(this.errors).length === 0;
        },
        storeProductReview() {
            if (this.validateForm()) {
                const pData = {
                    content_text: this.content_text,
                    rating: this.rating,
                    user_id: this.user_id,
                    product_id: this.product_id,
                };
                axios.post("http://127.0.0.1:8000/api/admin/productreviews", pData)
                    .then((response) => {
                        console.log(response);
                        this.$router.push('/admin/product-review/product-review-list');
                    })
                    .catch(error => {
                        console.error(error);
                        // Handle error
                    });
            }
        },
        getData() {
            axios.get('http://127.0.0.1:8000/api/admin/productreviews/create')
                .then((result) => {
                    this.products = result.data.data.product_reviews;
                    this.users = result.data.data.users;
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
        <h5 class="mb-0">Product reviews</h5>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <label class="form-label" for="usage-count-input">Content</label>
            <input v-model="content_text" type="text" class="form-control" id="usage-count-input"
                placeholder="content here" />
            <small v-if="!content_text" class="">Please enter content here.</small>
        </div>
        <div class="mb-3">
            <label class="form-label" for="usage-count-input">Rating</label>
            <input v-model="rating" type="number" class="form-control" id="usage-count-input" placeholder="*****" />
            <small v-if="!rating" class="">Please enter rating.</small>
        </div>
        <div class="mb-3">
            <label class="form-label" for="user-select">User</label>
            <select id="user-select" class="form-select" v-model="user_id">
                <option disabled value="">Select a user</option>
                <option v-for="(u, i) in users" :key="i" :value="u.id">{{ u.name }}</option>
            </select>
            <small v-if="!user_id" class="">Please select a user.</small>
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

        <button @click="storeProductReview" type="submit" class="btn btn-primary">Submit</button>
    </div>
</template>
