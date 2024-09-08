<script>
import axios from 'axios';

export default {
    data() {
        return {
            cupons: [],
            users: [],
            user_id: '',
            usage_count: '',
            cupon_id: '',
            errors: {}
        };
    },
    methods: {
        validateForm() {
            this.errors = {};
            if (!this.user_id) {
                this.errors.user_id = 'User is required.';
            }
            if (!this.cupon_id) {
                this.errors.cupon_id = 'Code is required.';
            }
            if (!this.usage_count) {
                this.errors.usage_count = 'Usage count is required.';
            }
            return Object.keys(this.errors).length === 0;
        },
        storeUsesCupons() {
            if (this.validateForm()) {
                const uData = {
                    user_id: this.user_id,
                    usage_count: this.usage_count,
                    cupon_id: this.cupon_id,
                };
                axios.post("http://127.0.0.1:8000/api/admin/couponusages", uData)
                    .then((response) => {
                        console.log(response);
                        this.$router.push('/admin/coupons/coupons-uselist');
                    })
                    .catch(error => {
                        console.error(error);
                        // Handle error
                    });
            }
        },
        getData() {
            axios.get('http://127.0.0.1:8000/api/admin/couponusages/create')
                .then((result) => {
                    this.cupons = result.data.data.ruhul;
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
        <h5 class="mb-0">Usage Cupons</h5>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <label class="form-label" for="user-select">User</label>
            <select id="user-select" class="form-select" v-model="user_id">
                <option disabled value="">Select a user</option>
                <option v-for="(u, i) in users" :key="i" :value="u.id">{{ u.name }}</option>
            </select>
            <small v-if="!user_id" class="">Please select a user.</small>
        </div>
        <div class="mb-3">
            <label class="form-label" for="code-select">Code</label>
            <select id="code-select" class="form-select" v-model="cupon_id">
                <option disabled value="">Select a code</option>
                <option v-for="(p, i) in cupons" :key="i" :value="p.id">{{ p.code }}</option>
            </select>
            <small v-if="!cupon_id" class="">Please select a code.</small>
        </div>
        <div class="mb-3">
            <label class="form-label" for="usage-count-input">Usage Count</label>
            <input v-model="usage_count" type="number" class="form-control" id="usage-count-input" placeholder="Enter usage count" />
            <small v-if="!usage_count" class="">Please enter usage count.</small>
        </div>
        <button @click="storeUsesCupons" type="submit" class="btn btn-primary">Submit</button>
    </div>
</template>


