<script>
import axios from "axios";

export default {
  data() {
    return {
      url: this.$store.state.base.url+"admin/products",
      productlist: [],
    };
  },
  methods: {
    getProductList() {
      axios.get(this.url).then((response) => {
        this.productlist = response.data.data[0];
      });
    },
    deleteProduct(id) {
      axios.delete(`${this.url}/${id}`)
      .then((response) => {
                this.getProductList();
            });
      
    },
  },
  mounted() {
    this.getProductList();
  },
 components: {
  
	}
};
</script>
<template>
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
      <span class="text-muted fw-light">Product/</span> View All Product
    </h4>

    <!-- Basic Layout -->
    <div class="row">
      <div class="col-xl">
        <div class="card mb-4">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Filters</h5>
            <div class="col-md-12 row">
              <div class="col-md-4">
                <select name="" id="" class="form-select">
                  <option value="" selected>Select Status</option>
                  <option value="">Published</option>
                  <option value="">Unpublished</option>
                </select>
              </div>
              <div class="col-md-4">
                <select name="" id="" class="form-select">
                  <option value="" selected>Category</option>
                </select>
              </div>
              <div class="col-md-4">
                <select name="" id="" class="form-select">
                  <option value="" selected>In Stock</option>
                  <option value="">Out Stock</option>
                </select>
              </div>
            </div>
          </div>
          <div class="col-md-12 row d-flex justify-content-between align-items-center">
            <div class="row">
              <div class="col-md-3">
                <input type="text" class="form-control" placeholder="Search Product" />
              </div>
              <div class="col-md-5"></div>
              <div class="col-md-4">
                <button class="col-md-6 btn btn-dark">Export</button>
                <router-link :to="{ name: 'addproducts'}" class="col-md-6 btn btn-primary">Add Product</router-link>
              </div>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table m-0 table-striped">
              <thead class="bg-primary-subtle">
                <tr>
                  <th>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" />
                    </div>
                  </th>
                  <th>PRODUCT</th>
                  <th>CATEGORY</th>
                  <th>STOKE</th>
                  <th>PRICE</th>
                  <th>QTY</th>
                  <th>STATUS</th>

                  <th style="width: 230px" class="text-center">Action</th>
                </tr>
              </thead>
              <tbody v-for="(data, i) in productlist" :key="i" class="text-center">
                <tr>
                  <td>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" />
                    </div>
                  </td>
                  <td>
                    <div class="mb-3" style="max-width: 200px">
                      <div class="row g-0">
                        <div class="col-md-4">
                          <img :src="`http://127.0.0.1:8000/photos/products/${data.photo.path}`"
                            class="img-fluid rounded-start" alt="loading" />
                        </div>
                        <div class="col-md-8">
                          <div class="">
                            <h5 class="card-title">{{ data.name }}</h5>
                            <p class="card-text">{{ data.description.length <= 10 ? data.description : data.description.substr(0, 20) + '...' }}</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </td>
                  <td>{{ data.category.name }}</td>
                  <td>
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" role="switch" checked />
                    </div>
                  </td>
                  <td>{{ data.price }}</td>
                  <td>10</td>
                  <td>Published</td>
                  <td>
                    <button class="btn btn-primary btn-sm" @click="view(data.id)">
                      View
                    </button>
                    <router-link :to="{ name: 'updateproduct', params: { id: data.id } }" class="btn btn-success btn-sm mr-2">Edit</router-link>
                    <button class="btn btn-danger btn-sm" @click="deleteProduct(data.id)" >
                      Delete
                    </button>
                    <!-- <span class="text-primary"><i class='bx bx-show' @click="showProduct(data.id)"></i></span>
                    <span class="text-warning"><i class='bx bx-edit' @click="editProduct(data.id)"></i></span>
                    <span class="text-danger"><i class='bx bx-trash ' @click="deleteProduct(data.id)"></i></span> -->
                  </td>
                </tr>
              </tbody>
            </table>
            <span class="float-right"> </span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
