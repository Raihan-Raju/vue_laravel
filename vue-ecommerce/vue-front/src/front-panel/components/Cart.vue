<script>
import { mapState, mapGetters, mapActions } from 'vuex';
export default {
	data() {
		return {
			num:0
		}
	},
	props: {
		cartShow: String,
	},
	methods: {
		updateSharedData(newValue) {
			this.$emit('update-shared-data', '');
		},
		...mapActions({
            addtocart: 'addcart',
            revcart: 'deleteCart'
        }),
		rev(id){
            this.revcart(id);
        }
	},
	computed: {
        // Compute the products in the cart from the Vuex store
        productsInCart() {
            return this.$store.state.cart.products;
        },
		...mapGetters(['totalPrice'])
    },
}
</script>

<template>
    <div :class="'wrap-header-cart js-panel-cart'+cartShow">
		<div class="s-full js-hide-cart"></div>

		<div class="header-cart flex-col-l p-l-65 p-r-25">
			<div class="header-cart-title flex-w flex-sb-m p-b-8">
				<span class="mtext-103 cl2">
					Your Cart
				</span>

				<div @click="updateSharedData" class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-cart">
					<i class="zmdi zmdi-close"></i>
				</div>
			</div>
			
			<div class="header-cart-content flex-w js-pscroll">
				<ul class="header-cart-wrapitem w-full">
					<li v-for="(p,i) in productsInCart" :key="i" class="header-cart-item flex-w flex-t m-b-12">
						<div @click="rev(p.id)" class="header-cart-item-img">
							<img :src="'http://127.0.0.1:8000/photos/products/' + p.photo.path" alt="IMG">
						</div>

						<div class="header-cart-item-txt p-t-8">
							<a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
								{{p.name}}
							</a>

							<span class="header-cart-item-info">
								{{ p.quantity }} x {{ p.price }}
							</span>
						</div>
					</li>
				</ul>
				
				<div class="w-full">
					<div class="header-cart-total w-full p-tb-40">
						Total: {{ totalPrice }}.00
					</div>

					<div class="header-cart-buttons flex-w w-full">
						<a href="shoping-cart.html" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-r-8 m-b-10">
							View Cart
						</a>

						<router-link @click="updateSharedData" :to="{name: 'cart'}" href="shoping-cart.html" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-b-10">
							Check Out
						</router-link>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>