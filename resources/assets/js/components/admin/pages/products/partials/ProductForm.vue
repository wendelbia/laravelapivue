<template>
	<div>
		<!--escuto o evento submit-->
		<form class="form" @submit.prevent="onSubmit">
			<!-- usando has podemos formatar o css-->
			<div :class="['form-group', {'has-error': errors.name}]">
				<!--no console do browse tenho o name que recebe o array que tem as propriedades do campo name que na posição zero tem o item que é a mensagem de erro faço um if para exibir a mensagem, ele mostra um erro de cadas vez, vamos pegar o da posição zero-->
				<div v-if="errors.name">{{ errors.name[0] }}</div>
				<input type="text" v-model="product.name" class="form-control" placeholder="Nome da produto">
			</div>

			<!-- usando has podemos formatar o css-->
			<div :class="['form-group', {'has-error': errors.description}]">
				<!--no console do browse tenho o name que recebe o array que tem as propriedades do campo name que na posição zero tem o item que é a mensagem de erro faço um if para exibir a mensagem, ele mostra um erro de cadas vez, vamos pegar o da posição zero-->
				<div v-if="errors.description">{{ errors.description[0] }}</div>
				<textarea v-model="product.description" cols="30" rows="10" class="form-control" placeholder="descrição do produto"></textarea>
			</div>

			<div :class="['form-group', {'has-error': errors.category_id}]">
				<div v-if="errors.category_id">{{ errors.category_id[0] }}</div>	
				<!--usando o data bind no select eu posso cadastrar um produto com uma categoria dinâmica-->				
				<select class="form-control" v-model="product.category_id">
					<!--crio uma propriedade computada-->
					<option value="">Selecione a categoria</option>
					<!--uso o for para listar, pego o category q é nossa propriedade computada-->
					<option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
				</select>
			</div>

			<div class="form-group">
				<button type="submit" class="btn btn-primary" @click="$emit('product')">Enviar</button>
			</div>
		</form>
	</div>
</template>

<script>
export default {
	//recebendo propriedade
	props: {
		//propriedade que informa se eu estou autorizando ou cadastrando
		update: {
			//ñ preciso informar
			require: false,
			//tipo booleano
			type: Boolean,
			//aqui mostra que o evento padrão está cadastrando e não editando 
			default: false
		},
		product: {
			//requered é usado para definir que aquela propriedade deve ser recebida, isto é ela é obrigatória 
			require: false,
			//type é usado para garantir que somente aquele tipo de dado será passado para o componente. é altamente recomendado usá-lo para evitar side-effects. Ele aceita os seguintes tipos: string, number, boolean, function, obejct, array e symbol
			type: Object,
			//default é usado para definirmos um valor padrão para aquela propriedade, caso a prop seja inexistente
			default: () => {
				return {
					id: '',
					name: '', 
					description: '',
					//image: '',
					//esse deve ser de um id existente
					category_id: '',
				}
			}
		}
	},
	data () {
		return {
			errors: {}
		}
	},
	computed: {
		categories () {
			//pego todos esses dados para manipulá-los e faço um array com o data pra listar nossas categoias
			return this.$store.state.categories.items.data
		}
	},
	methods: {
		onSubmit () {
			//se quisermos atualizar então updateProduct se não storeProduct
			let action = this.update ? 'updateProduct' : 'storeProduct'
			//this.product fará o two-way-data-bind, conforme for digitando os valores ele vai atualizando o product:{}
			//this.$store.dispatch('storeProduct', this.product)

			//agora vamos deixar mais genérico essa ordem 
			this.$store.dispatch(action, this.product)
			//agora criar uma action para gravar produto
					.then(() => {
						this.$snotify.success('Sucesso ao Enviar')

						//chamando o método reset () {}
						this.reset ()
						//confirmando que está ok
						//vou no coponent que despara lá em ProductComponent
						this.$emit('success')
						this.$emit(prod())

					})
					.catch(errors => {
						this.$snotify.error('Algo está Errado', 'Erro')

						this.errors = errors.data.errors
					})
		},
		//método para resetar o errors do formulário modal
		reset () {
			this.errors = {}
			//esse product é da propriedade computada
			this.product = {
					id: '',
					name: '', 
					description: '',
					//image: '',
					//esse deve ser de um id existente
					category_id: '',
				}
		},
		prod () {
			this.product = {
					id: '',
					name: '', 
					description: '',
					//image: '',
					//esse deve ser de um id existente
					category_id: '',
				}
		}
	}
}
	
</script>