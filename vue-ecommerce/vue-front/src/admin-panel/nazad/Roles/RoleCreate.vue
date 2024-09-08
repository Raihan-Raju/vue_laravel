<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms/</span> Vertical Layouts</h4>

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Users Form</h5>
                        <small class="text-muted float-end">Default label</small>
                    </div>
                    <div class="card-body">
                        <form v-on:submit.prevent="save">
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-fullname">Name</label>
                                <input type="text" v-model="name" class="form-control" id="basic-default-fullname"
                                    placeholder="John Doe" />
                            </div>
                            <button type="submit" class="btn btn-primary">Send</button>
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
            url: 'http://localhost:8000/api/admin/roles',
            name: "",

        }
    },
    methods: {
        save() {
            axios.post(this.url, {
                     name:this.name,
            })
                .then((response) => {
                    this.$router.push('/admin/roles');
                }, (error) => {
                    console.log(error);
                });

        },

    }
}
</script>