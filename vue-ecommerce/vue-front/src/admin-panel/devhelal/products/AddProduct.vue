<script>
import axios from 'axios';
import { mapActions } from 'vuex';
export default {
    data() {
        return {
            url: this.$store.state.base.url+"admin/products",
            category_url:  this.$store.state.base.url+"admin/categorys",
            category_id: 0,
            name: "",
            price: "",
            description: "",
            sub_category_id: 0,
            path: null,
            productlist: [],
            categorylist: [],
            sub_categorylist: [],
            category_id_null: 0,
            imagePreview: null,
            nameError: "",

        }
    },
    methods: {
        // =================get all product list for chack already product exist and category sub-categore select ==============
        getProductList() {
            axios.get(this.url).then((response) => {
                const product = response.data.data[0];
                const category = response.data.data[1];
                this.productlist = product;
                this.categorylist = category;
            });
        },
        setCategory() {
            //================if category not select subCategory not show =============== 
            const id = ("dev Helal:", this.category_id);
            this.category_id_null = id;
            if (id !== 0 && this.category_id_null != 0) {
                axios.get(`${this.category_url}/${id}`).then((response) => {
                    const category = response.data.data.sub_category;
                    this.sub_categorylist = category;
                });
            }
            this.sub_categorylist = "";
            this.sub_category_id = 0;
        },
        onFileSelected(event) {
            // =============== upload file set ===================
            this.path = event.target.files[0];
            const file = event.target.files[0];
            if (file && file.type.startsWith('image/')) {
                this.createImagePreview(file);
            }
        },
        createImagePreview(file) {
            // ================= file show to see what is he upload? ==================
            const reader = new FileReader();
            reader.onload = (e) => {
                this.imagePreview = e.target.result;
            };
            reader.readAsDataURL(file);
        },
        save() {
            const formData = new FormData();
            formData.append('photo', this.path);
            const alldata = {
                category_id: this.category_id,
                name: this.name,
                price: this.price,
                description: this.description,
                sub_category_id: this.sub_category_id,
                path: this.path
            }
            axios.post(this.url, alldata, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then((response) => {
                this.$router.push({ name:'productslist' });
            });
        },
    },
    mounted() {
        this.getProductList();
    },
    watch: {
        name(newValue) {
            // =================== check if the name exists in the productlist array===============
            const nameExists = this.productlist.some(item => item.name === newValue);
            if (nameExists) {
                this.nameError = 'This Product Name is Already Taken.';
            } else {
                this.nameError = '';
            }
        }
    },
}
</script>
<template>
    <div class="container-xxl flex-grow-1 container-p-y text-dark">
        <div class="col-md-12 row">
            <div class="col-md-4 ">
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"></span> Add a New Product </h4>
            </div>
            <div class="col-md-3 "></div>
            <div class="col-md-5 ">
                <router-link :to="{ name: 'productslist' }" class="btn btn-outline-danger">Discard</router-link>
                <button class="btn btn-dark ml-2"> Save Draft</button>
                <button class="btn btn-primary ml-2" @click="save()"> Publish Product</button>
            </div>

        </div>
        <!-- Basic Layout -->
        <div class="row">
            <div class="col-8">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="text-dark">Product Information</h5>
                            <div class="row">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Product Name" v-model="name"
                                        :style="{ borderColor: nameError ? 'red' : '' }" />
                                </div>
                                <p v-if="nameError" style="color: red;">This name is already taken.</p>
                                <div class="form-floating mt-4">
                                    <textarea class="form-control" placeholder="Make Product Description Here"
                                        id="floatingTextarea2" style="height: 250px" v-model="description"></textarea>
                                    <label class="text-dark">Product Description</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="text-dark">Product Image</h5>
                            <div class="row">
                                <div class="input-group">
                                    <input type="file" class="form-control" @change="onFileSelected" />
                                </div>
                                <div class="card" style="width: 18rem;">
                                    <img v-if="imagePreview" :src="imagePreview" class="preview-image" />
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="text-dark">Pricing</h5>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Base Price" v-model="price" />
                        </div>
                        <div class="input-group mt-4">
                            <input type="text" class="form-control " placeholder="Discount Price" disabled />
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" checked />
                            <label class="form-check-label"> Charge Tax On This Product</label>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-10">In Stoke</div>
                            <div class="col-md-2">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" checked />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="text-dark">Organize</h5>
                        <div class="row">
                            <div class="col-md-10 mt-2">
                                <select class="form-select" v-model="category_id" @change="setCategory()">
                                    <option value="0">Category</option>
                                    <option v-for="(cdata, i) in categorylist" :key="i" :value="cdata.id">{{ cdata.name
                                        }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-1 mt-3">
                                <button class="btn btn-outline-info btn-sm">+</button>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-10 mt-2">
                                <select class="form-select col-md-10 mt-2" v-model="sub_category_id"
                                    :disabled="sub_categorylist == ''">
                                    <option value="0">Sub Category</option>
                                    <option v-for="(scdata, i) in sub_categorylist" :key="i" :value="scdata.id">
                                        {{ scdata.name }}</option>
                                </select>
                            </div>

                            <div class="col-md-1 mt-3">
                                <button class="btn btn-outline-info btn-sm">+</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10 mt-2">
                                <select class="form-select mt-2">
                                    <option selected>Vendor</option>
                                </select>
                            </div>
                            <div class="col-md-1 mt-3">

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10 mt-2">
                                <select class="form-select mt-2">
                                    <option selected>Collection</option>
                                    <option>New Model</option>
                                    <option>Golen Model</option>
                                </select>
                            </div>
                            <div class="col-md-1 mt-3">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10 mt-2">
                                <select class="form-select mt-2">
                                    <option selected>Status</option>
                                    <option>Publish</option>
                                    <option>Unpublish</option>
                                </select>
                            </div>
                            <div class="col-md-1 mt-3">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10 mt-2">
                                <select class="form-select mt-2">
                                    <option selected>Tag</option>
                                </select>
                            </div>
                            <div class="col-md-1 mt-3">
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </div>
</template>
