export default {
	state: {
		products: []
	},

	mutations: {
		ADD_PRODUCT_CART (state, product) {
			//push para incrementar um produto no final desse array
			state.products.push(product)
		},

		REMOVE_PRODUCT_CART (state, product) {
			let index = state.products.findIndex(prod => {
				return prod.id === product.id
			})
			
			state.products.splice (index, 1)
		}

	}
}